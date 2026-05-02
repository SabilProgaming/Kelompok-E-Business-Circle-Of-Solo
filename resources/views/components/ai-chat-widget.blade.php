{{-- AI Chat Floating Widget --}}
<div id="ai-chat-widget" x-data="aiChat()" x-cloak>
    {{-- Floating Action Button --}}
    <button
        @click="toggleChat()"
        class="fixed bottom-8 right-8 z-[100] w-16 h-16 rounded-full shadow-2xl flex items-center justify-center transition-all duration-500 hover:scale-110 group"
        :class="isOpen ? 'bg-luxury-charcoal rotate-0' : 'bg-gradient-to-br from-luxury-gold to-[#d4b066] hover:shadow-luxury-gold/40'"
        aria-label="AI Parfum Concierge"
        id="ai-chat-toggle"
    >
        <svg x-show="!isOpen" class="w-7 h-7 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <svg x-show="isOpen" class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>

    {{-- Chat Panel --}}
    <div
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-400"
        x-transition:enter-start="opacity-0 translate-y-8 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-8 scale-95"
        class="fixed bottom-28 right-8 z-[99] w-[400px] max-w-[calc(100vw-2rem)] flex flex-col bg-white rounded-3xl shadow-[0_30px_80px_-20px_rgba(0,0,0,0.25)] border border-luxury-gold/10 overflow-hidden"
        style="height: min(600px, calc(100vh - 10rem));"
    >
        {{-- Header --}}
        <div class="flex-shrink-0 bg-gradient-to-r from-luxury-charcoal to-[#2a2a2a] px-6 py-5 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-luxury-gold to-[#d4b066] flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-white text-sm font-semibold tracking-wide">Sanctum AI Concierge</h3>
                    <p class="text-white/50 text-[10px] tracking-[0.15em] uppercase font-medium">Rekomendasi Parfum</p>
                </div>
            </div>
            <button @click="clearChat()" class="text-white/40 hover:text-luxury-gold transition-colors p-1" title="Reset Chat">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182" />
                </svg>
            </button>
        </div>

        {{-- Messages Area --}}
        <div class="flex-1 overflow-y-auto px-5 py-4 space-y-4 custom-scrollbar" id="ai-chat-messages" x-ref="chatMessages">
            {{-- Welcome Message --}}
            <template x-if="messages.length === 0">
                <div class="space-y-4">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gradient-to-br from-luxury-gold/20 to-luxury-gold/5 flex items-center justify-center">
                            <svg class="w-4 h-4 text-luxury-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div class="bg-luxury-cream/80 border border-luxury-gold/10 rounded-2xl rounded-tl-sm px-4 py-3 max-w-[85%]">
                            <p class="text-sm text-luxury-charcoal leading-relaxed">
                                Selamat datang di <strong>Sanctum</strong> ✨<br><br>
                                Saya AI Concierge Anda. Ceritakan preferensi parfum Anda — aroma favorit, suasana, atau acara — dan saya akan carikan rekomendasi terbaik dari koleksi kami!
                            </p>
                        </div>
                    </div>

                    {{-- Quick Suggestion Chips --}}
                    <div class="flex flex-wrap gap-2 pl-11">
                        <template x-for="suggestion in suggestions" :key="suggestion">
                            <button
                                @click="sendMessage(suggestion)"
                                class="text-[11px] px-4 py-2 rounded-full border border-luxury-gold/20 text-luxury-charcoal/70 hover:bg-luxury-gold hover:text-white hover:border-luxury-gold transition-all duration-300 font-medium"
                                x-text="suggestion"
                            ></button>
                        </template>
                    </div>
                </div>
            </template>

            {{-- Chat Messages --}}
            <template x-for="(msg, index) in messages" :key="index">
                <div :class="msg.role === 'user' ? 'flex justify-end' : 'flex items-start space-x-3'">
                    {{-- AI Avatar --}}
                    <template x-if="msg.role === 'model'">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gradient-to-br from-luxury-gold/20 to-luxury-gold/5 flex items-center justify-center">
                            <svg class="w-4 h-4 text-luxury-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </template>

                    {{-- Message Bubble --}}
                    <div
                        :class="msg.role === 'user'
                            ? 'bg-luxury-charcoal text-white rounded-2xl rounded-tr-sm px-4 py-3 max-w-[80%]'
                            : 'bg-luxury-cream/80 border border-luxury-gold/10 rounded-2xl rounded-tl-sm px-4 py-3 max-w-[85%]'"
                    >
                        <div class="text-sm leading-relaxed whitespace-pre-wrap" x-html="msg.role === 'model' ? formatMarkdown(msg.text) : msg.text"></div>
                    </div>
                </div>
            </template>

            {{-- Product Cards --}}
            <template x-if="recommendedProducts.length > 0">
                <div class="pl-11 space-y-2">
                    <template x-for="product in recommendedProducts" :key="product.id">
                        <a :href="product.url" class="flex items-center space-x-3 bg-white border border-luxury-gold/10 rounded-xl p-3 hover:shadow-md hover:border-luxury-gold/30 transition-all duration-300 group">
                            <div class="w-14 h-14 rounded-lg bg-luxury-nude/50 overflow-hidden flex-shrink-0">
                                <img x-show="product.image" :src="product.image" :alt="product.name" class="w-full h-full object-cover" />
                                <div x-show="!product.image" class="w-full h-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-luxury-gold/40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-[10px] text-luxury-gold font-bold tracking-[0.15em] uppercase" x-text="product.brand"></p>
                                <p class="text-sm font-medium text-luxury-charcoal truncate group-hover:text-luxury-gold transition-colors" x-text="product.name"></p>
                                <div class="flex items-center justify-between mt-1">
                                    <span class="text-xs text-luxury-charcoal/50" x-text="product.price"></span>
                                    <span
                                        class="text-[9px] font-bold uppercase tracking-wider"
                                        :class="product.in_stock ? 'text-green-600' : 'text-red-400'"
                                        x-text="product.in_stock ? 'In Stock' : 'Out of Stock'"
                                    ></span>
                                </div>
                            </div>
                            <svg class="w-4 h-4 text-luxury-gold/40 group-hover:text-luxury-gold transition-colors flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        </a>
                    </template>
                </div>
            </template>

            {{-- Typing Indicator --}}
            <div x-show="isLoading" class="flex items-start space-x-3">
                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gradient-to-br from-luxury-gold/20 to-luxury-gold/5 flex items-center justify-center">
                    <svg class="w-4 h-4 text-luxury-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="bg-luxury-cream/80 border border-luxury-gold/10 rounded-2xl rounded-tl-sm px-5 py-4">
                    <div class="flex items-center space-x-1.5">
                        <span class="w-2 h-2 bg-luxury-gold/50 rounded-full animate-[bounce_1.4s_ease-in-out_infinite]"></span>
                        <span class="w-2 h-2 bg-luxury-gold/50 rounded-full animate-[bounce_1.4s_ease-in-out_0.2s_infinite]"></span>
                        <span class="w-2 h-2 bg-luxury-gold/50 rounded-full animate-[bounce_1.4s_ease-in-out_0.4s_infinite]"></span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Input Area --}}
        <div class="flex-shrink-0 border-t border-luxury-gold/10 bg-white px-4 py-3">
            <form @submit.prevent="sendMessage()" class="flex items-center space-x-3">
                <input
                    type="text"
                    x-model="input"
                    @keydown.enter.prevent="sendMessage()"
                    placeholder="Deskripsikan preferensi parfum Anda..."
                    class="flex-1 text-sm bg-luxury-cream/50 rounded-xl px-4 py-3 border border-luxury-gold/10 focus:border-luxury-gold/40 placeholder:text-luxury-charcoal/30 transition-colors"
                    style="border-bottom: 1px solid rgba(197, 160, 89, 0.1) !important; all: unset; display: block; width: 100%; font-size: 0.875rem; background: rgba(253, 251, 247, 0.5); border-radius: 0.75rem; padding: 0.75rem 1rem; border: 1px solid rgba(197, 160, 89, 0.1) !important;"
                    :disabled="isLoading"
                    id="ai-chat-input"
                />
                <button
                    type="submit"
                    :disabled="isLoading || !input.trim()"
                    class="w-10 h-10 rounded-xl bg-luxury-charcoal text-white flex items-center justify-center hover:bg-luxury-gold transition-all duration-300 disabled:opacity-30 disabled:cursor-not-allowed flex-shrink-0"
                    id="ai-chat-send"
                >
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                    </svg>
                </button>
            </form>
            <p class="text-center text-[9px] text-luxury-charcoal/25 mt-2 tracking-wider">Powered by Groq AI · Sanctum Concierge</p>
        </div>
    </div>
