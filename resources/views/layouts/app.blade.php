<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', "Sanctum"))</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    <script src="https://unpkg.com/lucide@latest" defer></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @stack('head')

    {{-- Apply dark theme immediately to prevent flash --}}
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark-theme-preload');
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }

        .noise-overlay {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            opacity: 0.04;
            background-image: radial-gradient(circle at 1px 1px, rgba(0, 0, 0, 0.35) 1px, transparent 0);
            background-size: 3px 3px;
        }
    </style>
</head>
<body class="font-sans min-h-screen transition-colors duration-700">
<div class="flex flex-col min-h-screen relative"
     x-data="{
         isOpen: false,
         isDark: (localStorage.getItem('theme') === 'dark'),
         toggleDark() {
             this.isDark = !this.isDark;
             localStorage.setItem('theme', this.isDark ? 'dark' : 'light');
             document.body.classList.toggle('dark-theme', this.isDark);
         }
     }"
     x-init="
         if (isDark) document.body.classList.add('dark-theme');
         document.documentElement.classList.remove('dark-theme-preload');
         $nextTick(() => { if(window.lucide) window.lucide.createIcons(); });
     ">
    <div class="noise-overlay"></div>

    @php
        $navLinks = [
            ['name' => 'Home', 'route' => 'home', 'active' => fn () => request()->routeIs('home')],
            ['name' => 'Collections', 'route' => 'products.index', 'active' => fn () => request()->routeIs('products.*')],
            ['name' => 'Compare', 'route' => 'compare.index', 'active' => fn () => request()->routeIs('compare.*')],
            ['name' => 'Persona Quiz', 'route' => 'persona.index', 'active' => fn () => request()->routeIs('persona.*')],
            ['name' => 'AI Concierge', 'route' => 'ai.index', 'active' => fn () => request()->routeIs('ai.index')],
            ['name' => 'About', 'route' => 'about', 'active' => fn () => request()->routeIs('about')],
            ['name' => 'Contact', 'route' => 'contact', 'active' => fn () => request()->routeIs('contact')],
        ];

        $dashboardRoute = auth()->check() && auth()->user()->role === 'admin' ? route('admin.dashboard') : null;
        $cartRoute = auth()->check() ? route('cart.index') : route('login');
        $cartCount = auth()->check()
            ? \App\Models\CartItem::query()
                ->whereHas('cart', fn ($query) => $query->where('user_id', auth()->id()))
                ->sum('quantity')
            : 0;
    @endphp

    <nav class="fixed top-6 left-6 right-6 z-50 h-20 px-8 md:px-12 flex items-center justify-between rounded-full glass-nav">
        <a href="{{ route('home') }}" class="text-xl md:text-2xl font-light tracking-[0.4em] font-serif uppercase text-luxury-charcoal">
            Sanctum
        </a>

        <div class="hidden md:flex items-center space-x-12">
            @foreach($navLinks as $link)
                @php
                    $active = $link['active']();
                @endphp
                <a href="{{ route($link['route']) }}"
                   class="text-[9px] uppercase tracking-[0.3em] font-medium transition-all duration-500 hover:text-luxury-gold relative group {{ $active ? 'text-luxury-gold' : 'text-luxury-charcoal/60' }}">
                    {{ $link['name'] }}
                    <span class="absolute -bottom-1 left-0 h-[1px] bg-luxury-gold transition-all duration-500 group-hover:w-full {{ $active ? 'w-full' : 'w-0' }}"></span>
                </a>
            @endforeach
        </div>

        <div class="hidden md:flex items-center space-x-6">
            <button type="button" @click="toggleDark()" class="hover:text-luxury-gold transition-all duration-300 transform hover:scale-110 text-luxury-charcoal" aria-label="Toggle Dark Mode" id="dark-mode-toggle">
                <svg x-show="!isDark" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/></svg>
                <svg x-show="isDark" x-cloak xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/></svg>
            </button>
            <button type="button" class="hover:text-luxury-gold transition-all duration-300 transform hover:scale-110 text-luxury-charcoal" aria-label="Search">
                <i data-lucide="search" class="w-[18px] h-[18px]" style="stroke-width:1"></i>
            </button>

            <a href="{{ $cartRoute }}" class="hover:text-luxury-gold transition-all duration-300 transform hover:scale-110 relative group text-luxury-charcoal" aria-label="Cart">
                <i data-lucide="shopping-bag" class="w-[18px] h-[18px]" style="stroke-width:1"></i>
                @if($cartCount > 0)
                    <span class="absolute -top-1 -right-2 w-4 h-4 bg-luxury-gold text-white text-[8px] rounded-full flex items-center justify-center">
                        {{ $cartCount }}
                    </span>
                @endif
            </a>

            <div class="w-px h-4 bg-luxury-charcoal/20"></div>

            @auth
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" class="flex items-center gap-2 hover:text-luxury-gold transition-colors group">
                        <div class="w-8 h-8 rounded-full border border-luxury-charcoal/20 flex items-center justify-center bg-luxury-cream group-hover:border-luxury-gold transition-colors">
                            <i data-lucide="user" class="w-4 h-4 text-luxury-charcoal group-hover:text-luxury-gold transition-colors" style="stroke-width:1.5"></i>
                        </div>
                    </button>
                    
                    <div x-show="open" x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-2"
                         class="absolute right-0 mt-4 w-48 bg-white border border-luxury-gold/10 shadow-2xl py-2 z-50">
                        
                        <div class="px-4 py-3 border-b border-luxury-charcoal/5 mb-2">
                            <p class="text-[10px] uppercase tracking-[0.2em] text-luxury-charcoal/40 mb-1">Signed in as</p>
                            <p class="text-xs font-bold text-luxury-charcoal truncate">{{ auth()->user()->name }}</p>
                        </div>

                        @if($dashboardRoute)
                            <a href="{{ $dashboardRoute }}" class="block px-4 py-2 text-[10px] uppercase tracking-[0.2em] text-luxury-charcoal/70 hover:text-luxury-gold hover:bg-luxury-cream transition-colors">
                                Admin Dashboard
                            </a>
                        @endif
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-[10px] uppercase tracking-[0.2em] text-luxury-charcoal/70 hover:text-luxury-gold hover:bg-luxury-cream transition-colors">
                            My Profile
                        </a>
                        <a href="{{ route('user.dashboard') }}" class="block px-4 py-2 text-[10px] uppercase tracking-[0.2em] text-luxury-charcoal/70 hover:text-luxury-gold hover:bg-luxury-cream transition-colors">
                            My Orders
                        </a>
                        <a href="{{ route('wishlist.index') }}" class="block px-4 py-2 text-[10px] uppercase tracking-[0.2em] text-luxury-charcoal/70 hover:text-luxury-gold hover:bg-luxury-cream transition-colors">
                            Wishlist
                        </a>
                        
                        <div class="border-t border-luxury-charcoal/5 mt-2 pt-2">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-[10px] uppercase tracking-[0.2em] text-red-500 hover:bg-red-50 transition-colors">
                                    Sign Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="text-[9px] uppercase tracking-[0.22em] font-semibold text-luxury-charcoal/70 hover:text-luxury-gold transition-colors whitespace-nowrap">
                    Sign In
                </a>
                @if(Route::has('register'))
                    <a href="{{ route('register') }}" class="text-[9px] uppercase tracking-[0.22em] font-semibold px-4 py-2 border border-luxury-charcoal/30 text-luxury-charcoal/70 hover:border-luxury-gold hover:text-luxury-gold transition-all duration-300 whitespace-nowrap">
                        Register
                    </a>
                @endif
            @endauth
        </div>

        <button class="md:hidden text-luxury-charcoal p-2 rounded-full hover:bg-black/5 transition-colors" @click="isOpen = !isOpen" aria-label="Toggle menu">
            <i data-lucide="menu" class="w-5 h-5" style="stroke-width:1" x-show="!isOpen" x-cloak></i>
            <i data-lucide="x" class="w-5 h-5" style="stroke-width:1" x-show="isOpen" x-cloak></i>
        </button>

        <div class="md:hidden overflow-hidden bg-luxury-cream absolute top-20 left-0 w-full border-t border-luxury-gold/10"
             x-show="isOpen"
             x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2">
            <div class="flex flex-col items-center justify-center min-h-[calc(100vh-80px)] space-y-8 p-6">
                @foreach($navLinks as $link)
                    <a href="{{ route($link['route']) }}"
                       @click="isOpen = false"
                       class="text-xl font-serif text-luxury-charcoal hover:text-luxury-gold tracking-[0.2em] uppercase">
                        {{ $link['name'] }}
                    </a>
                @endforeach

                <a href="{{ $cartRoute }}" @click="isOpen = false" class="text-xl font-serif text-luxury-charcoal hover:text-luxury-gold tracking-[0.2em] uppercase">
                    Shopping Bag
                </a>

                <div class="w-12 h-px bg-luxury-charcoal/20"></div>

                @auth
                    @if($dashboardRoute)
                        <a href="{{ $dashboardRoute }}" @click="isOpen = false" class="text-sm uppercase tracking-[0.2em] text-luxury-charcoal/70 hover:text-luxury-gold">Dashboard</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" @submit="isOpen = false" class="w-full flex justify-center">
                        @csrf
                        <button type="submit" class="inline-flex items-center text-sm uppercase tracking-[0.2em] text-luxury-charcoal/70 hover:text-luxury-gold leading-none">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" @click="isOpen = false" class="text-sm uppercase tracking-[0.2em] text-luxury-charcoal/70 hover:text-luxury-gold">Sign In</a>
                    @if(Route::has('register'))
                        <a href="{{ route('register') }}" @click="isOpen = false" class="text-sm uppercase tracking-[0.2em] px-4 py-2 border border-luxury-charcoal/30 text-luxury-charcoal/70 hover:border-luxury-gold hover:text-luxury-gold transition-all duration-300">Register</a>
                    @endif
                @endauth
            </div>
        </div>
    </nav>

    <main class="flex-grow relative z-10">
        @hasSection('content')
            @yield('content')
        @else
            {{ $slot ?? '' }}
        @endif
    </main>

    <footer class="w-full px-6 md:px-12 py-8 flex flex-col md:flex-row justify-between items-center text-[9px] uppercase tracking-[0.3em] opacity-40 border-t border-luxury-gold/10 mt-auto bg-luxury-cream relative z-10">
        <div>© 2026 Sanctum Reseller</div>
        <div class="flex space-x-8 mt-4 md:mt-0">
            <a href="#" class="hover:text-luxury-gold transition-colors">Instagram</a>
            <a href="#" class="hover:text-luxury-gold transition-colors">Pinterest</a>
            <a href="#" class="hover:text-luxury-gold transition-colors">Legal</a>
        </div>
    </footer>

    {{-- AI Parfum Concierge Chatbot --}}
    @include('components.ai-chat-widget')
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (window.lucide && typeof window.lucide.createIcons === 'function') {
            window.lucide.createIcons();
        }
    });

    document.addEventListener('alpine:navigated', () => {
        if (window.lucide && typeof window.lucide.createIcons === 'function') {
            window.lucide.createIcons();
        }
    });
</script>

@stack('scripts')
    @stack('scripts')
</body>
</html>
