<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CheckoutSession;
use App\Models\Order;
use App\Services\MidtransPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Midtrans\Config as MidtransConfig;
use Midtrans\Snap;
use Midtrans\Transaction;
use Throwable;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $user = Auth::user();
        $cart = Cart::with(['items.productVariant.product.images'])->where('user_id', $user->id)->first();
        $cartItems = $cart ? $cart->items : collect();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your shopping bag is empty.');
        }

        $subtotal = $cartItems->sum(function($item) {
            return $item->quantity * $item->productVariant->price;
        });

        // Fixed shipping cost for simplicity
        $shippingCost = 50000;
        $total = $subtotal + $shippingCost;

        return view('storefront.checkout.index', compact('cartItems', 'subtotal', 'shippingCost', 'total'));
    }

    public function pay(Request $request)
    {
        $request->validate([
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
        ]);

        $user = Auth::user();
        $cart = Cart::with(['items.productVariant'])->where('user_id', $user->id)->first();
        $cartItems = $cart ? $cart->items : collect();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index');
        }

        $subtotal = $cartItems->sum(function($item) {
            return $item->quantity * $item->productVariant->price;
        });
        $shippingCost = 50000;
        $total = $subtotal + $shippingCost;

        $orderNumber = 'ORD-SNC-' . strtoupper(Str::random(8));
        $snapshotItems = $cartItems->map(function ($item) {
            return [
                'product_variant_id' => $item->product_variant_id,
                'product_name' => $item->productVariant->product->name,
                'variant_name' => $item->productVariant->name,
                'quantity' => (int) $item->quantity,
                'unit_price' => (float) $item->productVariant->price,
                'subtotal' => (float) ($item->quantity * $item->productVariant->price),
            ];
        })->values()->all();

        CheckoutSession::create([
            'user_id' => $user->id,
            'order_number' => $orderNumber,
            'recipient_name' => $request->recipient_name,
            'phone' => $request->phone,
            'shipping_address' => $request->shipping_address,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'cart_snapshot' => $snapshotItems,
            'subtotal' => $subtotal,
            'shipping_cost' => $shippingCost,
            'total_price' => $total,
            'status' => 'pending',
        ]);

        MidtransConfig::$serverKey = config('midtrans.server_key');
        MidtransConfig::$isProduction = (bool) config('midtrans.is_production');
        MidtransConfig::$isSanitized = (bool) config('midtrans.sanitize');
        MidtransConfig::$is3ds = (bool) config('midtrans.enable_3ds');

        $itemDetails = $cartItems->map(function ($item) {
            return [
                'id' => (string) $item->product_variant_id,
                'price' => (int) $item->productVariant->price,
                'quantity' => (int) $item->quantity,
                'name' => $item->productVariant->product->name . ' - ' . $item->productVariant->name,
            ];
        })->values()->all();

        $itemDetails[] = [
            'id' => 'shipping',
            'price' => (int) $shippingCost,
            'quantity' => 1,
            'name' => 'Shipping Cost',
        ];

        $params = [
            'transaction_details' => [
                'order_id' => $orderNumber,
                'gross_amount' => (int) $total,
            ],
            'customer_details' => [
                'first_name' => $request->recipient_name,
                'email' => $user->email,
                'phone' => $request->phone,
                'shipping_address' => [
                    'first_name' => $request->recipient_name,
                    'phone' => $request->phone,
                    'address' => $request->shipping_address,
                    'city' => $request->city,
                    'postal_code' => $request->postal_code,
                    'country_code' => 'IDN',
                ],
            ],
            'item_details' => $itemDetails,
            'callbacks' => [
                'finish' => route('checkout.success', $orderNumber),
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        return response()->json([
            'snapToken' => $snapToken,
            'order_number' => $orderNumber,
        ]);
    }

    public function success($order_number)
    {
        $order = Order::with(['items.productVariant.product'])
            ->where('order_number', $order_number)
            ->where('user_id', Auth::id())
            ->first();

        if (! $order) {
            MidtransConfig::$serverKey = config('midtrans.server_key');
            MidtransConfig::$isProduction = (bool) config('midtrans.is_production');
            MidtransConfig::$isSanitized = (bool) config('midtrans.sanitize');
            MidtransConfig::$is3ds = (bool) config('midtrans.enable_3ds');

            try {
                $status = Transaction::status($order_number);
                $payload = json_decode(json_encode($status), true) ?? [];
                (new MidtransPaymentService())->handleNotification($payload);
                $order = Order::with(['items.productVariant.product'])
                    ->where('order_number', $order_number)
                    ->where('user_id', Auth::id())
                    ->first();
            } catch (Throwable $e) {
            }
        }

        if (! $order) {
            abort(404);
        }

        if ($order->status !== 'paid') {
            MidtransConfig::$serverKey = config('midtrans.server_key');
            MidtransConfig::$isProduction = (bool) config('midtrans.is_production');
            MidtransConfig::$isSanitized = (bool) config('midtrans.sanitize');
            MidtransConfig::$is3ds = (bool) config('midtrans.enable_3ds');

            try {
                $status = Transaction::status($order->order_number);
                $payload = json_decode(json_encode($status), true) ?? [];
                (new MidtransPaymentService())->handleNotification($payload);
                $order->refresh();
            } catch (Throwable $e) {
            }
        }

        return view('storefront.checkout.success', compact('order'));
    }
}
