@extends('layouts.app')

@section('title', 'Account Settings - Sanctum')

@section('content')
<div class="relative pt-32 pb-24 px-6 md:px-24 min-h-screen">
    {{-- Page Background --}}
    <div class="fixed inset-0 z-0 pointer-events-none">
        <img src="{{ asset('images/profile-bg.png') }}" alt="Sanctum Background" class="w-full h-full object-cover opacity-40">
        <div class="absolute inset-0 bg-gradient-to-b from-luxury-cream/60 via-luxury-cream/90 to-luxury-cream"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto">

        {{-- Header --}}
        <div class="mb-16 border-b border-luxury-gold/20 pb-8 flex justify-between items-end">
            <div>
                <span class="text-luxury-gold text-[9px] font-bold tracking-[0.5em] uppercase">Private Member</span>
                <h1 class="text-4xl font-serif font-light mt-2">My <span class="italic">Profile</span></h1>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-[10px] uppercase tracking-[0.3em] font-bold text-luxury-charcoal/50 hover:text-red-500 transition-colors">
                    Sign Out
                </button>
            </form>
        </div>

        <div class="max-w-3xl mx-auto space-y-10">

                {{-- Success Messages --}}
                @if (session('status') === 'profile-updated')
                <div class="bg-emerald-50 border border-emerald-200 px-6 py-4 flex items-center gap-3" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition>
                    <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                    <p class="text-sm text-emerald-800">Profile information updated successfully.</p>
                </div>
                @endif

                @if (session('status') === 'password-updated')
                <div class="bg-emerald-50 border border-emerald-200 px-6 py-4 flex items-center gap-3" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition>
                    <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                    <p class="text-sm text-emerald-800">Password updated successfully.</p>
                </div>
                @endif

                {{-- Profile Summary Card --}}
                <div class="bg-luxury-charcoal text-luxury-cream p-8 md:p-10 relative overflow-hidden shadow-2xl mb-8">
                    <div class="absolute inset-0 pattern-dots opacity-5 pointer-events-none"></div>
                    <div class="relative z-10 flex items-center gap-6">
                        <div class="w-20 h-20 bg-luxury-gold flex items-center justify-center rounded-full text-white text-3xl font-serif">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <h2 class="text-3xl font-serif">{{ $user->name }}</h2>
                            <p class="text-[10px] uppercase tracking-[0.2em] text-luxury-cream/60 mt-2">{{ $user->email }}</p>
                            <p class="text-[10px] uppercase tracking-[0.2em] text-luxury-gold mt-1">Member since {{ $user->created_at->format('F Y') }}</p>
                        </div>
                    </div>
                </div>

                {{-- Profile Information Form --}}
                <div class="bg-white border border-luxury-gold/10 p-8 md:p-10">
                    <h2 class="text-xl font-serif italic mb-2">Edit Profile</h2>
                    <p class="text-[10px] uppercase tracking-[0.2em] text-luxury-charcoal/40 mb-8">Update your account name and email address</p>

                    <form method="post" action="{{ route('profile.update') }}" class="space-y-6 max-w-xl">
                        @csrf
                        @method('patch')

                        <div class="space-y-2">
                            <label for="name" class="text-[10px] uppercase tracking-[0.2em] text-luxury-charcoal/60 font-semibold">Full Name</label>
                            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
                                   class="w-full border-b border-luxury-charcoal/10 py-3 focus:outline-none focus:border-luxury-gold bg-transparent text-sm transition-colors placeholder:text-luxury-charcoal/30">
                            @error('name')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="email" class="text-[10px] uppercase tracking-[0.2em] text-luxury-charcoal/60 font-semibold">Email Address</label>
                            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
                                   class="w-full border-b border-luxury-charcoal/10 py-3 focus:outline-none focus:border-luxury-gold bg-transparent text-sm transition-colors placeholder:text-luxury-charcoal/30">
                            @error('email')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="phone" class="text-[10px] uppercase tracking-[0.2em] text-luxury-charcoal/60 font-semibold">Phone Number</label>
                            <input id="phone" name="phone" type="text" value="{{ old('phone', $user->phone) }}"
                                   class="w-full border-b border-luxury-charcoal/10 py-3 focus:outline-none focus:border-luxury-gold bg-transparent text-sm transition-colors placeholder:text-luxury-charcoal/30">
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] uppercase tracking-[0.2em] text-luxury-charcoal/60 font-semibold flex justify-between items-center">
                                Complete Address
                                <span class="text-[8px] text-luxury-gold flex items-center gap-1"><i data-lucide="map-pin" class="w-3 h-3"></i> Drag pin to locate</span>
                            </label>

                            {{-- Interactive Map Container --}}
                            <div class="w-full h-48 border border-luxury-charcoal/20 rounded-sm overflow-hidden relative" id="profileMap"></div>
                            
                            <textarea id="address" name="address" rows="3" class="w-full border-b border-luxury-charcoal/10 py-3 focus:outline-none focus:border-luxury-gold bg-transparent text-sm transition-colors resize-none placeholder:text-luxury-charcoal/30 mt-2">{{ old('address', $user->address) }}</textarea>
                        </div>

                        {{-- Leaflet JS integration for Profile --}}
                        @push('styles')
                            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
                        @endpush
                        @push('scripts')
                            <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    var defaultLat = -6.200000;
                                    var defaultLng = 106.816666;
                                    
                                    var map = L.map('profileMap').setView([defaultLat, defaultLng], 13);
                                    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                                        attribution: '&copy; OpenStreetMap contributors'
                                    }).addTo(map);

                                    var marker = L.marker([defaultLat, defaultLng], {draggable: true}).addTo(map);

                                    // If user has no address, try to geolocate
                                    var currentAddress = document.getElementById('address').value;
                                    if (!currentAddress && "geolocation" in navigator) {
                                        navigator.geolocation.getCurrentPosition(function(position) {
                                            var lat = position.coords.latitude;
                                            var lng = position.coords.longitude;
                                            map.setView([lat, lng], 15);
                                            marker.setLatLng([lat, lng]);
                                        });
                                    }

                                    marker.on('dragend', function (e) {
                                        var position = marker.getLatLng();
                                        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${position.lat}&lon=${position.lng}`)
                                            .then(res => res.json())
                                            .then(data => {
                                                if(data && data.display_name) {
                                                    document.getElementById('address').value = data.display_name;
                                                }
                                            });
                                    });

                                    map.on('click', function(e) {
                                        marker.setLatLng(e.latlng);
                                        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${e.latlng.lat}&lon=${e.latlng.lng}`)
                                            .then(res => res.json())
                                            .then(data => {
                                                if(data && data.display_name) {
                                                    document.getElementById('address').value = data.display_name;
                                                }
                                            });
                                    });
                                });
                            </script>
                        @endpush

                        <div class="pt-4">
                            <button type="submit" class="luxury-button">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Update Password --}}
                <div class="bg-white border border-luxury-gold/10 p-8 md:p-10">
                    <h2 class="text-xl font-serif italic mb-2">Update Password</h2>
                    <p class="text-[10px] uppercase tracking-[0.2em] text-luxury-charcoal/40 mb-8">Ensure your account uses a strong, unique password</p>

                    <form method="post" action="{{ route('password.update') }}" class="space-y-6 max-w-xl">
                        @csrf
                        @method('put')

                        <div class="space-y-2">
                            <label for="current_password" class="text-[10px] uppercase tracking-[0.2em] text-luxury-charcoal/60 font-semibold">Current Password</label>
                            <input id="current_password" name="current_password" type="password" autocomplete="current-password"
                                   class="w-full border-b border-luxury-charcoal/10 py-3 focus:outline-none focus:border-luxury-gold bg-transparent text-sm transition-colors placeholder:text-luxury-charcoal/30">
                            @error('current_password', 'updatePassword')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="password" class="text-[10px] uppercase tracking-[0.2em] text-luxury-charcoal/60 font-semibold">New Password</label>
                            <input id="password" name="password" type="password" autocomplete="new-password"
                                   class="w-full border-b border-luxury-charcoal/10 py-3 focus:outline-none focus:border-luxury-gold bg-transparent text-sm transition-colors placeholder:text-luxury-charcoal/30">
                            @error('password', 'updatePassword')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="password_confirmation" class="text-[10px] uppercase tracking-[0.2em] text-luxury-charcoal/60 font-semibold">Confirm New Password</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                                   class="w-full border-b border-luxury-charcoal/10 py-3 focus:outline-none focus:border-luxury-gold bg-transparent text-sm transition-colors placeholder:text-luxury-charcoal/30">
                            @error('password_confirmation', 'updatePassword')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="luxury-button">
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Danger Zone --}}
                <div class="bg-white border border-red-200/50 p-8 md:p-10" x-data="{ showDelete: false }">
                    <h2 class="text-xl font-serif italic mb-2 text-red-600/80">Danger Zone</h2>
                    <p class="text-[10px] uppercase tracking-[0.2em] text-luxury-charcoal/40 mb-6">Permanently delete your account and all associated data</p>

                    <button @click="showDelete = !showDelete"
                            class="px-8 py-3 border border-red-300 text-red-600 text-[10px] uppercase tracking-[0.3em] font-bold hover:bg-red-600 hover:text-white hover:border-red-600 transition-colors duration-500">
                        Delete Account
                    </button>

                    <div x-show="showDelete" x-cloak x-transition class="mt-6 p-6 bg-red-50 border border-red-200">
                        <p class="text-sm text-red-700 mb-4">
                            Once your account is deleted, all of its resources and data will be permanently removed. Please enter your password to confirm.
                        </p>
                        <form method="post" action="{{ route('profile.destroy') }}" class="space-y-4 max-w-sm">
                            @csrf
                            @method('delete')

                            <div class="space-y-2">
                                <label for="delete_password" class="text-[10px] uppercase tracking-[0.2em] text-red-600/60 font-semibold">Confirm Password</label>
                                <input id="delete_password" name="password" type="password" placeholder="Enter your password"
                                       class="w-full border-b border-red-300 py-3 focus:outline-none focus:border-red-600 bg-transparent text-sm transition-colors">
                                @error('password', 'userDeletion')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex gap-3">
                                <button type="submit" class="px-6 py-2.5 bg-red-600 text-white text-[10px] uppercase tracking-[0.3em] font-bold hover:bg-red-700 transition-colors">
                                    Confirm Delete
                                </button>
                                <button type="button" @click="showDelete = false" class="px-6 py-2.5 border border-luxury-charcoal/20 text-[10px] uppercase tracking-[0.3em] font-bold text-luxury-charcoal/60 hover:bg-luxury-charcoal hover:text-white transition-colors">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

        </div>
    </div>
</div>
@endsection
