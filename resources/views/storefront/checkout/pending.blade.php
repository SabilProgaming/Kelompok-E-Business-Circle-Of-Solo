@extends('layouts.app')

@section('title', 'Payment Processing - Sanctum')

@section('content')
<div class="pt-32 pb-24 px-6 md:px-24 bg-luxury-cream min-h-screen flex items-center justify-center">
    <div class="max-w-2xl w-full">
        <div class="bg-white p-12 md:p-16 shadow-2xl border border-luxury-gold/20 text-center">
            <span class="text-luxury-gold text-[9px] font-bold tracking-[0.5em] uppercase">Processing</span>
            <h1 class="text-3xl md:text-4xl font-serif font-light mt-3">Payment <span class="italic">Pending</span></h1>
            <p class="text-sm text-luxury-charcoal/50 mt-4">We are confirming your payment with Midtrans. Please wait a moment and refresh this page.</p>

            <div class="mt-8 text-[10px] uppercase tracking-[0.2em] text-luxury-charcoal/50">Order Number</div>
            <div class="font-mono text-lg text-luxury-charcoal mt-2">{{ $orderNumber }}</div>

            <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                <button type="button" id="refresh-status" class="px-8 py-3 bg-luxury-gold text-white text-[10px] uppercase tracking-[0.3em] font-bold hover:bg-luxury-charcoal transition-colors duration-500">
                    Refresh Status
                </button>
                <a href="{{ route('user.dashboard') }}" class="px-8 py-3 border border-luxury-charcoal/20 text-[10px] uppercase tracking-[0.3em] font-bold text-luxury-charcoal hover:bg-luxury-charcoal hover:text-white transition-colors duration-500">
                    My Orders
                </a>
            </div>

            <p id="pending-error" class="text-xs text-red-500 mt-6 hidden"></p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const refreshButton = document.getElementById('refresh-status');
    const pendingError = document.getElementById('pending-error');
    const orderNumber = @json($orderNumber);

    const confirmPayment = async () => {
        const response = await fetch("{{ route('checkout.confirm') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ order_id: orderNumber })
        });

        const payload = await response.json().catch(() => ({}));
        if (!response.ok) {
            throw new Error(payload?.message || 'Payment confirmation failed.');
        }

        return payload;
    };

    const handleRefresh = async () => {
        if (pendingError) {
            pendingError.classList.add('hidden');
        }

        try {
            await confirmPayment();
            window.location.href = "{{ route('checkout.success', '__ORDER__') }}".replace('__ORDER__', orderNumber);
        } catch (error) {
            if (pendingError) {
                pendingError.textContent = error.message || 'Payment confirmation failed.';
                pendingError.classList.remove('hidden');
            }
        }
    };

    refreshButton?.addEventListener('click', handleRefresh);
    setTimeout(handleRefresh, 1500);
</script>
@endpush
