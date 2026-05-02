@extends('layouts.app')

@section('title', "My Dashboard - Sanctum")

@section('content')
<div class="pt-32 pb-24 px-6 md:px-24 bg-luxury-cream min-h-screen">
    <div class="max-w-7xl mx-auto">
        <div class="mb-16 border-b border-luxury-gold/20 pb-8 flex justify-between items-end">
            <div>
                <span class="text-luxury-gold text-[9px] font-bold tracking-[0.5em] uppercase">Private Member</span>
                <h1 class="text-4xl font-serif font-light mt-2">Welcome, <span class="italic">{{ explode(' ', $user->name)[0] }}</span></h1>
            </div>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-[10px] uppercase tracking-[0.3em] font-bold text-luxury-charcoal/50 hover:text-red-500 transition-colors">
                    Sign Out
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-12">
            {{-- Sidebar Nav --}}
            <div class="lg:col-span-1 space-y-6">
                <a href="{{ route('user.dashboard') }}" class="block px-6 py-4 bg-luxury-charcoal text-white text-[10px] uppercase tracking-[0.3em] font-bold border-l-2 border-luxury-gold">
                    Order History
                </a>
                <a href="{{ route('wishlist.index') }}" class="block px-6 py-4 bg-white/50 text-luxury-charcoal text-[10px] uppercase tracking-[0.3em] font-bold hover:bg-white transition-colors border-l-2 border-transparent hover:border-luxury-gold/50">
                    My Wishlist
                </a>
                <a href="{{ route('profile.edit') }}" class="block px-6 py-4 bg-white/50 text-luxury-charcoal text-[10px] uppercase tracking-[0.3em] font-bold hover:bg-white transition-colors border-l-2 border-transparent hover:border-luxury-gold/50">
                    Account Settings
                </a>
            </div>

            {{-- Main Content --}}
            <div class="lg:col-span-3 space-y-8">
                <h2 class="text-2xl font-serif italic mb-6">Your Previous Orders</h2>

                @forelse($orders as $order)
                <div class="bg-white border border-luxury-gold/10 hover:border-luxury-gold/30 transition-colors duration-500">
                    <div class="p-6 md:p-8 flex flex-col md:flex-row justify-between items-start md:items-center border-b border-luxury-charcoal/5 gap-4">
                        <div>
                            <p class="text-[10px] uppercase tracking-[0.2em] text-luxury-charcoal/40 mb-1">Order Number</p>
                            <p class="font-mono font-bold text-luxury-charcoal">{{ $order->order_number }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase tracking-[0.2em] text-luxury-charcoal/40 mb-1">Date Placed</p>
                            <p class="font-serif text-sm">{{ $order->created_at->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase tracking-[0.2em] text-luxury-charcoal/40 mb-1">Total</p>
                            <p class="font-mono font-bold text-luxury-gold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <span class="px-4 py-1.5 text-[9px] uppercase tracking-[0.2em] font-bold rounded-full 
                                {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 
                                  ($order->status === 'completed' ? 'bg-green-100 text-green-700' : 'bg-luxury-charcoal/10 text-luxury-charcoal') }}">
                                {{ $order->status }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="p-6 md:p-8 space-y-6">
                        @foreach($order->items as $item)
                        <div class="flex items-center gap-6">
                            <div class="w-16 h-20 bg-luxury-cream">
                                @php($img = $item->productVariant->product->images->first()?->image_url)
                                @if($img)
                                <img src="{{ \Illuminate\Support\Str::startsWith($img, ['http://', 'https://', '/']) ? $img : asset('storage/' . ltrim($img, '/')) }}" class="w-full h-full object-cover" alt="{{ $item->productVariant->product->name }}">
                                @endif
                            </div>
                            <div class="flex-1">
                                <h3 class="font-serif text-lg">{{ $item->productVariant->product->name }}</h3>
                                <p class="text-[10px] uppercase tracking-widest text-luxury-charcoal/50 mt-1">{{ $item->productVariant->name }} • Qty: {{ $item->quantity }}</p>
                            </div>
                            <div class="hidden md:block">
                                <a href="{{ route('products.show', $item->productVariant->product) }}" class="text-[9px] uppercase tracking-[0.2em] font-bold text-luxury-gold hover:text-luxury-charcoal transition-colors">View Product</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @empty
                <div class="text-center py-20 bg-white border border-luxury-gold/10">
                    <p class="font-serif italic text-2xl text-luxury-charcoal/30 mb-6">No orders have been placed yet.</p>
                    <a href="{{ route('products.index') }}" class="luxury-button inline-block text-[10px] tracking-[0.3em] px-8 py-3">Start Exploring</a>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
