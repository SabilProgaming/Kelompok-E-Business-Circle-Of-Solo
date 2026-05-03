@extends('layouts.app')

@section('title', $product->name ? "{$product->name} - Sanctum" : "Product Detail - Sanctum")

@section('content')
@if (!isset($product) || !$product)
    <div class="pt-40 pb-32 px-6 text-center">
        <h1 class="text-4xl font-serif mb-8">Fragrance Not Found</h1>
        <a href="{{ route('products.index') }}" class="luxury-button inline-block">Back to Catalog</a>
    </div>
@else
    <div class="pt-20 lg:pt-20 min-h-screen bg-luxury-cream overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-2 min-h-[calc(100vh-80px)]">
            <div class="bg-luxury-nude flex items-center justify-center p-8 lg:p-24 relative overflow-hidden">
                <div class="absolute inset-0 opacity-10 pattern-dots"></div>
                <div class="w-full max-w-lg aspect-[4/5] bg-luxury-charcoal relative shadow-2xl flex flex-col p-10 items-center justify-center group overflow-hidden">
                    @php
                        $productImageUrl = $product->images->first()?->image_url;
                        $resolvedProductImageUrl = $productImageUrl
                            ? (\Illuminate\Support\Str::startsWith($productImageUrl, ['http://', 'https://', '/'])
                                ? $productImageUrl
                                : asset('storage/' . ltrim($productImageUrl, '/')))
                            : null;
                    @endphp
                    @if ($resolvedProductImageUrl)
                        <img src="{{ $resolvedProductImageUrl }}" alt="{{ $product->name }}" class="absolute inset-0 w-full h-full object-cover opacity-60 group-hover:opacity-40 transition-opacity duration-700" />
                    @else
                        <div class="absolute inset-0 bg-gray-100 flex items-center justify-center text-sm text-gray-500">No Image Available</div>
                    @endif
                    <div class="relative z-10 text-center">
                        <div class="text-luxury-gold font-serif text-5xl mb-4 italic tracking-widest uppercase">{{ $product->brand->name ?? 'Unknown Brand' }}</div>
                        <div class="h-px w-20 bg-luxury-gold mb-6 mx-auto opacity-50"></div>
                        <div class="text-[10px] tracking-[0.5em] text-luxury-gold/70 uppercase">{{ $product->category->name ?? 'Artisanal Blend' }}</div>
                    </div>
                </div>
            </div>

            @php
                $variants = $product->variants;
                $defaultVariant = $variants->first();
            @endphp
            <div class="p-8 lg:p-24 flex flex-col justify-center space-y-12 animate-fade-in" x-data="{
                variants: @js($variants->map(fn ($variant) => ['id' => $variant->id, 'name' => $variant->name, 'price' => (float) $variant->price])),
                selectedVariantId: {{ $defaultVariant?->id ?? 'null' }},
                quantity: 1,
                isWishlisted: {{ $isWishlisted ? 'true' : 'false' }},
                wishLoading: false,
                get selectedVariant() { return this.variants.find(v => v.id === this.selectedVariantId); },
                get formattedPrice() { return this.selectedVariant ? Number(this.selectedVariant.price).toLocaleString('id-ID') : '0'; },
                async toggleWishlist() {
                    if (this.wishLoading) return;
                    if (!{{ auth()->check() ? 'true' : 'false' }}) { window.location.href = '{{ route("login") }}'; return; }
                    this.wishLoading = true;
                    try {
                        const res = await fetch('{{ route("wishlist.toggle") }}', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                            body: JSON.stringify({ product_id: {{ $product->id }} })
                        });
                        const data = await res.json();
                        this.isWishlisted = data.status === 'added';
                    } catch(e) { console.error(e); }
                    finally { this.wishLoading = false; }
                }
            }">
                <a href="{{ route('products.index') }}" class="text-[10px] uppercase tracking-widest text-luxury-gold flex items-center group transition-colors hover:text-luxury-charcoal">
                    <span class="mr-3 transition-transform group-hover:-translate-x-1">←</span> Back to Collection
                </a>

                <div class="space-y-6">
                    <div class="space-y-4">
                        <h1 class="text-5xl md:text-7xl font-serif font-light leading-tight">{{ $product->name }}</h1>
                        <div class="flex items-center space-x-4">
                            <p class="text-2xl text-luxury-gold font-light font-mono tracking-tighter">Rp <span x-text="formattedPrice"></span></p>
                            <span class="text-[10px] uppercase tracking-[0.3em] text-luxury-charcoal/30 font-medium">{{ $product->category->name ?? '' }}</span>
                        </div>
                        @php $avgRating = $product->averageRating(); $reviewCount = $product->reviews->count(); @endphp
                        @if($reviewCount > 0)
                        <div class="flex items-center space-x-2">
                            <div class="flex">@for($i=1;$i<=5;$i++)<span class="text-sm {{ $i <= round($avgRating) ? 'text-luxury-gold' : 'text-luxury-charcoal/15' }}">★</span>@endfor</div>
                            <span class="text-xs text-luxury-charcoal/40">{{ $avgRating }} ({{ $reviewCount }} review)</span>
                        </div>
                        @endif
                    </div>

                    <div class="space-y-2">
                        <p class="text-[10px] uppercase tracking-[0.2em] text-luxury-gold font-bold">The Scent Profile</p>
                        <p class="text-sm text-luxury-charcoal/60 leading-relaxed max-w-md font-light italic">"{{ $product->description }}"</p>
                    </div>

                    <div class="flex flex-wrap gap-4 pt-4 border-t border-luxury-gold/10">
                        <p class="w-full text-[10px] uppercase tracking-[0.2em] text-luxury-charcoal/40 mb-2">Olfactory Notes</p>
                        @forelse ($product->scents as $scent)
                            <span class="text-[9px] uppercase tracking-[0.2em] px-4 py-2 bg-luxury-clay/30 text-luxury-charcoal/60 rounded-sm">{{ $scent->name }}</span>
                        @empty
                            <span class="text-[9px] uppercase tracking-[0.2em] px-4 py-2 bg-luxury-clay/30 text-luxury-charcoal/60 rounded-sm">No scent notes available</span>
                        @endforelse
                    </div>
                </div>

                <form method="POST" action="{{ route('cart.store') }}" class="space-y-10 max-w-md">
                    @csrf
                    <div>
                        <p class="text-[10px] uppercase tracking-[0.3em] text-luxury-charcoal/40 font-medium mb-4">Select Volume</p>
                        <div class="flex flex-wrap gap-4">
                            @forelse ($variants as $variant)
                                @php
                                    $variantId = 'variant-' . $variant->id;
                                @endphp
                                <div class="inline-flex">
                                    <input id="{{ $variantId }}" type="radio" name="variant_id" value="{{ $variant->id }}" class="sr-only peer" @checked($loop->first) x-model="selectedVariantId" />
                                    <label for="{{ $variantId }}" class="px-6 py-3 text-[10px] tracking-widest border transition-all duration-300 cursor-pointer border-luxury-charcoal/20 text-luxury-charcoal hover:border-luxury-gold peer-checked:border-luxury-charcoal peer-checked:bg-luxury-charcoal peer-checked:text-white">{{ $variant->name ?? 'Variant' }}</label>
                                </div>
                            @empty
                                <p class="text-xs text-luxury-charcoal/50">No variants available.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-4 sm:space-y-0">
                        <div class="flex items-center border border-luxury-charcoal/10 bg-white">
                            <button class="p-4 hover:bg-luxury-gold hover:text-white transition-colors" type="button" @click="quantity = Math.max(1, quantity - 1)">-</button>
                            <span class="w-12 text-center text-xs font-mono font-bold tracking-widest" x-text="quantity"></span>
                            <button class="p-4 hover:bg-luxury-gold hover:text-white transition-colors" type="button" @click="quantity = quantity + 1">+</button>
                        </div>
                        <input type="hidden" name="quantity" :value="quantity">
                        <button class="flex-1 py-4 sm:py-6 px-4 border border-luxury-charcoal bg-luxury-charcoal text-white text-[10px] uppercase tracking-[0.3em] font-bold hover:bg-luxury-gold hover:border-luxury-gold transition-all duration-500 shadow-xl" @disabled($variants->isEmpty())>Add to Shopping Bag</button>
                        <button type="button" @click="toggleWishlist()" class="p-4 border transition-all duration-300" :class="isWishlisted ? 'border-red-400 bg-red-50 text-red-500' : 'border-luxury-charcoal/10 text-luxury-charcoal/40 hover:text-red-500 hover:border-red-300'">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" :fill="isWishlisted ? 'currentColor' : 'none'" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- SCENT PYRAMID + LONGEVITY/SILLAGE --}}
        @if($product->top_notes || $product->middle_notes || $product->base_notes)
        <section class="px-6 lg:px-24 py-24 bg-white">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16 space-y-3">
                    <span class="text-luxury-gold text-[9px] font-bold tracking-[0.5em] uppercase">Olfactory Architecture</span>
                    <h2 class="text-4xl font-serif font-light">The Scent <span class="italic">Pyramid</span></h2>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
                    {{-- Pyramid --}}
                    <div class="flex flex-col items-center space-y-6">
                        @if($product->top_notes)
                        <div class="w-full max-w-xs text-center">
                            <div class="relative bg-gradient-to-b from-luxury-gold/15 to-luxury-gold/5 py-6 px-8 clip-trapezoid-top">
                                <p class="text-[9px] uppercase tracking-[0.4em] text-luxury-gold font-bold mb-2">Top Notes</p>
                                <p class="text-sm text-luxury-charcoal/70 font-light">{{ $product->top_notes }}</p>
                                <p class="text-[8px] text-luxury-charcoal/30 mt-1 uppercase tracking-wider">0 – 30 menit</p>
                            </div>
                        </div>
                        @endif
                        @if($product->middle_notes)
                        <div class="w-full max-w-sm text-center">
                            <div class="relative bg-gradient-to-b from-luxury-clay/25 to-luxury-clay/10 py-6 px-8">
                                <p class="text-[9px] uppercase tracking-[0.4em] text-luxury-gold font-bold mb-2">Middle Notes</p>
                                <p class="text-sm text-luxury-charcoal/70 font-light">{{ $product->middle_notes }}</p>
                                <p class="text-[8px] text-luxury-charcoal/30 mt-1 uppercase tracking-wider">30 menit – 4 jam</p>
                            </div>
                        </div>
                        @endif
                        @if($product->base_notes)
                        <div class="w-full max-w-md text-center">
                            <div class="relative bg-gradient-to-b from-luxury-charcoal/10 to-luxury-charcoal/5 py-6 px-8">
                                <p class="text-[9px] uppercase tracking-[0.4em] text-luxury-gold font-bold mb-2">Base Notes</p>
                                <p class="text-sm text-luxury-charcoal/70 font-light">{{ $product->base_notes }}</p>
                                <p class="text-[8px] text-luxury-charcoal/30 mt-1 uppercase tracking-wider">4 – 24 jam</p>
                            </div>
                        </div>
                        @endif
                    </div>

                    {{-- Longevity & Sillage --}}
                    <div class="space-y-12 flex flex-col justify-center">
                        @if($product->longevity)
                        <div>
                            <div class="flex justify-between items-center mb-3">
                                <p class="text-[10px] uppercase tracking-[0.3em] text-luxury-charcoal/50 font-bold">Longevity (Ketahanan)</p>
                                <p class="text-sm font-mono text-luxury-gold font-bold">{{ $product->longevity }}/5</p>
                            </div>
                            <div class="w-full h-2 bg-luxury-charcoal/5 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-luxury-gold/60 to-luxury-gold rounded-full transition-all duration-1000" style="width: {{ ($product->longevity / 5) * 100 }}%"></div>
                            </div>
                            <div class="flex justify-between mt-1">
                                <span class="text-[8px] text-luxury-charcoal/30 uppercase">Ringan</span>
                                <span class="text-[8px] text-luxury-charcoal/30 uppercase">Beast Mode</span>
                            </div>
                        </div>
                        @endif
                        @if($product->sillage)
                        <div>
                            <div class="flex justify-between items-center mb-3">
                                <p class="text-[10px] uppercase tracking-[0.3em] text-luxury-charcoal/50 font-bold">Sillage (Daya Sebar)</p>
                                <p class="text-sm font-mono text-luxury-gold font-bold">{{ $product->sillage }}/5</p>
                            </div>
                            <div class="w-full h-2 bg-luxury-charcoal/5 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-luxury-gold/60 to-luxury-gold rounded-full transition-all duration-1000" style="width: {{ ($product->sillage / 5) * 100 }}%"></div>
                            </div>
                            <div class="flex justify-between mt-1">
                                <span class="text-[8px] text-luxury-charcoal/30 uppercase">Intimate</span>
                                <span class="text-[8px] text-luxury-charcoal/30 uppercase">Enormous</span>
                            </div>
                        </div>
                        @endif

                        {{-- Scent Wheel mini --}}
                        <div>
                            <p class="text-[10px] uppercase tracking-[0.3em] text-luxury-charcoal/50 font-bold mb-4">Scent Family</p>
                            <div class="flex flex-wrap gap-3">
                                @foreach($product->scents as $scent)
                                @php
                                    $scentColors = [
                                        'Woody'=>'#8B6F47','Floral'=>'#D4869C','Citrus'=>'#F4A940','Spicy'=>'#C0392B','Musk'=>'#BDC3C7',
                                        'Amber'=>'#D4A033','Vanilla'=>'#F5E6CC','Oud'=>'#3E2723','Fresh'=>'#27AE60','Aquatic'=>'#2E86C1',
                                        'Rose'=>'#E74C6F','Jasmine'=>'#F7DC6F','Sandalwood'=>'#C9A96E','Bergamot'=>'#7DCEA0','Patchouli'=>'#6D4C41',
                                        'Leather'=>'#4A2C2A','Tobacco'=>'#795548','Lavender'=>'#9B59B6','Vetiver'=>'#558B2F','Fruity'=>'#E91E63',
                                    ];
                                    $color = $scentColors[$scent->name] ?? '#C5A059';
                                @endphp
                                <div class="flex items-center space-x-2 px-4 py-2 rounded-full border border-luxury-charcoal/5 bg-white">
                                    <div class="w-3 h-3 rounded-full" style="background: {{ $color }}"></div>
                                    <span class="text-[9px] uppercase tracking-[0.2em] text-luxury-charcoal/60 font-medium">{{ $scent->name }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @endif

        {{-- REVIEWS SECTION --}}
        <section class="px-6 lg:px-24 py-24 bg-luxury-cream">
            <div class="max-w-5xl mx-auto">
                <div class="text-center mb-16 space-y-3">
                    <span class="text-luxury-gold text-[9px] font-bold tracking-[0.5em] uppercase">Community</span>
                    <h2 class="text-4xl font-serif font-light">Reviews & <span class="italic">Ratings</span></h2>
                </div>

                @auth
                <div class="bg-white p-8 border border-luxury-gold/10 mb-12" x-data="{ rating: 0, hoverRating: 0 }">
                    <h3 class="font-serif text-xl mb-6">Tulis Review Anda</h3>
                    <form method="POST" action="{{ route('reviews.store') }}">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="rating" :value="rating">
                        <div class="mb-6">
                            <p class="text-[10px] uppercase tracking-[0.2em] text-luxury-charcoal/40 font-bold mb-3">Rating</p>
                            <div class="flex space-x-1">
                                @for($i = 1; $i <= 5; $i++)
                                <button type="button" @click="rating = {{ $i }}" @mouseenter="hoverRating = {{ $i }}" @mouseleave="hoverRating = 0" class="text-3xl transition-colors duration-200" :class="(hoverRating || rating) >= {{ $i }} ? 'text-luxury-gold' : 'text-luxury-charcoal/15'">★</button>
                                @endfor
                            </div>
                        </div>
                        <div class="mb-6">
                            <textarea name="comment" rows="3" class="w-full border border-luxury-charcoal/10 p-4 text-sm font-light focus:outline-none focus:border-luxury-gold/40 transition-colors resize-none" placeholder="Ceritakan pengalaman Anda dengan parfum ini..."></textarea>
                        </div>
                        <button type="submit" class="luxury-button text-[10px] tracking-[0.25em] px-8 py-3" :disabled="rating === 0" :class="rating === 0 ? 'opacity-40 cursor-not-allowed' : ''">Kirim Review</button>
                    </form>
                </div>
                @else
                <div class="text-center mb-12 p-8 bg-white border border-luxury-gold/10">
                    <p class="text-sm text-luxury-charcoal/50 mb-4">Login untuk menulis review</p>
                    <a href="{{ route('login') }}" class="luxury-button inline-block text-[10px] tracking-[0.25em] px-8 py-3">Sign In</a>
                </div>
                @endauth

                @if($product->reviews->count() > 0)
                <div class="space-y-6">
                    @foreach($product->reviews->sortByDesc('created_at') as $review)
                    <div class="bg-white p-6 border border-luxury-gold/5">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-full bg-luxury-gold/10 flex items-center justify-center text-xs font-bold text-luxury-gold">{{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}</div>
                                <div>
                                    <p class="text-sm font-medium">{{ $review->user->name ?? 'Anonymous' }}</p>
                                    <p class="text-[9px] text-luxury-charcoal/30">{{ $review->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="flex">@for($i=1;$i<=5;$i++)<span class="text-sm {{ $i <= $review->rating ? 'text-luxury-gold' : 'text-luxury-charcoal/10' }}">★</span>@endfor</div>
                        </div>
                        @if($review->comment)<p class="text-sm text-luxury-charcoal/60 font-light leading-relaxed">{{ $review->comment }}</p>@endif
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-12"><p class="font-serif italic text-xl text-luxury-charcoal/30">Belum ada review untuk parfum ini.</p></div>
                @endif
            </div>
        </section>

        {{-- RELATED PRODUCTS --}}
        <section class="px-6 lg:px-24 py-24">
            <div class="max-w-7xl mx-auto">
                <div class="flex items-center justify-between mb-12">
                    <div>
                        <p class="text-[9px] uppercase tracking-[0.5em] text-luxury-gold font-bold">Related Products</p>
                        <h2 class="text-4xl font-serif font-light">You may also like</h2>
                    </div>
                    <a href="{{ route('products.index') }}" class="text-[10px] uppercase tracking-[0.3em] font-bold text-luxury-charcoal hover:text-luxury-gold transition-colors">View All</a>
                </div>
                @if ($relatedProducts->count())
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-x-8 gap-y-12">
                        @foreach ($relatedProducts as $related)
                            <a href="{{ route('products.show', $related) }}" class="group block">
                                <div class="relative aspect-[4/5] bg-white flex items-center justify-center p-10 shadow-[0_20px_50px_-20px_rgba(0,0,0,0.1)] group-hover:shadow-[0_40px_80px_-20px_rgba(0,0,0,0.2)] transition-all duration-700 border border-luxury-gold/5 group-hover:border-luxury-gold/20">
                                    @if ($related->images->isNotEmpty())
                                        @php
                                            $relatedImageUrl = $related->images->first()->image_url;
                                        @endphp
                                        <img src="{{ \Illuminate\Support\Str::startsWith($relatedImageUrl, ['http://', 'https://', '/']) ? $relatedImageUrl : asset('storage/' . ltrim($relatedImageUrl, '/')) }}" alt="{{ $related->name }}" class="w-full h-full object-cover z-10" />
                                    @else
                                        <div class="w-full h-full bg-gray-100 flex items-center justify-center text-sm text-gray-500">No Image</div>
                                    @endif
                                </div>
                                <div class="mt-10 text-center space-y-3">
                                    <p class="text-[8px] text-luxury-gold font-bold tracking-[0.5em] uppercase">{{ $related->brand->name ?? 'Unknown Brand' }}</p>
                                    <h3 class="font-serif text-2xl font-light group-hover:italic transition-all duration-500">{{ $related->name }}</h3>
                                    <p class="text-[9px] text-luxury-charcoal font-medium tracking-widest">Rp {{ number_format($related->variants->first()->price ?? 0, 0, ',', '.') }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-20"><p class="font-serif italic text-2xl text-luxury-charcoal/30">No related fragrances available.</p></div>
                @endif
            </div>
        </section>
    </div>
@endif
@endsection