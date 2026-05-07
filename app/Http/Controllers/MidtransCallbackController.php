<?php

namespace App\Http\Controllers;

use App\Models\CheckoutSession;
use App\Models\Order;
use App\Services\MidtransPaymentService;
use Illuminate\Http\Request;
use Midtrans\Config as MidtransConfig;

class MidtransCallbackController extends Controller
{
    public function handle(Request $request)
    {
        MidtransConfig::$serverKey = config('midtrans.server_key');
        MidtransConfig::$isProduction = (bool) config('midtrans.is_production');
        MidtransConfig::$isSanitized = (bool) config('midtrans.sanitize');
        MidtransConfig::$is3ds = (bool) config('midtrans.enable_3ds');

        $payload = $request->all();
        $signatureKey = $payload['signature_key'] ?? null;

        if (! $signatureKey) {
            return response()->json(['message' => 'Missing signature'], 403);
        }

        $expectedSignature = hash(
            'sha512',
            ($payload['order_id'] ?? '') . ($payload['status_code'] ?? '') . ($payload['gross_amount'] ?? '') . config('midtrans.server_key')
        );

        if (! hash_equals($expectedSignature, $signatureKey)) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $orderId = $payload['order_id'] ?? null;
        if (! $orderId) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order = Order::where('order_number', $orderId)->first();
        $checkoutSession = CheckoutSession::where('order_number', $orderId)->first();

        if (! $order && ! $checkoutSession) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        (new MidtransPaymentService())->handleNotification($payload);

        return response()->json(['message' => 'Notification handled']);
    }
}
