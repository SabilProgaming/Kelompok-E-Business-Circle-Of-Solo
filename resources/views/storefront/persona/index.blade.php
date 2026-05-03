@extends('layouts.app')

@section('title', 'Persona Quiz - Sanctum')

@section('content')
<div class="pt-28 min-h-screen" x-data="personaQuiz()" x-cloak>

    {{-- Progress Bar --}}
    <div class="fixed top-[104px] left-0 right-0 z-40 h-1 bg-luxury-clay/30">
        <div class="h-full bg-gradient-to-r from-luxury-gold to-[#d4b066] transition-all duration-700 ease-out" :style="`width: ${progress}%`"></div>
    </div>

    {{-- ===== INTRO SCREEN ===== --}}
    <div x-show="screen === 'intro'" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="max-w-4xl mx-auto px-6 py-16 text-center">
        <div class="space-y-8">
            <span class="text-luxury-gold text-[10px] font-bold tracking-[0.5em] uppercase">AI Expert System</span>
            <h1 class="text-5xl md:text-7xl font-serif font-light leading-tight">
                Temukan <span class="italic">Persona</span><br>Parfum Anda
            </h1>
            <p class="text-luxury-charcoal/50 max-w-xl mx-auto leading-relaxed font-light">
                Jawab 7 pertanyaan singkat dan sistem pakar kami akan menganalisis kepribadian Anda untuk menemukan parfum yang sempurna dari koleksi Sanctum.
            </p>

            <div class="flex flex-wrap justify-center gap-4 pt-4">
                <div class="flex items-center space-x-2 text-[11px] text-luxury-charcoal/40 uppercase tracking-wider">
                    <svg class="w-4 h-4 text-luxury-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>2 menit</span>
                </div>
                <div class="flex items-center space-x-2 text-[11px] text-luxury-charcoal/40 uppercase tracking-wider">
                    <svg class="w-4 h-4 text-luxury-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/></svg>
                    <span>7 pertanyaan</span>
                </div>
                <div class="flex items-center space-x-2 text-[11px] text-luxury-charcoal/40 uppercase tracking-wider">
                    <svg class="w-4 h-4 text-luxury-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/></svg>
                    <span>6 persona</span>
                </div>
            </div>

            <div class="pt-8">
                <button @click="startQuiz()" class="luxury-button rounded-full text-[11px] tracking-[0.25em] px-14 py-5">
                    Mulai Quiz
                </button>
            </div>
        </div>
    </div>

    {{-- ===== QUESTION SCREENS ===== --}}
    <div x-show="screen === 'quiz'" class="max-w-3xl mx-auto px-6 py-12">
        <template x-for="(q, qIndex) in questions" :key="q.id">
            <div x-show="currentQuestion === qIndex"
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 translate-x-8"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 translate-x-0"
                 x-transition:leave-end="opacity-0 -translate-x-8"
            >
                {{-- Question Header --}}
                <div class="text-center mb-12 space-y-4">
                    <span class="text-luxury-gold text-[10px] font-bold tracking-[0.5em] uppercase" x-text="`Pertanyaan ${qIndex + 1} dari ${questions.length}`"></span>
                    <h2 class="text-3xl md:text-4xl font-serif font-light leading-snug" x-text="q.question"></h2>
                    <p class="text-sm text-luxury-charcoal/40 font-light" x-text="q.subtitle"></p>
                </div>

                {{-- Options --}}
                <div class="space-y-3">
                    <template x-for="option in q.options" :key="option.value">
                        <button
                            @click="selectAnswer(q.id, option.value, qIndex)"
                            class="w-full text-left px-6 py-5 rounded-2xl border transition-all duration-400 group flex items-center space-x-4"
                            :class="answers[q.id] === option.value
                                ? 'border-luxury-gold bg-luxury-gold/5 shadow-lg shadow-luxury-gold/10'
                                : 'border-luxury-charcoal/10 bg-white hover:border-luxury-gold/40 hover:bg-luxury-cream/50 hover:shadow-md'"
                        >
                            <span class="text-2xl flex-shrink-0 transition-transform duration-300 group-hover:scale-125" x-text="option.icon"></span>
                            <span class="text-sm font-medium text-luxury-charcoal/80 group-hover:text-luxury-charcoal transition-colors" x-text="option.text"></span>
                            <div class="ml-auto flex-shrink-0">
                                <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center transition-all duration-300"
                                     :class="answers[q.id] === option.value ? 'border-luxury-gold bg-luxury-gold' : 'border-luxury-charcoal/20'">
                                    <svg x-show="answers[q.id] === option.value" class="w-3 h-3 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                    </svg>
                                </div>
                            </div>
                        </button>
                    </template>
                </div>

                {{-- Navigation --}}
                <div class="flex justify-between items-center mt-10">
                    <button
                        x-show="qIndex > 0"
                        @click="prevQuestion()"
                        class="text-[10px] uppercase tracking-[0.3em] text-luxury-charcoal/50 hover:text-luxury-gold transition-colors flex items-center space-x-2"
                    >
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                        <span>Kembali</span>
                    </button>
                    <div x-show="qIndex === 0"></div>

                    <div class="flex items-center space-x-2">
                        <template x-for="(dot, i) in questions" :key="'dot-'+i">
                            <div class="w-2 h-2 rounded-full transition-all duration-300"
                                 :class="i < currentQuestion ? 'bg-luxury-gold' : i === currentQuestion ? 'bg-luxury-gold/50 w-6' : 'bg-luxury-charcoal/10'"></div>
                        </template>
                    </div>
                </div>
            </div>
        </template>
    </div>

    {{-- ===== ANALYZING SCREEN ===== --}}
    <div x-show="screen === 'analyzing'" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="max-w-lg mx-auto px-6 py-32 text-center">
        <div class="space-y-8">
            <div class="relative w-24 h-24 mx-auto">
                <div class="absolute inset-0 rounded-full border-2 border-luxury-gold/20 animate-ping"></div>
                <div class="absolute inset-2 rounded-full border-2 border-luxury-gold/40 animate-pulse"></div>
                <div class="absolute inset-0 rounded-full bg-gradient-to-br from-luxury-gold/10 to-luxury-gold/5 flex items-center justify-center">
                    <svg class="w-10 h-10 text-luxury-gold animate-spin" style="animation-duration: 3s" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                        <path d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>
            <div>
                <h2 class="text-2xl font-serif font-light mb-3">Menganalisis Kepribadian Anda...</h2>
                <p class="text-sm text-luxury-charcoal/40 font-light">Sistem pakar kami sedang mencocokkan profil Anda dengan persona parfum</p>
            </div>
        </div>
    </div>

    {{-- ===== RESULT SCREEN ===== --}}
    <div x-show="screen === 'result'" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" class="max-w-5xl mx-auto px-6 py-12">
        <template x-if="result">
            <div class="space-y-16">
                {{-- Persona Card --}}
                <div class="text-center space-y-6">
                    <span class="text-luxury-gold text-[10px] font-bold tracking-[0.5em] uppercase">Hasil Analisis</span>

                    <div class="relative inline-block">
                        <div class="w-28 h-28 mx-auto rounded-full flex items-center justify-center text-5xl shadow-2xl" :style="`background: ${result.persona.color}15; box-shadow: 0 20px 60px ${result.persona.color}20`">
                            <span x-text="result.persona.emoji"></span>
                        </div>
                    </div>

                    <div>
                        <p class="text-[11px] uppercase tracking-[0.4em] font-bold mb-2" :style="`color: ${result.persona.color}`" x-text="result.persona.title"></p>
                        <h1 class="text-5xl md:text-7xl font-serif font-light" x-text="result.persona.name"></h1>
                    </div>

                    <div class="flex justify-center items-center space-x-2">
                        <div class="w-16 h-1.5 rounded-full overflow-hidden bg-luxury-charcoal/10">
                            <div class="h-full rounded-full transition-all duration-1000" :style="`width: ${result.persona.match_percentage}%; background: ${result.persona.color}`"></div>
                        </div>
                        <span class="text-sm font-semibold" :style="`color: ${result.persona.color}`" x-text="`${result.persona.match_percentage}% match`"></span>
                    </div>

                    <p class="text-luxury-charcoal/60 max-w-2xl mx-auto leading-relaxed font-light" x-text="result.persona.description"></p>

                    {{-- Traits --}}
                    <div class="flex flex-wrap justify-center gap-3 pt-2">
                        <template x-for="trait in result.persona.traits" :key="trait">
                            <span class="text-[10px] uppercase tracking-[0.2em] font-bold px-5 py-2 rounded-full border" :style="`color: ${result.persona.color}; border-color: ${result.persona.color}30; background: ${result.persona.color}08`" x-text="trait"></span>
                        </template>
                    </div>

                    {{-- Ideal Occasions --}}
                    <div class="pt-4">
                        <p class="text-[10px] uppercase tracking-[0.3em] text-luxury-charcoal/40 font-bold mb-3">Momen Ideal</p>
                        <div class="flex flex-wrap justify-center gap-2">
                            <template x-for="occasion in result.persona.ideal_occasions" :key="occasion">
                                <span class="text-xs px-4 py-1.5 rounded-full bg-luxury-cream border border-luxury-gold/10 text-luxury-charcoal/60" x-text="occasion"></span>
                            </template>
                        </div>
                    </div>
                </div>

                {{-- Recommended Products --}}
                <div class="space-y-8" x-show="result.products && result.products.length > 0">
                    <div class="text-center space-y-3">
                        <span class="text-luxury-gold text-[10px] font-bold tracking-[0.5em] uppercase">Rekomendasi Untuk Anda</span>
                        <h2 class="text-3xl md:text-4xl font-serif font-light">Parfum yang <span class="italic">Cocok</span></h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <template x-for="product in result.products" :key="product.id">
                            <a :href="product.url" class="group block">
                                <div class="relative aspect-[4/5] bg-luxury-nude/30 overflow-hidden rounded-xl flex items-center justify-center p-6 group-hover:bg-luxury-clay/20 transition-all duration-700">
                                    <img x-show="product.image" :src="product.image" :alt="product.name" class="w-full h-full object-cover rounded-lg shadow-lg transition-all duration-700 group-hover:scale-105 group-hover:-translate-y-1" />
                                    <div x-show="!product.image" class="w-full h-full bg-gray-100 flex items-center justify-center rounded-lg">
                                        <span class="text-sm text-gray-400">No Image</span>
                                    </div>

                                    {{-- Scent Tags --}}
                                    <div class="absolute top-4 left-4 flex flex-wrap gap-1">
                                        <template x-for="scent in product.scents.slice(0, 2)" :key="scent">
                                            <span class="text-[8px] uppercase tracking-wider font-bold bg-white/90 backdrop-blur-sm px-2 py-1 rounded-full text-luxury-charcoal/60" x-text="scent"></span>
                                        </template>
                                    </div>

                                    <div class="absolute bottom-4 left-4 right-4 translate-y-8 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500 flex justify-center">
                                        <span class="text-[8px] uppercase tracking-[0.3em] text-luxury-gold font-bold bg-white/90 backdrop-blur-md px-5 py-2.5 rounded-full border border-luxury-gold/10">Lihat Detail</span>
                                    </div>
                                </div>
                                <div class="mt-5 text-center space-y-1.5">
                                    <p class="text-[9px] text-luxury-gold font-bold tracking-[0.3em] uppercase" x-text="product.brand"></p>
                                    <h3 class="font-serif text-xl font-light text-luxury-charcoal group-hover:text-luxury-gold transition-colors" x-text="product.name"></h3>
                                    <p class="text-xs text-luxury-charcoal/40 font-light tracking-wider" x-text="product.price"></p>
                                </div>
                            </a>
                        </template>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="text-center space-y-4 pb-16">
                    <button @click="resetQuiz()" class="luxury-button rounded-full text-[11px] tracking-[0.25em] px-14 py-5">
                        Ulangi Quiz
                    </button>
                    <div>
                        <a href="{{ route('products.index') }}" class="text-[10px] uppercase tracking-[0.3em] text-luxury-charcoal/40 hover:text-luxury-gold transition-colors font-medium">
                            Lihat Semua Koleksi →
                        </a>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>