</div>

<script>
function aiChat() {
    return {
        isOpen: false,
        isLoading: false,
        input: '',
        messages: [],
        recommendedProducts: [],
        suggestions: [
            '🌸 Parfum untuk kencan',
            '💼 Parfum untuk meeting',
            '🌿 Aroma segar & ringan',
            '✨ Rekomendasi best seller',
        ],

        toggleChat() {
            this.isOpen = !this.isOpen;
            if (this.isOpen) {
                this.$nextTick(() => {
                    const input = document.getElementById('ai-chat-input');
                    if (input) input.focus();
                });
            }
        },

        clearChat() {
            this.messages = [];
            this.recommendedProducts = [];
        },

        async sendMessage(text = null) {
            const message = text || this.input.trim();
            if (!message || this.isLoading) return;

            this.input = '';
            this.recommendedProducts = [];

            // Add user message
            this.messages.push({ role: 'user', text: message });

            // Scroll to bottom
            this.$nextTick(() => this.scrollToBottom());

            this.isLoading = true;

            try {
                // Build history (limit to last 10 messages for context)
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
                        history: history.slice(0, -1), // Exclude the message we just sent (it'll be added server-side)
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
            // Bold
            let html = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
            // Italic
            html = html.replace(/\*(.*?)\*/g, '<em>$1</em>');
            // Line breaks
            html = html.replace(/\n/g, '<br>');
            return html;
        },
    };
}
</script>
