<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\CheckoutSession;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;

class MidtransPaymentService
{
    public function handleNotification(array $payload): void
    {
        $orderNumber = $payload['order_id'] ?? null;
        if (! $orderNumber) {
            return;
        }

        $transactionStatus = $payload['transaction_status'] ?? null;
        $fraudStatus = $payload['fraud_status'] ?? null;

        $paymentStatus = 'pending';
        $orderStatus = 'pending';
        $paidAt = null;

        if ($transactionStatus === 'capture') {
            if ($fraudStatus === 'challenge') {
                $paymentStatus = 'pending';
                $orderStatus = 'pending';
            } else {
                $paymentStatus = 'success';
                $orderStatus = 'paid';
                $paidAt = now();
            }
        } elseif ($transactionStatus === 'settlement') {
            $paymentStatus = 'success';
            $orderStatus = 'paid';
            $paidAt = now();
        } elseif ($transactionStatus === 'pending') {
            $paymentStatus = 'pending';
            $orderStatus = 'pending';
        } elseif (in_array($transactionStatus, ['deny', 'cancel'], true)) {
            $paymentStatus = 'failed';
            $orderStatus = 'cancelled';
        } elseif ($transactionStatus === 'expire') {
            $paymentStatus = 'expired';
            $orderStatus = 'cancelled';
        } elseif (in_array($transactionStatus, ['refund', 'chargeback'], true)) {
            $paymentStatus = 'refunded';
            $orderStatus = 'cancelled';
        }

        $order = Order::where('order_number', $orderNumber)->first();
        $checkoutSession = CheckoutSession::where('order_number', $orderNumber)->first();

        if (! $order && ! $checkoutSession) {
            return;
        }

        DB::transaction(function () use ($order, $checkoutSession, $payload, $paymentStatus, $orderStatus, $paidAt): void {
            $wasPaid = $order?->status === 'paid';

            if (! $order && $paymentStatus === 'success' && $checkoutSession) {
                $order = Order::create([
                    'user_id' => $checkoutSession->user_id,
                    'order_number' => $checkoutSession->order_number,
                    'recipient_name' => $checkoutSession->recipient_name,
                    'phone' => $checkoutSession->phone,
                    'shipping_address' => $checkoutSession->shipping_address,
                    'city' => $checkoutSession->city,
                    'postal_code' => $checkoutSession->postal_code,
                    'payment_method' => 'midtrans',
                    'total_price' => $checkoutSession->total_price,
                    'shipping_cost' => $checkoutSession->shipping_cost,
                    'status' => 'paid',
                ]);

                foreach ($checkoutSession->cart_snapshot ?? [] as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_variant_id' => $item['product_variant_id'] ?? null,
                        'product_name' => $item['product_name'] ?? 'Unknown',
                        'variant_name' => $item['variant_name'] ?? null,
                        'quantity' => $item['quantity'] ?? 1,
                        'unit_price' => $item['unit_price'] ?? 0,
                        'subtotal' => $item['subtotal'] ?? 0,
                    ]);
                }
            }

            if (! $order) {
                return;
            }

            $payment = Payment::firstOrCreate(
                ['order_id' => $order->id],
                ['midtrans_order_id' => $payload['order_id'] ?? null]
            );

            $payment->fill([
                'payment_status' => $paymentStatus,
                'midtrans_order_id' => $payload['order_id'] ?? null,
                'transaction_id' => $payload['transaction_id'] ?? null,
                'payment_type' => $payload['payment_type'] ?? null,
                'transaction_status' => $payload['transaction_status'] ?? null,
                'fraud_status' => $payload['fraud_status'] ?? null,
                'gross_amount' => $payload['gross_amount'] ?? 0,
                'status_message' => $payload['status_message'] ?? null,
                'raw_response' => $payload,
            ]);

            if ($paidAt) {
                $payment->paid_at = $paidAt;
            }

            $payment->save();
            if ($paymentStatus === 'success') {
                $order->update(['status' => 'paid']);
            }

            if ($paymentStatus === 'success' && ! $wasPaid) {
                $order->loadMissing('items');

                foreach ($order->items as $item) {
                    if (! $item->product_variant_id) {
                        continue;
                    }

                    ProductVariant::where('id', $item->product_variant_id)
                        ->where('stock', '>', 0)
                        ->decrement('stock', $item->quantity);
                }

                if ($checkoutSession) {
                    $variantIds = collect($checkoutSession->cart_snapshot)
                        ->pluck('product_variant_id')
                        ->filter()
                        ->values();

                    if ($variantIds->isNotEmpty()) {
                        CartItem::query()
                            ->whereHas('cart', fn ($query) => $query->where('user_id', $checkoutSession->user_id))
                            ->whereIn('product_variant_id', $variantIds)
                            ->delete();
                    }

                    $cart = Cart::where('user_id', $checkoutSession->user_id)->first();
                    if ($cart && $cart->items()->count() === 0) {
                        $cart->delete();
                    }

                    $checkoutSession->delete();
                }
            }
        });
    }
}
