@extends('layouts.app')

@section('title', "Concierge - Sanctum")

@section('content')
    <div class="animate-fade-in">
        {{-- Hero Section --}}
        <section class="relative h-[60vh] flex items-center justify-center overflow-hidden">
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/contact-hero.png') }}" alt="Sanctum Concierge" class="w-full h-full object-cover opacity-40">
                <div class="absolute inset-0 bg-gradient-to-b from-luxury-cream/20 via-transparent to-luxury-cream"></div>
            </div>
            
            <div class="relative z-10 text-center px-6">
                <span class="text-[10px] uppercase tracking-[0.5em] text-luxury-gold mb-6 block">Personalized Assistance</span>
                <h1 class="text-5xl md:text-6xl font-serif text-luxury-charcoal mb-8">The <span class="serif-italic">Concierge</span></h1>
                <div class="w-24 h-px bg-luxury-gold mx-auto"></div>
            </div>
        </section>

        <section class="py-24 px-6 md:px-12 bg-luxury-cream">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-24">
                    {{-- Contact Info --}}
                    <div>
                        <h2 class="text-3xl text-luxury-charcoal mb-12">Reach <span class="serif-italic">Out</span></h2>
                        <p class="text-luxury-charcoal/60 leading-relaxed font-light mb-16 max-w-md">
                            Whether you seek guidance in choosing your signature scent or require assistance with an order, our specialists are here to provide an elevated experience.
                        </p>

                        <div class="space-y-12">
                            <div class="flex items-start space-x-6">
                                <div class="w-10 h-10 flex items-center justify-center rounded-full border border-luxury-gold/10 text-luxury-gold shrink-0">
                                    <i data-lucide="mail" class="w-4 h-4" style="stroke-width:1.5"></i>
                                </div>
                                <div>
                                    <h4 class="text-[10px] uppercase tracking-[0.2em] text-luxury-gold mb-2">Email Inquiry</h4>
                                    <p class="text-luxury-charcoal font-medium">sanctumparfume@gmail.com</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-6">
                                <div class="w-10 h-10 flex items-center justify-center rounded-full border border-luxury-gold/10 text-luxury-gold shrink-0">
                                    <i data-lucide="phone" class="w-4 h-4" style="stroke-width:1.5"></i>
                                </div>
                                <div>
                                    <h4 class="text-[10px] uppercase tracking-[0.2em] text-luxury-gold mb-2">Client Services</h4>
                                    <p class="text-luxury-charcoal font-medium">+62 821-7941-4079</p>
                                    <p class="text-[10px] text-luxury-charcoal/40 mt-1 uppercase tracking-wider">Mon - Fri, 9am - 6pm WIB</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-6">
                                <div class="w-10 h-10 flex items-center justify-center rounded-full border border-luxury-gold/10 text-luxury-gold shrink-0">
                                    <i data-lucide="map-pin" class="w-4 h-4" style="stroke-width:1.5"></i>
                                </div>
                                <div class="w-full">
                                    <h4 class="text-[10px] uppercase tracking-[0.2em] text-luxury-gold mb-2">The Atelier</h4>
                                    <p class="text-luxury-charcoal font-medium">Kedaton, Bandar Lampung</p>
                                    <p class="text-luxury-charcoal font-medium mb-6">Lampung, Indonesia</p>
                                    
                                    <div class="w-full h-48 md:h-64 rounded-sm overflow-hidden border border-luxury-charcoal/10 relative filter grayscale opacity-90 hover:grayscale-0 hover:opacity-100 transition-all duration-500">
                                        <iframe 
                                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d127116.32!2d105.1837!3d-5.3853!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e40db24a25925bf%3A0xc66c0d024e031a01!2sKedaton%2C%20Bandar%20Lampung%20City%2C%20Lampung!5e0!3m2!1sen!2sid!4v1" 
                                            width="100%" 
                                            height="100%" 
                                            style="border:0;" 
                                            allowfullscreen="" 
                                            loading="lazy" 
                                            referrerpolicy="no-referrer-when-downgrade"
                                            class="absolute inset-0">
                                        </iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Contact Form --}}
                    <div class="bg-white p-12 shadow-[0_32px_64px_-15px_rgba(0,0,0,0.05)] border border-luxury-charcoal/[0.02] relative" x-data="{ sent: false, sending: false, name: '', email: '', inquiry: 'Product Guidance', message: '' }">
                        <div class="absolute inset-0 pattern-dots opacity-5 pointer-events-none"></div>
                        
                        <div x-show="!sent" class="relative z-10">
                            <h3 class="text-xl mb-10 text-luxury-charcoal uppercase tracking-widest font-light">Direct Message</h3>
                            
                            <form @submit.prevent="
                                sending = true;
                                fetch('{{ route('contact.store') }}', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                                    body: JSON.stringify({ name, email, inquiry_type: inquiry, message })
                                }).then(r => r.json()).then(() => { sent = true; }).catch(() => { alert('Failed to send message.'); }).finally(() => { sending = false; });
                            " class="space-y-10">
                                <div class="auth-form">
                                    <label class="text-[9px] uppercase tracking-[0.3em] text-luxury-gold mb-2 block">Full Name</label>
                                    <input type="text" x-model="name" placeholder="Your name" required class="w-full">
                                </div>

                                <div class="auth-form">
                                    <label class="text-[9px] uppercase tracking-[0.3em] text-luxury-gold mb-2 block">Email Address</label>
                                    <input type="email" x-model="email" placeholder="your@email.com" required class="w-full">
                                </div>

                                <div class="auth-form">
                                    <label class="text-[9px] uppercase tracking-[0.3em] text-luxury-gold mb-2 block">Nature of Inquiry</label>
                                    <select x-model="inquiry" class="w-full bg-transparent border-none border-b border-luxury-charcoal/20 py-2 focus:ring-0 focus:border-luxury-gold text-sm font-light">
                                        <option>Product Guidance</option>
                                        <option>Order Assistance</option>
                                        <option>Reseller Inquiry</option>
                                        <option>Press & Media</option>
                                    </select>
                                </div>

                                <div class="auth-form">
                                    <label class="text-[9px] uppercase tracking-[0.3em] text-luxury-gold mb-2 block">Message</label>
                                    <textarea x-model="message" placeholder="How may we assist you?" required rows="4" class="w-full bg-transparent border-none border-b border-luxury-charcoal/20 py-2 focus:ring-0 focus:border-luxury-gold resize-none text-sm font-light"></textarea>
                                </div>

                                <button type="submit" :disabled="sending" class="luxury-button w-full">
                                    <span x-text="sending ? 'Sending...' : 'Send Message'"></span>
                                </button>
                            </form>
                        </div>

                        {{-- Success Message --}}
                        <div x-show="sent" x-cloak class="h-full flex flex-col items-center justify-center text-center animate-fade-in relative z-10">
                            <div class="w-20 h-20 bg-luxury-gold/10 rounded-full flex items-center justify-center mb-8">
                                <i data-lucide="check" class="w-8 h-8 text-luxury-gold"></i>
                            </div>
                            <h3 class="text-2xl mb-4">Message Received</h3>
                            <p class="text-luxury-charcoal/60 font-light max-w-xs mx-auto">
                                Thank you for reaching out. A Sanctum specialist will respond to your inquiry within 24 hours.
                            </p>
                            <button @click="sent = false" class="mt-12 text-[9px] uppercase tracking-[0.3em] text-luxury-gold hover:text-luxury-charcoal transition-colors">
                                Send another message
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
