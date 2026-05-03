@extends('layouts.app')

@section('title', 'Wishlist - Sanctum')

@section('content')
<div class="min-h-screen pt-40 pb-32 px-6 bg-luxury-cream">
    <div class="max-w-6xl mx-auto">
        <header class="mb-16 text-center space-y-4">
            <span class="text-luxury-gold text-[9px] font-bold tracking-[0.5em] uppercase">Your Collection</span>
            <h1 class="text-5xl md:text-7xl font-serif font-light">My <span class="italic">Wishlist</span></h1>
            <p class="text-luxury-charcoal/40 text-sm">{{ $wishlists->count() }} parfum tersimpan</p>
        </header>

        @if($wishlists->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-16" x-data>
            @foreach($wishlists as $wishlist)
                @php
                    $product = $wishlist->product;
                    $imageUrl = $product->images->first()?->image_url;
                    $displayImage = $imageUrl ? (\Illuminate\Support\Str::startsWith($imageUrl, ['http://', 'https://', '/']) ? $imageUrl : asset('storage/' . ltrim($imageUrl, '/'))) : null;
                @endphp
                <div class="group" x-data="{ removed: false }" x-show="!removed" x-transition>
                    <a href="{{ route('products.show', $product) }}" class="block">
                        <div class="relative aspect-[4/5] bg-white flex items-center justify-center p-8 shadow-[0_20px_50px_-20px_rgba(0,0,0,0.1)] group-hover:shadow-[0_40px_80px_-20px_rgba(0,0,0,0.2)] transition-all duration-700 border border-luxury-gold/5 group-hover:border-luxury-gold/20 group-hover:-translate-y-2">
                            @if($displayImage)
                                <img src="{{ $displayImage }}" alt="{{ $product->name }}" class="w-full h-full object-cover z-10" />
                            @else
                                <div class="w-full h-full bg-gray-100 flex items-center justify-center text-sm text-gray-500">No Image</div>
                            @endif
                        </div>
                    </a>
                    <div class="mt-6 text-center space-y-2">
                        <p class="text-[8px] text-luxury-gold font-bold tracking-[0.5em] uppercase">{{ $product->brand->name ?? '' }}</p>
                        <h3 class="font-serif text-xl font-light group-hover:text-luxury-gold transition-colors">{{ $product->name }}</h3>
                        <p class="text-[9px] text-luxury-charcoal/50 tracking-widest">Rp {{ number_format($product->variants->first()->price ?? 0, 0, ',', '.') }}</p>
                        <button @click.prevent="
                            fetch('{{ route('wishlist.toggle') }}', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                                body: JSON.stringify({ product_id: {{ $product->id }} })
                            }).then(() => removed = true)
                        " class="text-[9px] uppercase tracking-[0.2em] text-red-400 hover:text-red-600 transition-colors mt-2 inline-flex items-center space-x-1">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="1"><path d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/></svg>
                            <span>Hapus</span>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-20 bg-white/50 border border-luxury-gold/10">
            <p class="font-serif text-2xl mb-6 text-luxury-charcoal/40 italic">Wishlist Anda masih kosong.</p>
            <a href="{{ route('products.index') }}" class="luxury-button inline-block text-[10px] tracking-[0.25em] px-10 py-4">Explore Collection</a>
        </div>
        @endif
    </div>
</div>
@endsection
