@extends('layouts.app')

@section('title', "Checkout - Sanctum")

@section('content')
<div class="pt-32 pb-24 px-6 md:px-24 bg-luxury-cream min-h-screen">
    <div class="max-w-7xl mx-auto">
        <div class="mb-12">
            <span class="text-luxury-gold text-[9px] font-bold tracking-[0.5em] uppercase">Secure Checkout</span>
            <h1 class="text-4xl font-serif font-light mt-2">Complete Your <span class="italic">Order</span></h1>
        </div>

        <form id="checkout-form" method="POST" action="{{ route('checkout.pay') }}" class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            @csrf
            
            {{-- Form Kiri --}}
            <div class="lg:col-span-7 space-y-12">
                
                {{-- Shipping Information --}}
                <div class="bg-white p-8 md:p-12 border border-luxury-gold/10">
                    <h2 class="text-xl font-serif italic mb-8 border-b border-luxury-gold/10 pb-4">Shipping Details</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] uppercase tracking-[0.2em] text-luxury-charcoal/60">Recipient Name</label>
                            <input type="text" name="recipient_name" required value="{{ auth()->user()->name }}" class="w-full border-b border-luxury-charcoal/20 py-2 focus:outline-none focus:border-luxury-gold bg-transparent text-sm transition-colors">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] uppercase tracking-[0.2em] text-luxury-charcoal/60">Phone Number</label>
                            <input type="text" name="phone" required class="w-full border-b border-luxury-charcoal/20 py-2 focus:outline-none focus:border-luxury-gold bg-transparent text-sm transition-colors">
                        </div>
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-[10px] uppercase tracking-[0.2em] text-luxury-charcoal/60">Complete Address</label>
                            <textarea name="shipping_address" required rows="3" class="w-full border-b border-luxury-charcoal/20 py-2 focus:outline-none focus:border-luxury-gold bg-transparent text-sm transition-colors resize-none"></textarea>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] uppercase tracking-[0.2em] text-luxury-charcoal/60">City</label>
                            <input type="text" name="city" required class="w-full border-b border-luxury-charcoal/20 py-2 focus:outline-none focus:border-luxury-gold bg-transparent text-sm transition-colors">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] uppercase tracking-[0.2em] text-luxury-charcoal/60">Postal Code</label>
                            <input type="text" name="postal_code" required class="w-full border-b border-luxury-charcoal/20 py-2 focus:outline-none focus:border-luxury-gold bg-transparent text-sm transition-colors">
                        </div>
                    </div>
                </div>

                <input type="hidden" name="payment_method" value="midtrans">

                <div class="bg-white p-8 md:p-12 border border-luxury-gold/10">
                    <h2 class="text-xl font-serif italic mb-6 border-b border-luxury-gold/10 pb-4">Payment Method</h2>
                    <p class="text-sm text-luxury-charcoal/60 leading-relaxed">
                        You will choose your payment method securely on the next step using Midtrans. All supported options like bank transfer, e-wallets, and QRIS will appear in the Midtrans popup.
                    </p>
                </div>
            </div>

            {{-- Summary Kanan --}}
            <div class="lg:col-span-5">
                <div class="bg-luxury-charcoal text-white p-8 md:p-12 sticky top-32">
                    <h2 class="text-xl font-serif italic mb-8 border-b border-white/10 pb-4">Order Summary</h2>
                    
                    <div class="space-y-6 mb-8 max-h-[40vh] overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($cartItems as $item)
                        <div class="flex gap-4">
                            <div class="w-16 h-20 bg-white/5 flex-shrink-0">
                                @php($img = $item->productVariant->product->images->first()?->image_url)
                                @if($img)
                                <img src="{{ \Illuminate\Support\Str::startsWith($img, ['http://', 'https://', '/']) ? $img : asset('storage/' . ltrim($img, '/')) }}" class="w-full h-full object-cover opacity-80" alt="{{ $item->productVariant->product->name }}">
                                @endif
                            </div>
                            <div class="flex-1 text-sm">
                                <p class="font-serif">{{ $item->productVariant->product->name }}</p>
                                <p class="text-[10px] text-white/50 tracking-widest uppercase mt-1">{{ $item->productVariant->name }} x{{ $item->quantity }}</p>
                                <p class="text-luxury-gold mt-2 font-mono text-xs">Rp {{ number_format($item->productVariant->price * $item->quantity, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="space-y-4 border-t border-white/10 pt-6 text-sm">
                        <div class="flex justify-between text-white/70">
                            <span>Subtotal</span>
                            <span class="font-mono">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-white/70">
                            <span>Shipping</span>
                            <span class="font-mono">Rp {{ number_format($shippingCost, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-lg pt-4 border-t border-white/10">
                            <span class="font-serif italic">Total</span>
                            <span class="font-mono text-luxury-gold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <button type="button" id="pay-button" class="w-full mt-10 py-5 bg-luxury-gold hover:bg-white hover:text-luxury-charcoal transition-colors duration-500 text-[10px] uppercase tracking-[0.3em] font-bold text-white">
                        Pay Now
                    </button>
                    <p id="payment-error" class="text-xs text-red-500 mt-4 hidden">Payment failed. Please try again.</p>
                    
                    <p class="text-[9px] text-center text-white/40 mt-6 leading-relaxed">
                        By placing your order, you agree to our Terms of Service and Privacy Policy. Secure payment processing provided by Sanctum.
                    </p>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    const checkoutForm = document.getElementById('checkout-form');
    const payButton = document.getElementById('pay-button');
    const paymentError = document.getElementById('payment-error');

    if (checkoutForm && payButton) {
        payButton.addEventListener('click', async () => {
            payButton.disabled = true;
            paymentError?.classList.add('hidden');

            try {
                const formData = new FormData(checkoutForm);
                const response = await fetch(checkoutForm.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                if (!response.ok) {
                    throw new Error('Failed to start payment');
                }

                const data = await response.json();

                if (!data.snapToken || !data.order_number) {
                    throw new Error('Missing payment token');
                }

                window.snap.pay(data.snapToken, {
                    onSuccess: function () {
                        window.location.href = "{{ route('checkout.success', '__ORDER__') }}".replace('__ORDER__', data.order_number);
                    },
                    onPending: function () {
                        window.location.href = "{{ route('checkout.success', '__ORDER__') }}".replace('__ORDER__', data.order_number);
                    },
                    onError: function () {
                        if (paymentError) {
                            paymentError.classList.remove('hidden');
                        }
                    },
                    onClose: function () {
                        if (paymentError) {
                            paymentError.textContent = 'Payment popup closed. You can retry anytime.';
                            paymentError.classList.remove('hidden');
                        }
                    }
                });
            } catch (error) {
                if (paymentError) {
                    paymentError.textContent = 'Payment initialization failed. Please check your details.';
                    paymentError.classList.remove('hidden');
                }
            } finally {
                payButton.disabled = false;
            }
        });
    }
</script>
@endpush
