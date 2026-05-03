<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
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

    public function process(Request $request)
    {
        $request->validate([
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'payment_method' => 'required|in:bank_transfer,credit_card,ewallet',
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

        // Create Order
        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'ORD-SNC-' . strtoupper(Str::random(6)),
            'recipient_name' => $request->recipient_name,
            'phone' => $request->phone,
            'shipping_address' => $request->shipping_address,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'payment_method' => $request->payment_method,
            'total_price' => $total,
            'shipping_cost' => $shippingCost,
            'status' => 'pending',
        ]);

        // Create Order Items
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_variant_id' => $item->product_variant_id,
                'quantity' => $item->quantity,
                'price' => $item->productVariant->price,
            ]);
        }

        // Clear Cart
        if ($cart) {
            $cart->items()->delete();
            $cart->delete();
        }

        return redirect()->route('checkout.success', $order->order_number);
    }

    public function success($order_number)
    {
        $order = Order::with(['items.productVariant.product'])->where('order_number', $order_number)->where('user_id', Auth::id())->firstOrFail();
        return view('storefront.checkout.success', compact('order'));
    }
}
