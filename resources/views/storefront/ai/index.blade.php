@extends('layouts.app')

@section('title', 'AI Concierge - Sanctum')

@section('content')
<div class="relative min-h-screen overflow-hidden" x-data="aiConcierge()" x-cloak>

    {{-- Full-Screen Background --}}
    <div class="fixed inset-0 z-0">
        <img src="{{ asset('images/ai-bg.png') }}" alt="Sanctum AI Background"
             class="w-full h-full object-cover object-center"
             style="image-rendering: high-quality;">
        <div class="absolute inset-0 bg-gradient-to-r from-black/60 via-black/30 to-black/50"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-black/40"></div>
    </div>

    {{-- Floating Gold Particles --}}
    <div class="fixed inset-0 z-[1] pointer-events-none overflow-hidden">
        <div class="particle particle-1"></div>
        <div class="particle particle-2"></div>
        <div class="particle particle-3"></div>
        <div class="particle particle-4"></div>
        <div class="particle particle-5"></div>
        <div class="particle particle-6"></div>
        <div class="particle particle-7"></div>
        <div class="particle particle-8"></div>
    </div>

    {{-- Main Content --}}
    <div class="relative z-10 flex flex-col items-center justify-center min-h-screen pt-28 pb-8 px-4">

        {{-- Hero Header --}}
        <div class="text-center mb-8 max-w-2xl" x-show="messages.length === 0"
             x-transition:enter="transition ease-out duration-700"
             x-transition:enter-start="opacity-0 translate-y-6"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0 -translate-y-4">
            <div class="inline-flex items-center space-x-3 mb-6">
                <div class="w-px h-8 bg-gradient-to-b from-transparent via-luxury-gold to-transparent"></div>
                <span class="text-[10px] uppercase tracking-[0.4em] text-luxury-gold/80 font-medium">Powered by AI</span>
                <div class="w-px h-8 bg-gradient-to-b from-transparent via-luxury-gold to-transparent"></div>
            </div>
            <h1 class="text-5xl md:text-7xl font-serif text-white mb-4 leading-tight">
                Scent<br><em class="text-luxury-gold">Concierge</em>
            </h1>
            <p class="text-white/50 text-sm md:text-base leading-relaxed max-w-lg mx-auto">
                Ceritakan suasana hati, acara, atau preferensi aroma Anda — dan biarkan AI kami memilihkan wewangian sempurna dari koleksi <strong class="text-white/70">Sanctum</strong>.
            </p>
        </div>

        {{-- Chat Container --}}
        <div class="w-full max-w-2xl flex flex-col flex-1"
             :class="messages.length > 0 ? 'max-h-[calc(100vh-10rem)]' : 'max-h-[50vh]'"
             style="transition: max-height 0.5s ease;">

            {{-- Messages Area --}}
            <div class="flex-1 overflow-y-auto px-2 space-y-5 mb-4 ai-scrollbar" x-ref="chatMessages"
                 :class="messages.length > 0 ? 'opacity-100' : 'opacity-0 pointer-events-none h-0'"
                 style="transition: opacity 0.5s ease;">

                <template x-for="(msg, index) in messages" :key="index">
                    <div :class="msg.role === 'user' ? 'flex justify-end' : 'flex items-start space-x-3'"
                         class="animate-fade-in-up">
                        {{-- AI Avatar --}}
                        <template x-if="msg.role === 'model'">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-gradient-to-br from-luxury-gold/30 to-luxury-gold/10 border border-luxury-gold/20 flex items-center justify-center backdrop-blur-sm">
                                <svg class="w-5 h-5 text-luxury-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M9 2h6a1 1 0 0 1 1 1v2H8V3a1 1 0 0 1 1-1zM11 5h2v2h-2zM6 7h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2zM9 12h6v5H9z" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                        </template>

                        {{-- Message Bubble --}}
                        <div :class="msg.role === 'user'
                                ? 'bg-luxury-gold/90 text-white rounded-2xl rounded-tr-sm px-5 py-3.5 max-w-[75%] shadow-lg shadow-luxury-gold/10'
                                : 'bg-white/10 backdrop-blur-md border border-white/10 text-white/90 rounded-2xl rounded-tl-sm px-5 py-3.5 max-w-[80%]'">
                            <div class="text-sm leading-relaxed whitespace-pre-wrap" x-html="msg.role === 'model' ? formatMarkdown(msg.text) : msg.text"></div>
                        </div>
                    </div>
                </template>

                {{-- Product Cards --}}
                <template x-if="recommendedProducts.length > 0">
                    <div class="pl-13 space-y-2">
                        <template x-for="product in recommendedProducts" :key="product.id">
                            <a :href="product.url" class="flex items-center space-x-3 bg-white/10 backdrop-blur-md border border-white/10 rounded-xl p-3 hover:bg-white/20 hover:border-luxury-gold/30 transition-all duration-300 group">
                                <div class="w-14 h-14 rounded-lg bg-white/10 overflow-hidden flex-shrink-0">
                                    <img x-show="product.image" :src="product.image" :alt="product.name" class="w-full h-full object-cover" />
                                    <div x-show="!product.image" class="w-full h-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-luxury-gold/40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                                            <path d="M9 2h6a1 1 0 0 1 1 1v2H8V3a1 1 0 0 1 1-1zM11 5h2v2h-2zM6 7h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2zM9 12h6v5H9z" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-[10px] text-luxury-gold font-bold tracking-[0.15em] uppercase" x-text="product.brand"></p>
                                    <p class="text-sm font-medium text-white truncate group-hover:text-luxury-gold transition-colors" x-text="product.name"></p>
                                    <div class="flex items-center justify-between mt-1">
                                        <span class="text-xs text-white/50" x-text="product.price"></span>
                                        <span class="text-[9px] font-bold uppercase tracking-wider"
                                              :class="product.in_stock ? 'text-emerald-400' : 'text-red-400'"
                                              x-text="product.in_stock ? 'In Stock' : 'Out of Stock'"></span>
                                    </div>
                                </div>
                                <svg class="w-4 h-4 text-white/30 group-hover:text-luxury-gold transition-colors flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                </svg>
                            </a>
                        </template>
                    </div>
                </template>

                {{-- Typing Indicator --}}
                <div x-show="isLoading" class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-gradient-to-br from-luxury-gold/30 to-luxury-gold/10 border border-luxury-gold/20 flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-5 h-5 text-luxury-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M9 2h6a1 1 0 0 1 1 1v2H8V3a1 1 0 0 1 1-1zM11 5h2v2h-2zM6 7h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2zM9 12h6v5H9z" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md border border-white/10 rounded-2xl rounded-tl-sm px-5 py-4">
                        <div class="flex items-center space-x-1.5">
                            <span class="w-2 h-2 bg-luxury-gold/70 rounded-full animate-[bounce_1.4s_ease-in-out_infinite]"></span>
                            <span class="w-2 h-2 bg-luxury-gold/70 rounded-full animate-[bounce_1.4s_ease-in-out_0.2s_infinite]"></span>
                            <span class="w-2 h-2 bg-luxury-gold/70 rounded-full animate-[bounce_1.4s_ease-in-out_0.4s_infinite]"></span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Suggestion Chips (only when no messages) --}}
            <div x-show="messages.length === 0" class="flex flex-wrap justify-center gap-3 mb-6"
                 x-transition:enter="transition ease-out duration-500 delay-300"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0">
                <template x-for="suggestion in suggestions" :key="suggestion">
                    <button @click="sendMessage(suggestion)"
                            class="text-xs px-5 py-2.5 rounded-full border border-luxury-gold/30 text-white/70 hover:bg-luxury-gold hover:text-white hover:border-luxury-gold hover:shadow-lg hover:shadow-luxury-gold/20 transition-all duration-300 font-medium backdrop-blur-sm bg-white/5"
                            x-text="suggestion">
                    </button>
                </template>
            </div>

            {{-- Input Area --}}
            <div class="flex-shrink-0">
                <form @submit.prevent="sendMessage()" class="relative">
                    <div class="flex items-center space-x-3 bg-white/10 backdrop-blur-xl rounded-2xl border border-white/15 px-5 py-2 shadow-2xl shadow-black/20 focus-within:border-luxury-gold/40 transition-all duration-300">
                        <svg class="w-5 h-5 text-luxury-gold/50 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M9 2h6a1 1 0 0 1 1 1v2H8V3a1 1 0 0 1 1-1zM11 5h2v2h-2zM6 7h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2zM9 12h6v5H9z" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <input
                            type="text"
                            x-model="input"
                            @keydown.enter.prevent="sendMessage()"
                            placeholder="Deskripsikan preferensi parfum Anda..."
                            class="flex-1 bg-transparent text-white text-sm placeholder:text-white/30 outline-none py-3 border-none focus:ring-0"
                            :disabled="isLoading"
                            id="ai-page-input"
                            autocomplete="off"
                        />
                        <button
                            type="submit"
                            :disabled="isLoading || !input.trim()"
                            class="w-10 h-10 rounded-xl bg-gradient-to-br from-luxury-gold to-[#d4b066] text-white flex items-center justify-center hover:shadow-lg hover:shadow-luxury-gold/30 transition-all duration-300 disabled:opacity-30 disabled:cursor-not-allowed flex-shrink-0 hover:scale-105 active:scale-95"
                            id="ai-page-send"
                        >
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                            </svg>
                        </button>
                    </div>
                </form>
                <p class="text-center text-[9px] text-white/20 mt-3 tracking-wider">Powered by Groq AI · Sanctum Scent Concierge</p>
            </div>
        </div>
    </div>
