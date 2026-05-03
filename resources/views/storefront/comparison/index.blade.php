@extends('layouts.app')

@section('title', "Compare Fragrances - Sanctum")

@section('content')
<div class="pt-32 pb-24 px-6 md:px-24 bg-luxury-cream min-h-screen">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <span class="text-luxury-gold text-[9px] font-bold tracking-[0.5em] uppercase">Side by Side</span>
            <h1 class="text-4xl md:text-5xl font-serif font-light mt-4">Compare <span class="italic">Fragrances</span></h1>
            <p class="text-luxury-charcoal/50 text-sm mt-4 max-w-lg mx-auto font-light">Select two distinct creations to juxtapose their olfactory profiles, notes, and performance characteristics.</p>
        </div>

        {{-- Form Pilihan --}}
        <form method="GET" action="{{ route('compare.index') }}" class="bg-white p-8 border border-luxury-gold/10 mb-16 shadow-xl relative z-20">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-end">
                <div class="space-y-3">
                    <label class="text-[10px] uppercase tracking-[0.3em] font-bold text-luxury-charcoal/50">First Fragrance</label>
                    <select name="p1" class="w-full bg-luxury-cream/50 border border-luxury-charcoal/10 p-4 text-sm font-serif focus:outline-none focus:border-luxury-gold transition-colors">
                        <option value="">Select a fragrance...</option>
                        @foreach($allProducts as $p)
                            <option value="{{ $p->id }}" {{ request('p1') == $p->id ? 'selected' : '' }}>
                                {{ $p->brand->name ?? '' }} - {{ $p->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-3">
                    <label class="text-[10px] uppercase tracking-[0.3em] font-bold text-luxury-charcoal/50">Second Fragrance</label>
                    <div class="flex gap-4">
                        <select name="p2" class="w-full bg-luxury-cream/50 border border-luxury-charcoal/10 p-4 text-sm font-serif focus:outline-none focus:border-luxury-gold transition-colors">
                            <option value="">Select a fragrance...</option>
                            @foreach($allProducts as $p)
                                <option value="{{ $p->id }}" {{ request('p2') == $p->id ? 'selected' : '' }}>
                                    {{ $p->brand->name ?? '' }} - {{ $p->name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="px-8 bg-luxury-charcoal text-white hover:bg-luxury-gold transition-colors text-[10px] uppercase tracking-[0.3em] font-bold">Compare</button>
                    </div>
                </div>
            </div>
        </form>

        {{-- Hasil Komparasi --}}
        @if($product1 || $product2)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-16">
                
                {{-- Kolom 1 --}}
                <div class="border border-luxury-gold/10 bg-white p-8 lg:p-12 relative overflow-hidden group">
                    @if($product1)
                        @php
                            $img1 = $product1->images->first()?->image_url;
                            $resolvedImg1 = $img1 ? (\Illuminate\Support\Str::startsWith($img1, ['http://', 'https://', '/']) ? $img1 : asset('storage/' . ltrim($img1, '/'))) : null;
                        @endphp
                        
                        <div class="aspect-square bg-luxury-charcoal/5 mb-8 flex items-center justify-center p-8 relative">
                            @if($resolvedImg1)
                            <img src="{{ $resolvedImg1 }}" class="w-full h-full object-cover mix-blend-multiply group-hover:scale-105 transition-transform duration-700">
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-white via-transparent to-transparent"></div>
                        </div>
                        
                        <div class="text-center space-y-2 mb-12">
                            <span class="text-[9px] uppercase tracking-[0.4em] text-luxury-gold font-bold">{{ $product1->brand->name ?? 'Brand' }}</span>
                            <h2 class="text-3xl font-serif">{{ $product1->name }}</h2>
                            <p class="text-luxury-charcoal/50 text-[10px] uppercase tracking-widest">{{ $product1->category->name ?? 'Category' }}</p>
                            <p class="text-lg font-mono text-luxury-gold mt-4">Rp {{ number_format($product1->variants->first()->price ?? 0, 0, ',', '.') }}</p>
                        </div>

                        <div class="space-y-10">
                            {{-- Rating --}}
                            <div class="text-center border-t border-luxury-charcoal/5 pt-8">
                                <span class="text-[10px] uppercase tracking-[0.3em] text-luxury-charcoal/40 font-bold block mb-3">Rating</span>
                                <div class="flex justify-center text-luxury-gold text-lg">
                                    @for($i=1; $i<=5; $i++)
                                        <span class="{{ $i <= round($product1->averageRating()) ? 'text-luxury-gold' : 'text-luxury-charcoal/15' }}">★</span>
                                    @endfor
                                </div>
                                <span class="text-xs text-luxury-charcoal/40 block mt-1">{{ number_format($product1->averageRating(), 1) }} / 5.0</span>
                            </div>

                            {{-- Scent Pyramid --}}
                            <div class="text-center border-t border-luxury-charcoal/5 pt-8">
                                <span class="text-[10px] uppercase tracking-[0.3em] text-luxury-charcoal/40 font-bold block mb-6">Scent Pyramid</span>
                                
                                <div class="space-y-4">
                                    <div class="bg-gradient-to-b from-luxury-gold/15 to-luxury-gold/5 py-4 px-4 clip-trapezoid-top w-2/3 mx-auto">
                                        <span class="text-[8px] uppercase tracking-widest text-luxury-gold block mb-1">Top</span>
                                        <span class="text-sm font-light">{{ $product1->top_notes ?? '-' }}</span>
                                    </div>
                                    <div class="bg-gradient-to-b from-luxury-clay/20 to-luxury-clay/5 py-4 px-4 w-5/6 mx-auto">
                                        <span class="text-[8px] uppercase tracking-widest text-luxury-gold block mb-1">Heart</span>
                                        <span class="text-sm font-light">{{ $product1->middle_notes ?? '-' }}</span>
                                    </div>
                                    <div class="bg-gradient-to-b from-luxury-charcoal/10 to-luxury-charcoal/5 py-4 px-4 w-full">
                                        <span class="text-[8px] uppercase tracking-widest text-luxury-gold block mb-1">Base</span>
                                        <span class="text-sm font-light">{{ $product1->base_notes ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Performance --}}
                            <div class="border-t border-luxury-charcoal/5 pt-8 space-y-6">
                                <div>
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-[10px] uppercase tracking-[0.3em] text-luxury-charcoal/40 font-bold">Longevity</span>
                                        <span class="text-xs font-mono font-bold">{{ $product1->longevity ?? 0 }}/5</span>
                                    </div>
                                    <div class="w-full h-1.5 bg-luxury-charcoal/5 rounded-full overflow-hidden">
                                        <div class="h-full bg-luxury-gold transition-all" style="width: {{ (($product1->longevity ?? 0) / 5) * 100 }}%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-[10px] uppercase tracking-[0.3em] text-luxury-charcoal/40 font-bold">Sillage</span>
                                        <span class="text-xs font-mono font-bold">{{ $product1->sillage ?? 0 }}/5</span>
                                    </div>
                                    <div class="w-full h-1.5 bg-luxury-charcoal/5 rounded-full overflow-hidden">
                                        <div class="h-full bg-luxury-gold transition-all" style="width: {{ (($product1->sillage ?? 0) / 5) * 100 }}%"></div>
                                    </div>
                                </div>
                            </div>

                            <a href="{{ route('products.show', $product1) }}" class="block text-center py-4 border border-luxury-charcoal hover:bg-luxury-charcoal hover:text-white transition-colors text-[10px] uppercase tracking-[0.3em] font-bold">View Details</a>
                        </div>
                    @else
                        <div class="h-full flex flex-col items-center justify-center text-center opacity-50">
                            <span class="text-6xl text-luxury-charcoal/10 mb-4">?</span>
                            <p class="font-serif italic text-xl">Select a fragrance above</p>
                        </div>
                    @endif
                </div>

                {{-- Kolom 2 --}}
                <div class="border border-luxury-gold/10 bg-white p-8 lg:p-12 relative overflow-hidden group">
                    @if($product2)
                        @php
                            $img2 = $product2->images->first()?->image_url;
                            $resolvedImg2 = $img2 ? (\Illuminate\Support\Str::startsWith($img2, ['http://', 'https://', '/']) ? $img2 : asset('storage/' . ltrim($img2, '/'))) : null;
                        @endphp
                        
                        <div class="aspect-square bg-luxury-charcoal/5 mb-8 flex items-center justify-center p-8 relative">
                            @if($resolvedImg2)
                            <img src="{{ $resolvedImg2 }}" class="w-full h-full object-cover mix-blend-multiply group-hover:scale-105 transition-transform duration-700">
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-white via-transparent to-transparent"></div>
                        </div>
                        
                        <div class="text-center space-y-2 mb-12">
                            <span class="text-[9px] uppercase tracking-[0.4em] text-luxury-gold font-bold">{{ $product2->brand->name ?? 'Brand' }}</span>
                            <h2 class="text-3xl font-serif">{{ $product2->name }}</h2>
                            <p class="text-luxury-charcoal/50 text-[10px] uppercase tracking-widest">{{ $product2->category->name ?? 'Category' }}</p>
                            <p class="text-lg font-mono text-luxury-gold mt-4">Rp {{ number_format($product2->variants->first()->price ?? 0, 0, ',', '.') }}</p>
                        </div>

                        <div class="space-y-10">
                            {{-- Rating --}}
                            <div class="text-center border-t border-luxury-charcoal/5 pt-8">
                                <span class="text-[10px] uppercase tracking-[0.3em] text-luxury-charcoal/40 font-bold block mb-3">Rating</span>
                                <div class="flex justify-center text-luxury-gold text-lg">
                                    @for($i=1; $i<=5; $i++)
                                        <span class="{{ $i <= round($product2->averageRating()) ? 'text-luxury-gold' : 'text-luxury-charcoal/15' }}">★</span>
                                    @endfor
                                </div>
                                <span class="text-xs text-luxury-charcoal/40 block mt-1">{{ number_format($product2->averageRating(), 1) }} / 5.0</span>
                            </div>

                            {{-- Scent Pyramid --}}
                            <div class="text-center border-t border-luxury-charcoal/5 pt-8">
                                <span class="text-[10px] uppercase tracking-[0.3em] text-luxury-charcoal/40 font-bold block mb-6">Scent Pyramid</span>
                                
                                <div class="space-y-4">
                                    <div class="bg-gradient-to-b from-luxury-gold/15 to-luxury-gold/5 py-4 px-4 clip-trapezoid-top w-2/3 mx-auto">
                                        <span class="text-[8px] uppercase tracking-widest text-luxury-gold block mb-1">Top</span>
                                        <span class="text-sm font-light">{{ $product2->top_notes ?? '-' }}</span>
                                    </div>
                                    <div class="bg-gradient-to-b from-luxury-clay/20 to-luxury-clay/5 py-4 px-4 w-5/6 mx-auto">
                                        <span class="text-[8px] uppercase tracking-widest text-luxury-gold block mb-1">Heart</span>
                                        <span class="text-sm font-light">{{ $product2->middle_notes ?? '-' }}</span>
                                    </div>
                                    <div class="bg-gradient-to-b from-luxury-charcoal/10 to-luxury-charcoal/5 py-4 px-4 w-full">
                                        <span class="text-[8px] uppercase tracking-widest text-luxury-gold block mb-1">Base</span>
                                        <span class="text-sm font-light">{{ $product2->base_notes ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Performance --}}
                            <div class="border-t border-luxury-charcoal/5 pt-8 space-y-6">
                                <div>
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-[10px] uppercase tracking-[0.3em] text-luxury-charcoal/40 font-bold">Longevity</span>
                                        <span class="text-xs font-mono font-bold">{{ $product2->longevity ?? 0 }}/5</span>
                                    </div>
                                    <div class="w-full h-1.5 bg-luxury-charcoal/5 rounded-full overflow-hidden">
                                        <div class="h-full bg-luxury-gold transition-all" style="width: {{ (($product2->longevity ?? 0) / 5) * 100 }}%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-[10px] uppercase tracking-[0.3em] text-luxury-charcoal/40 font-bold">Sillage</span>
                                        <span class="text-xs font-mono font-bold">{{ $product2->sillage ?? 0 }}/5</span>
                                    </div>
                                    <div class="w-full h-1.5 bg-luxury-charcoal/5 rounded-full overflow-hidden">
                                        <div class="h-full bg-luxury-gold transition-all" style="width: {{ (($product2->sillage ?? 0) / 5) * 100 }}%"></div>
                                    </div>
                                </div>
                            </div>

                            <a href="{{ route('products.show', $product2) }}" class="block text-center py-4 border border-luxury-charcoal hover:bg-luxury-charcoal hover:text-white transition-colors text-[10px] uppercase tracking-[0.3em] font-bold">View Details</a>
                        </div>
                    @else
                        <div class="h-full flex flex-col items-center justify-center text-center opacity-50 min-h-[500px]">
                            <span class="text-6xl text-luxury-charcoal/10 mb-4">?</span>
                            <p class="font-serif italic text-xl">Select a fragrance above</p>
                        </div>
                    @endif
                </div>

            </div>

            {{-- Smart Verdict Section --}}
            @if($product1 && $product2 && !empty($verdict))
                <div class="mt-16 bg-white border border-luxury-gold/20 p-8 lg:p-12 shadow-2xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-8 opacity-5">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L1 21h22L12 2zm0 3.45l8.27 14.3H3.73L12 5.45zM11 10v4h2v-4h-2zm0 6v2h2v-2h-2z"/></svg>
                    </div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="h-px bg-luxury-gold flex-grow"></div>
                            <h3 class="text-[10px] uppercase tracking-[0.5em] font-bold text-luxury-gold whitespace-nowrap">Smart Verdict</h3>
                            <div class="h-px bg-luxury-gold flex-grow"></div>
                        </div>

                        <div class="text-center mb-12">
                            <h4 class="text-3xl font-serif mb-4">Which one matches <span class="italic">your persona?</span></h4>
                            <p class="text-luxury-charcoal/50 text-sm max-w-2xl mx-auto font-light italic">Our expert system has analyzed the olfactory notes of both fragrances to determine their suitability for different personality profiles.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($verdict as $key => $v)
                                <div class="bg-luxury-cream/30 p-6 border border-luxury-charcoal/5 group hover:border-luxury-gold/30 transition-all duration-500">
                                    <div class="flex items-center gap-3 mb-4">
                                        <span class="text-2xl">{{ $v['emoji'] }}</span>
                                        <span class="text-[10px] uppercase tracking-widest font-bold text-luxury-charcoal">{{ $v['name'] }}</span>
                                    </div>
                                    
                                    <p class="text-xs text-luxury-charcoal/60 leading-relaxed mb-4">
                                        @if($v['winner'] == 1)
                                            <span class="text-luxury-gold font-bold">{{ $product1->name }}</span> memiliki afinitas aroma yang lebih kuat untuk persona ini dibandingkan pesaingnya.
                                        @else
                                            <span class="text-luxury-gold font-bold">{{ $product2->name }}</span> adalah pilihan yang lebih tepat jika Anda memiliki karakter {{ strtolower($v['name']) }}.
                                        @endif
                                    </p>

                                    <div class="flex items-center gap-2">
                                        <div class="flex-grow h-1 bg-luxury-charcoal/5 rounded-full overflow-hidden">
                                            <div class="h-full bg-luxury-gold" style="width: {{ min(100, $v['score'] * 25) }}%"></div>
                                        </div>
                                        <span class="text-[8px] font-mono font-bold text-luxury-gold">MATCH</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-12 text-center">
                            <p class="text-[9px] uppercase tracking-[0.2em] text-luxury-charcoal/30 mb-6 font-bold">Not sure about your persona?</p>
                            <a href="{{ route('persona.index') }}" class="inline-block px-10 py-4 bg-luxury-charcoal text-white text-[10px] uppercase tracking-[0.3em] font-bold hover:bg-luxury-gold transition-all duration-300 transform hover:-translate-y-1">Take the Persona Quiz</a>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>

<style>
.clip-trapezoid-top {
    clip-path: polygon(10% 0, 90% 0, 100% 100%, 0% 100%);
}
</style>
@endsection
