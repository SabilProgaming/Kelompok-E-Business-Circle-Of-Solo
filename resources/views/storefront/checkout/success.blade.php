@extends('layouts.app')

@section('title', "Order Confirmed - Sanctum")

@section('content')
<div class="pt-32 pb-24 px-6 md:px-24 bg-luxury-cream min-h-screen flex items-center justify-center">
    <div class="max-w-3xl w-full">
        
        <div class="bg-white p-12 md:p-20 shadow-2xl relative overflow-hidden border border-luxury-gold/20">
            <!-- Decorative Elements -->
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-luxury-gold/40 via-luxury-gold to-luxury-gold/40"></div>
            <div class="absolute top-12 left-12 w-20 h-20 bg-luxury-gold/5 rounded-full blur-2xl"></div>
            <div class="absolute bottom-12 right-12 w-32 h-32 bg-luxury-charcoal/5 rounded-full blur-3xl"></div>

            <div class="text-center mb-12 relative z-10">
                <div class="w-20 h-20 bg-luxury-gold text-white rounded-full flex items-center justify-center mx-auto mb-8 shadow-lg">
                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                </div>
                <span class="text-luxury-gold text-[9px] font-bold tracking-[0.5em] uppercase">Gratitude</span>
                <h1 class="text-4xl font-serif font-light mt-2">Order <span class="italic">Confirmed</span></h1>
                <p class="text-sm text-luxury-charcoal/50 mt-4 max-w-md mx-auto">Your artisanal fragrance journey begins. We have received your order and are currently preparing it with the utmost care.</p>
            </div>

            <div class="border-y border-luxury-charcoal/10 py-8 mb-8 flex flex-col md:flex-row justify-between text-center md:text-left gap-6 relative z-10">
                <div>
                    <p class="text-[9px] uppercase tracking-[0.2em] text-luxury-charcoal/40 mb-1">Order Number</p>
                    <p class="font-mono font-bold text-luxury-charcoal">{{ $order->order_number }}</p>
                </div>
                <div>
                    <p class="text-[9px] uppercase tracking-[0.2em] text-luxury-charcoal/40 mb-1">Date</p>
                    <p class="font-serif text-luxury-charcoal">{{ $order->created_at->format('d F Y, H:i') }}</p>
                </div>
                <div>
                    <p class="text-[9px] uppercase tracking-[0.2em] text-luxury-charcoal/40 mb-1">Payment Method</p>
                    <p class="font-serif text-luxury-charcoal capitalize">{{ str_replace('_', ' ', $order->payment_method) }}</p>
                </div>
            </div>

            <div class="space-y-4 mb-12 relative z-10">
                @foreach($order->items as $item)
                <div class="flex justify-between items-center py-2">
                    <div class="flex items-center gap-4">
                        <span class="text-sm font-serif">{{ $item->productVariant->product->name }}</span>
                        <span class="text-[10px] text-luxury-charcoal/40 uppercase tracking-widest">{{ $item->productVariant->name }} x{{ $item->quantity }}</span>
                    </div>
                    <span class="font-mono text-xs text-luxury-charcoal/70">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                </div>
                @endforeach
            </div>

            <div class="border-t border-luxury-charcoal/10 pt-6 space-y-3 relative z-10">
                <div class="flex justify-between text-sm text-luxury-charcoal/60">
                    <span>Subtotal</span>
                    <span class="font-mono">Rp {{ number_format($order->total_price - $order->shipping_cost, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm text-luxury-charcoal/60">
                    <span>Shipping</span>
                    <span class="font-mono">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-xl font-bold pt-4 border-t border-luxury-charcoal/10">
                    <span class="font-serif italic text-luxury-charcoal">Total</span>
                    <span class="font-mono text-luxury-gold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="mt-16 text-center space-x-4 relative z-10">
                <a href="{{ route('products.index') }}" class="inline-block px-8 py-3 border border-luxury-charcoal/20 text-[10px] uppercase tracking-[0.3em] font-bold text-luxury-charcoal hover:bg-luxury-charcoal hover:text-white transition-colors duration-500">
                    Continue Shopping
                </a>
                <a href="{{ route('user.dashboard') }}" class="inline-block px-8 py-3 bg-luxury-gold text-[10px] uppercase tracking-[0.3em] font-bold text-white hover:bg-luxury-charcoal transition-colors duration-500">
                    View Dashboard
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
