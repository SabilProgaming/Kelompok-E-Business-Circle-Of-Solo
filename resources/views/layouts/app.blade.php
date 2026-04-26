<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', "L'ESSENCE"))</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/lucide@latest" defer></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

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
<body class="font-sans min-h-screen bg-[var(--color-background)] text-[var(--color-primary)]" x-data="{ isOpen: false }" x-init="$nextTick(() => window.lucide && window.lucide.createIcons())">
<div class="flex flex-col min-h-screen relative">
    <div class="noise-overlay"></div>

    @php
        $navLinks = [
            ['name' => 'Home', 'route' => 'home', 'active' => fn () => request()->routeIs('home')],
            ['name' => 'Collections', 'route' => 'products.index', 'active' => fn () => request()->routeIs('products.*')],
            ['name' => 'About', 'route' => 'about', 'active' => fn () => request()->routeIs('about')],
            ['name' => 'Contact', 'route' => 'contact', 'active' => fn () => request()->routeIs('contact')],
        ];

        $dashboardRoute = auth()->check() && auth()->user()->role === 'admin' ? route('admin.dashboard') : route('dashboard');
    @endphp

    <nav class="fixed top-6 left-6 right-6 z-50 h-20 px-8 md:px-12 flex items-center justify-between rounded-full bg-white/40 border border-white/20 shadow-2xl backdrop-blur-2xl transition-all duration-500">
        <a href="{{ route('home') }}" class="text-xl md:text-2xl font-light tracking-[0.4em] font-serif uppercase">
            L'ESSENCE
        </a>

        <div class="hidden md:flex items-center space-x-12">
            @foreach($navLinks as $link)
                @php
                    $active = $link['active']();
                @endphp
                <a href="{{ route($link['route']) }}"
                   class="text-[9px] uppercase tracking-[0.3em] font-medium transition-all duration-500 hover:text-[var(--color-secondary)] relative group {{ $active ? 'text-[var(--color-secondary)]' : 'text-[var(--color-accent)]/60' }}">
                    {{ $link['name'] }}
                    <span class="absolute -bottom-1 left-0 h-[1px] bg-[var(--color-secondary)] transition-all duration-500 group-hover:w-full {{ $active ? 'w-full' : 'w-0' }}"></span>
                </a>
            @endforeach
        </div>

        <div class="hidden md:flex items-center space-x-6">
            <button type="button" class="hover:text-[var(--color-secondary)] transition-all duration-300 transform hover:scale-110" aria-label="Search">
                <i data-lucide="search" class="w-[18px] h-[18px]" style="stroke-width:1"></i>
            </button>

            <button type="button" class="hover:text-[var(--color-secondary)] transition-all duration-300 transform hover:scale-110 relative group" aria-label="Cart">
                <i data-lucide="shopping-bag" class="w-[18px] h-[18px]" style="stroke-width:1"></i>
                <span class="absolute -top-1 -right-2 w-4 h-4 bg-[var(--color-secondary)] text-white text-[8px] rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">0</span>
            </button>

            @auth
                <a href="{{ $dashboardRoute }}" class="text-[9px] uppercase tracking-[0.22em] font-semibold text-[var(--color-accent)]/70 hover:text-[var(--color-secondary)] transition-colors">
                    Dashboard
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-[9px] uppercase tracking-[0.22em] font-semibold text-[var(--color-accent)]/70 hover:text-[var(--color-secondary)] transition-colors">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-[9px] uppercase tracking-[0.22em] font-semibold text-[var(--color-accent)]/70 hover:text-[var(--color-secondary)] transition-colors">
                    Sign In
                </a>
                @if(Route::has('register'))
                    <a href="{{ route('register') }}" class="text-[9px] uppercase tracking-[0.22em] font-semibold text-[var(--color-accent)]/70 hover:text-[var(--color-secondary)] transition-colors">
                        Register
                    </a>
                @endif
            @endauth
        </div>

        <button class="md:hidden text-[var(--color-accent)] p-2 rounded-full hover:bg-black/5 transition-colors" @click="isOpen = !isOpen" aria-label="Toggle menu">
            <i data-lucide="menu" class="w-5 h-5" style="stroke-width:1" x-show="!isOpen" x-cloak></i>
            <i data-lucide="x" class="w-5 h-5" style="stroke-width:1" x-show="isOpen" x-cloak></i>
        </button>

        <div class="md:hidden overflow-hidden bg-[#f8f8f3] absolute top-20 left-0 w-full border-t border-gray-100"
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
                       class="text-xl font-serif text-[var(--color-accent)] hover:text-[var(--color-secondary)] tracking-[0.2em] uppercase">
                        {{ $link['name'] }}
                    </a>
                @endforeach

                @auth
                    <a href="{{ $dashboardRoute }}" class="text-sm uppercase tracking-[0.2em] text-[var(--color-accent)]/70">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}" @submit="isOpen = false">
                        @csrf
                        <button type="submit" class="text-sm uppercase tracking-[0.2em] text-[var(--color-accent)]/70">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm uppercase tracking-[0.2em] text-[var(--color-accent)]/70">Sign In</a>
                    @if(Route::has('register'))
                        <a href="{{ route('register') }}" class="text-sm uppercase tracking-[0.2em] text-[var(--color-accent)]/70">Register</a>
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

    <footer class="w-full px-6 md:px-12 py-8 flex flex-col md:flex-row justify-between items-center text-[9px] uppercase tracking-[0.3em] opacity-40 border-t border-[var(--color-secondary)]/10 mt-auto bg-[#f8f8f3] relative z-10">
        <div>© 2026 L'Essence Reseller</div>
        <div class="flex space-x-8 mt-4 md:mt-0">
            <a href="#" class="hover:text-[var(--color-secondary)] transition-colors">Instagram</a>
            <a href="#" class="hover:text-[var(--color-secondary)] transition-colors">Pinterest</a>
            <a href="#" class="hover:text-[var(--color-secondary)] transition-colors">Legal</a>
        </div>
    </footer>
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
</body>
</html>
