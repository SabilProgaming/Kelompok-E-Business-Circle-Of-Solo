@extends('layouts.app')

@section('title', "Home - L'ESSENCE")

@section('content')
    {{-- TEAM NOTE: Halaman ini masih DUMMY untuk validasi layout storefront. --}}
    {{-- PAGE PURPOSE: Halaman landing/home customer untuk menampilkan hero, CTA utama, highlight koleksi, dan trust content. --}}
    <section class="pt-40 pb-24 px-6 md:px-12">
        <div class="max-w-5xl mx-auto text-center">
            <div class="max-w-3xl mx-auto border border-amber-200 bg-amber-50 px-4 py-3 text-xs text-amber-800 mb-8">
                <strong>DUMMY PAGE:</strong> Ini placeholder halaman Home. Tim silakan isi versi final (hero visual, section promo, featured products, dll).
            </div>

            <p class="text-[10px] uppercase tracking-[0.3em] text-[var(--color-secondary)] font-bold">Dummy Home</p>
            <h1 class="mt-5 text-4xl md:text-6xl font-serif text-[var(--color-primary)]">Layout Check</h1>
            <p class="mt-6 text-sm md:text-base text-[var(--color-accent)]/70 max-w-2xl mx-auto">
                Ini konten dummy sederhana untuk memastikan navbar, spacing, typography, dan footer pada layout customer sudah tampil benar.
            </p>
        </div>
    </section>

    <section class="pb-24 px-6 md:px-12">
        <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white border border-gray-100 shadow-sm p-6">
                <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold">Block 01</p>
                <p class="mt-3 text-sm text-[var(--color-accent)]/70">Sample card content for alignment test.</p>
            </div>
            <div class="bg-white border border-gray-100 shadow-sm p-6">
                <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold">Block 02</p>
                <p class="mt-3 text-sm text-[var(--color-accent)]/70">Sample card content for spacing test.</p>
            </div>
            <div class="bg-white border border-gray-100 shadow-sm p-6">
                <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold">Block 03</p>
                <p class="mt-3 text-sm text-[var(--color-accent)]/70">Sample card content for color test.</p>
            </div>
        </div>
    </section>
@endsection
