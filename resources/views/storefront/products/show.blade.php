@extends('layouts.app')

@section('title', $product->name." - L'ESSENCE")

@section('content')
    {{-- TEAM NOTE: Halaman ini masih DUMMY untuk validasi layout storefront. --}}
    {{-- PAGE PURPOSE: Menampilkan detail produk (gambar, varian, deskripsi, metadata) sebelum flow cart/checkout final. --}}
    @php
        $primaryImage = $product->images->first();
        $cheapestVariant = $product->variants->sortBy('price')->first();
    @endphp

    <section class="pt-40 pb-24 px-6 md:px-12">
        <div class="max-w-6xl mx-auto mb-6 border border-amber-200 bg-amber-50 px-4 py-3 text-xs text-amber-800">
            <strong>DUMMY PAGE:</strong> Ini placeholder halaman detail produk. Tim silakan lengkapi CTA add-to-cart, rekomendasi, review, dan tracking event.
        </div>

        <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-10">
            <div class="bg-white border border-gray-100 overflow-hidden">
                <div class="aspect-[4/5] bg-gray-100">
                    @if($primaryImage)
                        <img src="{{ $primaryImage->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs uppercase tracking-widest">No Image</div>
                    @endif
                </div>
            </div>

            <div>
                <p class="text-[10px] uppercase tracking-[0.3em] text-[var(--color-secondary)] font-bold">{{ $product->brand?->name ?? 'L\'Essence' }}</p>
                <h1 class="mt-3 text-4xl font-serif text-[var(--color-primary)]">{{ $product->name }}</h1>
                <p class="mt-4 text-base text-[var(--color-accent)]/70 leading-relaxed">{{ $product->description ?: 'A refined fragrance composition designed for timeless elegance.' }}</p>

                <div class="mt-6 text-sm text-[var(--color-accent)]/80 space-y-2">
                    <p><span class="font-semibold">Category:</span> {{ $product->category?->name ?? '-' }}</p>
                    <p><span class="font-semibold">Starting Price:</span> {{ $cheapestVariant ? 'Rp '.number_format((float) $cheapestVariant->price, 0, ',', '.') : '-' }}</p>
                    <p><span class="font-semibold">Scents:</span> {{ $product->scents->pluck('name')->join(', ') ?: '-' }}</p>
                </div>

                @if($product->variants->isNotEmpty())
                    <div class="mt-8 border border-gray-100 bg-white">
                        <div class="px-5 py-3 border-b border-gray-100 text-[10px] uppercase tracking-[0.2em] font-bold text-gray-500">Available Variants</div>
                        <div class="divide-y divide-gray-100">
                            @foreach($product->variants as $variant)
                                <div class="px-5 py-3 flex items-center justify-between">
                                    <p class="text-sm text-[var(--color-primary)]">{{ $variant->name }}</p>
                                    <p class="text-sm font-semibold text-[var(--color-primary)]">Rp {{ number_format((float) $variant->price, 0, ',', '.') }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="mt-8">
                    <a href="{{ route('products.index') }}" class="inline-flex items-center px-6 py-3 text-[10px] uppercase tracking-[0.25em] font-bold border border-[var(--color-primary)] hover:bg-[var(--color-primary)] hover:text-white transition-colors">Back to Collections</a>
                </div>
            </div>
        </div>
    </section>
@endsection