</div>

<style>
    /* Hide the floating widget on this page */
    #ai-chat-widget { display: none !important; }

    /* Hide the regular footer on this page */
    footer { display: none !important; }

    /* Custom scrollbar */
    .ai-scrollbar::-webkit-scrollbar { width: 4px; }
    .ai-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .ai-scrollbar::-webkit-scrollbar-thumb { background: rgba(197, 160, 89, 0.3); border-radius: 10px; }
    .ai-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(197, 160, 89, 0.5); }

    /* Fade-in-up animation */
    .animate-fade-in-up {
        animation: fadeInUp 0.4s ease-out;
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(12px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Floating particles */
    .particle {
        position: absolute;
        width: 3px;
        height: 3px;
        background: radial-gradient(circle, rgba(197, 160, 89, 0.8), transparent);
        border-radius: 50%;
        animation: floatParticle linear infinite;
    }
    .particle-1 { left: 10%; animation-duration: 18s; animation-delay: 0s; width: 4px; height: 4px; }
    .particle-2 { left: 25%; animation-duration: 22s; animation-delay: 2s; }
    .particle-3 { left: 40%; animation-duration: 16s; animation-delay: 4s; width: 2px; height: 2px; }
    .particle-4 { left: 55%; animation-duration: 20s; animation-delay: 1s; }
    .particle-5 { left: 70%; animation-duration: 24s; animation-delay: 3s; width: 4px; height: 4px; }
    .particle-6 { left: 85%; animation-duration: 17s; animation-delay: 5s; }
    .particle-7 { left: 15%; animation-duration: 21s; animation-delay: 7s; width: 2px; height: 2px; }
    .particle-8 { left: 65%; animation-duration: 19s; animation-delay: 6s; }

    @keyframes floatParticle {
        0% { bottom: -5%; opacity: 0; }
        10% { opacity: 0.8; }
        90% { opacity: 0.3; }
        100% { bottom: 105%; opacity: 0; transform: translateX(40px); }
    }

    /* Override navbar style for dark bg */
    nav.glass-nav {
        background: rgba(0, 0, 0, 0.4) !important;
        backdrop-filter: blur(20px) !important;
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
    }
    nav.glass-nav a, nav.glass-nav button {
        color: rgba(255, 255, 255, 0.7) !important;
    }
    nav.glass-nav a:hover, nav.glass-nav button:hover {
        color: rgb(197, 160, 89) !important;
    }
    nav.glass-nav a.text-luxury-gold {
        color: rgb(197, 160, 89) !important;
    }
</style>

@push('scripts')
<script>
function aiConcierge() {
    return {
        isOpen: true,
        isLoading: false,
        input: '',
        messages: [],
        recommendedProducts: [],
        suggestions: [
            '🌸 Parfum untuk kencan romantis',
            '💼 Parfum untuk meeting formal',
            '🌿 Aroma segar & ringan',
            '✨ Rekomendasi best seller',
            '🌙 Parfum misterius & sensual',
            '🎁 Hadiah parfum untuk pria',
        ],

        async sendMessage(text = null) {
            const message = text || this.input.trim();
            if (!message || this.isLoading) return;

            this.input = '';
            this.recommendedProducts = [];

            this.messages.push({ role: 'user', text: message });
            this.$nextTick(() => this.scrollToBottom());
            this.isLoading = true;

            try {
                const history = this.messages.slice(-10).map(m => ({
                    role: m.role,
                    text: m.text,
                }));

                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                const response = await fetch('/ai/chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        message: message,
                        history: history.slice(0, -1),
                    }),
                });

                const data = await response.json();

                if (data.success) {
                    this.messages.push({ role: 'model', text: data.message });
                    if (data.products && data.products.length > 0) {
                        this.recommendedProducts = data.products;
                    }
                } else {
                    this.messages.push({ role: 'model', text: data.message || 'Maaf, terjadi kesalahan. Silakan coba lagi.' });
                }
            } catch (error) {
                console.error('AI Chat error:', error);
                this.messages.push({ role: 'model', text: 'Koneksi terputus. Silakan coba lagi. 🙏' });
            } finally {
                this.isLoading = false;
                this.$nextTick(() => this.scrollToBottom());
            }
        },

        scrollToBottom() {
            const container = this.$refs.chatMessages;
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        },

        formatMarkdown(text) {
            if (!text) return '';
            let html = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
            html = html.replace(/\*(.*?)\*/g, '<em>$1</em>');
            html = html.replace(/\n/g, '<br>');
            return html;
        },
    };
}
</script>
@endpush
@endsection
