@extends('layouts.app')

@section('title', 'Complete Payment - Sanctum')

@section('content')
<div class="pt-32 pb-24 px-6 md:px-24 bg-luxury-cream min-h-screen">
    <div class="max-w-6xl mx-auto">
        <div class="mb-12">
            <span class="text-luxury-gold text-[9px] font-bold tracking-[0.5em] uppercase">Secure Payment</span>
            <h1 class="text-4xl font-serif font-light mt-2">Finalize <span class="italic">Payment</span></h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <div class="lg:col-span-7 space-y-8">
                <div class="bg-white p-8 md:p-12 border border-luxury-gold/10">
                    <h2 class="text-xl font-serif italic mb-6">Order Details</h2>
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                        <div class="flex justify-between text-sm">
                            <div>
                                <p class="font-serif">{{ $item->product_name ?? $item->productVariant?->product?->name }}</p>
                                <p class="text-[10px] text-luxury-charcoal/50 uppercase tracking-widest">{{ $item->variant_name ?? $item->productVariant?->name }} x{{ $item->quantity }}</p>
                            </div>
                            <span class="font-mono">Rp {{ number_format($item->subtotal ?? ($item->unit_price * $item->quantity), 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    </div>

                    <div class="border-t border-luxury-charcoal/10 mt-8 pt-6 space-y-3 text-sm">
                        <div class="flex justify-between text-luxury-charcoal/70">
                            <span>Subtotal</span>
                            <span class="font-mono">Rp {{ number_format($order->total_price - $order->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-luxury-charcoal/70">
                            <span>Shipping</span>
                            <span class="font-mono">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-lg pt-4 border-t border-luxury-charcoal/10">
                            <span class="font-serif italic">Total</span>
                            <span class="font-mono text-luxury-gold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 md:p-12 border border-luxury-gold/10">
                    <h2 class="text-xl font-serif italic mb-6">Payment</h2>
                    <p class="text-sm text-luxury-charcoal/60 mb-6">Click the button below to complete payment securely via Midtrans.</p>
                    <button id="pay-button" class="w-full py-4 bg-luxury-gold text-white text-[10px] uppercase tracking-[0.3em] font-bold hover:bg-luxury-charcoal transition-colors duration-500">
                        Pay Now
                    </button>
                    <p id="payment-error" class="text-xs text-red-500 mt-4 hidden">Payment failed. Please try again.</p>
                </div>
            </div>

            <div class="lg:col-span-5">
                <div class="bg-luxury-charcoal text-white p-8 md:p-12 sticky top-32">
                    <h2 class="text-xl font-serif italic mb-8 border-b border-white/10 pb-4">Order Summary</h2>
                    <div class="space-y-4 text-sm">
                        <div class="flex justify-between text-white/70">
                            <span>Order Number</span>
                            <span class="font-mono">{{ $order->order_number }}</span>
                        </div>
                        <div class="flex justify-between text-white/70">
                            <span>Recipient</span>
                            <span class="font-mono">{{ $order->recipient_name }}</span>
                        </div>
                        <div class="flex justify-between text-white/70">
                            <span>Phone</span>
                            <span class="font-mono">{{ $order->phone }}</span>
                        </div>
                        <div class="flex justify-between text-white/70">
                            <span>Payment Method</span>
                            <span class="font-mono capitalize">{{ str_replace('_', ' ', $order->payment_method) }}</span>
                        </div>
                    </div>

                    <div class="mt-10 text-[10px] uppercase tracking-[0.3em] text-white/50">Secure checkout powered by Midtrans</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    document.getElementById('pay-button').addEventListener('click', function () {
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function () {
                window.location.href = "{{ route('checkout.success', $order->order_number) }}";
            },
            onPending: function () {
                window.location.href = "{{ route('checkout.success', $order->order_number) }}";
            },
            onError: function () {
                const errorNode = document.getElementById('payment-error');
                if (errorNode) {
                    errorNode.classList.remove('hidden');
                }
            },
            onClose: function () {
                const errorNode = document.getElementById('payment-error');
                if (errorNode) {
                    errorNode.textContent = 'Payment popup closed. You can retry anytime.';
                    errorNode.classList.remove('hidden');
                }
            }
        });
    });
</script>
@endpush
