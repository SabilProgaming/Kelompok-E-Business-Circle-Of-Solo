@extends('layouts.app')

@section('title', "Collections - L'ESSENCE")

@section('content')
    {{-- TEAM NOTE: Halaman ini masih DUMMY untuk validasi layout storefront. --}}
    {{-- PAGE PURPOSE: Menampilkan listing koleksi produk + pencarian + pagination. --}}
    <section class="pt-40 pb-10 px-6 md:px-12">
        <div class="max-w-6xl mx-auto">
            <div class="mb-6 border border-amber-200 bg-amber-50 px-4 py-3 text-xs text-amber-800">
                <strong>DUMMY PAGE:</strong> Ini placeholder untuk halaman daftar produk. Tim frontend/backend silakan isi logic final, filter, sorting, dan integrasi cart.
            </div>

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-serif text-[var(--color-primary)]">Collections</h1>
                    <p class="mt-2 text-xs text-[var(--color-accent)]/60 uppercase tracking-[0.2em]">Explore our curated fragrance line</p>
                </div>

                <form method="GET" action="{{ route('products.index') }}" class="w-full md:w-auto">
                    <div class="flex items-center border border-gray-200 bg-white">
                        <input type="text" name="search" value="{{ $search }}" placeholder="Search fragrance..." class="px-4 py-2 text-sm bg-transparent border-0 focus:outline-none w-full md:w-64">
                        <button type="submit" class="px-4 py-2 text-xs uppercase tracking-widest font-bold text-[var(--color-primary)] hover:bg-gray-100 transition-colors">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section class="pb-24 px-6 md:px-12">
        <div class="max-w-6xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($products as $product)
                @php
                    $image = $product->images->first();
                    $price = optional($product->variants->sortBy('price')->first())->price;
                @endphp
                <article class="bg-white border border-gray-100 shadow-sm overflow-hidden group">
                    <a href="{{ route('products.show', $product) }}" class="block">
                        <div class="aspect-[4/5] bg-gray-100 overflow-hidden">
                            @if($image)
                                <img src="{{ $image->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs uppercase tracking-widest">No Image</div>
                            @endif
                        </div>
                        <div class="p-5">
                            <h3 class="font-serif text-lg text-[var(--color-primary)]">{{ $product->name }}</h3>
                            <p class="mt-2 text-[10px] uppercase tracking-[0.2em] text-gray-500">{{ $product->category?->name ?? 'Fragrance' }}</p>
                            <p class="mt-4 text-sm font-semibold text-[var(--color-primary)]">{{ $price ? 'Rp '.number_format((float) $price, 0, ',', '.') : 'Price on request' }}</p>
                        </div>
                    </a>
                </article>
            @empty
                <div class="col-span-full text-center py-16 text-gray-500">No products found.</div>
            @endforelse
        </div>

        @if($products->hasPages())
            <div class="max-w-6xl mx-auto mt-8">{{ $products->links() }}</div>
        @endif
    </section>
@endsection