<script>
function personaQuiz() {
    return {
        screen: 'intro',
        currentQuestion: 0,
        questions: @json($questions),
        answers: {},
        result: null,
        isSubmitting: false,

        get progress() {
            if (this.screen === 'intro') return 0;
            if (this.screen === 'result') return 100;
            const answered = Object.keys(this.answers).length;
            return Math.round((answered / this.questions.length) * 100);
        },

        startQuiz() {
            this.screen = 'quiz';
            this.currentQuestion = 0;
            this.answers = {};
            this.result = null;
        },

        selectAnswer(questionId, value, qIndex) {
            this.answers[questionId] = value;

            // Auto-advance after short delay
            setTimeout(() => {
                if (qIndex < this.questions.length - 1) {
                    this.currentQuestion = qIndex + 1;
                } else {
                    this.submitQuiz();
                }
            }, 400);
        },

        prevQuestion() {
            if (this.currentQuestion > 0) {
                this.currentQuestion--;
            }
        },

        async submitQuiz() {
            if (this.isSubmitting) return;
            this.isSubmitting = true;
            this.screen = 'analyzing';

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                const response = await fetch('{{ route("persona.calculate") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ answers: this.answers }),
                });

                const data = await response.json();

                // Show analyzing animation for at least 2 seconds
                await new Promise(resolve => setTimeout(resolve, 2000));

                if (data.success) {
                    this.result = {
                        persona: data.persona,
                        products: data.products,
                    };
                    this.screen = 'result';
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            } catch (error) {
                console.error('Quiz error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
                this.screen = 'quiz';
            } finally {
                this.isSubmitting = false;
            }
        },

        resetQuiz() {
            this.screen = 'intro';
            this.currentQuestion = 0;
            this.answers = {};
            this.result = null;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        },
    };
}
</script>
@endsection
