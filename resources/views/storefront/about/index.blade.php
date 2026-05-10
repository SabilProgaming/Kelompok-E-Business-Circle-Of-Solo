@extends('layouts.app')

@section('title', "Our Heritage - Sanctum")

@section('content')
    <div class="animate-fade-in">
        {{-- Hero Section --}}
        <section class="relative h-[80vh] flex items-center justify-center overflow-hidden">
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/about-hero.png') }}" alt="Sanctum Heritage" class="w-full h-full object-cover opacity-60">
                <div class="absolute inset-0 bg-gradient-to-b from-luxury-cream/20 via-transparent to-luxury-cream"></div>
            </div>
            
            <div class="relative z-10 text-center px-6">
                <span class="text-[10px] uppercase tracking-[0.5em] text-luxury-gold mb-6 block">Established 1924</span>
                <h1 class="text-5xl md:text-7xl font-serif text-luxury-charcoal mb-8">The Sanctum <br><span class="serif-italic">Legacy</span></h1>
                <div class="w-24 h-px bg-luxury-gold mx-auto"></div>
            </div>
        </section>

        {{-- Our Story Section --}}
        <section class="py-32 px-6 md:px-12 bg-luxury-cream">
            <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-20 items-center">
                <div class="order-2 md:order-1">
                    <h2 class="text-3xl md:text-4xl text-luxury-charcoal mb-10">A Century of <br><span class="serif-italic">Olfactory Excellence</span></h2>
                    <div class="space-y-6 text-luxury-charcoal/70 leading-relaxed font-light text-sm md:text-base">
                        <p>
                            Born in the mist-covered hills of Grasse, Sanctum began as a small family atelier dedicated to the preservation of rare botanical essences. For over a century, we have remained true to our founding principle: that a perfume is not merely a scent, but a silent language of the soul.
                        </p>
                        <p>
                            Each composition is a curated journey, blending the finest natural ingredients with avant-garde chemistry. Our master perfumers spend years perfecting a single accord, ensuring that every bottle of Sanctum carries the weight of history and the spark of modern luxury.
                        </p>
                        <p>
                            Today, Sanctum stands as a beacon of niche perfumery, celebrated by connoisseurs who seek depth, complexity, and a connection to the timeless art of scent.
                        </p>
                    </div>
                </div>
                <div class="order-1 md:order-2 relative">
                    <div class="aspect-[4/5] overflow-hidden rounded-sm shadow-2xl">
                        <img src="{{ asset('images/about-ingredients.png') }}" alt="Pure Essences" class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-1000">
                    </div>
                    <div class="absolute -bottom-10 -left-10 w-40 h-40 border border-luxury-gold/10 -z-10"></div>
                </div>
            </div>
        </section>

        {{-- Values Section --}}
        <section class="py-32 px-6 md:px-12 bg-luxury-nude/30 relative overflow-hidden">
            <div class="pattern-dots absolute inset-0 opacity-40"></div>
            <div class="max-w-7xl mx-auto relative z-10">
                <div class="text-center mb-24">
                    <h2 class="text-3xl md:text-4xl text-luxury-charcoal">The Pillars of <span class="serif-italic">Sanctum</span></h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-16">
                    <div class="text-center group">
                        <div class="w-16 h-16 mx-auto mb-8 flex items-center justify-center rounded-full border border-luxury-gold/15 group-hover:bg-luxury-gold transition-all duration-500">
                            <i data-lucide="award" class="w-6 h-6 text-luxury-gold group-hover:text-white" style="stroke-width:1"></i>
                        </div>
                        <h3 class="text-xl mb-4">Uncompromising Quality</h3>
                        <p class="text-sm text-luxury-charcoal/60 font-light leading-relaxed">
                            We source only the highest grade of raw materials, from the rare Orris butter of Tuscany to the golden Oud of Southeast Asia.
                        </p>
                    </div>

                    <div class="text-center group">
                        <div class="w-16 h-16 mx-auto mb-8 flex items-center justify-center rounded-full border border-luxury-gold/15 group-hover:bg-luxury-gold transition-all duration-500">
                            <i data-lucide="leaf" class="w-6 h-6 text-luxury-gold group-hover:text-white" style="stroke-width:1"></i>
                        </div>
                        <h3 class="text-xl mb-4">Conscious Creation</h3>
                        <p class="text-sm text-luxury-charcoal/60 font-light leading-relaxed">
                            Sustainability is woven into our heritage. We prioritize ethical harvesting and biodegradable packaging to protect the earth that gifts us our scents.
                        </p>
                    </div>

                    <div class="text-center group">
                        <div class="w-16 h-16 mx-auto mb-8 flex items-center justify-center rounded-full border border-luxury-gold/15 group-hover:bg-luxury-gold transition-all duration-500">
                            <i data-lucide="sparkles" class="w-6 h-6 text-luxury-gold group-hover:text-white" style="stroke-width:1"></i>
                        </div>
                        <h3 class="text-xl mb-4">Artistic Freedom</h3>
                        <p class="text-sm text-luxury-charcoal/60 font-light leading-relaxed">
                            Our perfumers are artists first. They are given complete creative liberty to explore olfactory landscapes without the constraints of commercial trends.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Final CTA --}}
        <section class="py-40 text-center px-6">
            <h2 class="text-3xl md:text-4xl text-luxury-charcoal mb-12">Discover Your <span class="serif-italic">Signature</span></h2>
            <a href="{{ route('products.index') }}" class="luxury-button inline-block">
                Explore Collections
            </a>
        </section>
    </div>
@endsection
