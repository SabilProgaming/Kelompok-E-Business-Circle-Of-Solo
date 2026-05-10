@extends('layouts.app')

@section('title', "Checkout - Sanctum")

@section('content')
<div class="pt-32 pb-24 px-6 md:px-24 bg-luxury-cream min-h-screen" x-data="checkoutForm()">
    <div class="max-w-7xl mx-auto">
        <div class="mb-12">
            <span class="text-luxury-gold text-[9px] font-bold tracking-[0.5em] uppercase">Secure Checkout</span>
            <h1 class="text-4xl font-serif font-light mt-2">Complete Your <span class="italic">Order</span></h1>
        </div>

        <form id="checkout-form" method="POST" action="{{ route('checkout.pay') }}" class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            @csrf
            
            {{-- Form Kiri --}}
            <div class="lg:col-span-7 space-y-12">
                
                {{-- Shipping Information --}}
                <div class="bg-white p-8 md:p-12 border border-luxury-gold/10">
                    <h2 class="text-xl font-serif italic mb-8 border-b border-luxury-gold/10 pb-4">Shipping Details</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] uppercase tracking-[0.2em] text-luxury-charcoal/60">Recipient Name</label>
                            <input type="text" name="recipient_name" required value="{{ auth()->user()->name }}" class="w-full border-b border-luxury-charcoal/20 py-2 focus:outline-none focus:border-luxury-gold bg-transparent text-sm transition-colors">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] uppercase tracking-[0.2em] text-luxury-charcoal/60">Phone Number</label>
                            <input type="text" name="phone" required class="w-full border-b border-luxury-charcoal/20 py-2 focus:outline-none focus:border-luxury-gold bg-transparent text-sm transition-colors">
                        </div>
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-[10px] uppercase tracking-[0.2em] text-luxury-charcoal/60 flex justify-between items-center">
                                Complete Address 
                                <span class="text-[8px] text-luxury-gold flex items-center gap-1"><i data-lucide="map-pin" class="w-3 h-3"></i> Drag pin to locate</span>
                            </label>
                            
                            {{-- Interactive Map Container --}}
                            <div class="w-full h-48 border border-luxury-charcoal/20 rounded-sm overflow-hidden relative" id="checkoutMap"></div>
                            
                            <textarea id="shipping_address" name="shipping_address" required rows="2" placeholder="Street name, building, apartment number..." class="w-full border-b border-luxury-charcoal/20 py-2 focus:outline-none focus:border-luxury-gold bg-transparent text-sm transition-colors resize-none mt-2"></textarea>
                        </div>

                        {{-- Leaflet JS integration for Checkout --}}
                        @push('styles')
                            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
                        @endpush
                        @push('scripts')
                            <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    // Default to Jakarta
                                    var defaultLat = -6.200000;
                                    var defaultLng = 106.816666;
                                    
                                    var map = L.map('checkoutMap').setView([defaultLat, defaultLng], 13);
                                    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                                        attribution: '&copy; OpenStreetMap contributors'
                                    }).addTo(map);

                                    var marker = L.marker([defaultLat, defaultLng], {draggable: true}).addTo(map);

                                    // Try to get user's actual location
                                    if ("geolocation" in navigator) {
                                        navigator.geolocation.getCurrentPosition(function(position) {
                                            var lat = position.coords.latitude;
                                            var lng = position.coords.longitude;
                                            map.setView([lat, lng], 15);
                                            marker.setLatLng([lat, lng]);
                                            fetchLocationDetails(lat, lng);
                                        });
                                    }

                                    marker.on('dragend', function (e) {
                                        var position = marker.getLatLng();
                                        fetchLocationDetails(position.lat, position.lng);
                                    });

                                    map.on('click', function(e) {
                                        marker.setLatLng(e.latlng);
                                        fetchLocationDetails(e.latlng.lat, e.latlng.lng);
                                    });

                                    function fetchLocationDetails(lat, lng) {
                                        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                                            .then(res => res.json())
                                            .then(data => {
                                                if(data && data.display_name) {
                                                    document.getElementById('shipping_address').value = data.display_name;
                                                    // Trigger input event for any framework listeners
                                                    document.getElementById('shipping_address').dispatchEvent(new Event('input'));
                                                }
                                            });
                                    }
                                });
                            </script>
                        @endpush

                        {{-- Destination Search (Komerce) --}}
                        <div class="space-y-2 md:col-span-2 relative">
                            <label class="text-[10px] uppercase tracking-[0.2em] text-luxury-charcoal/60">Destination (City / District)</label>
                            <div class="relative">
                                <input type="text" 
                                       x-model="destinationKeyword" 
                                       @input.debounce.400ms="searchDestination()"
                                       @focus="showDropdown = destinationResults.length > 0"
                                       @click.outside="showDropdown = false"
                                       placeholder="Type your city or district name... (min 3 chars)"
                                       required
                                       :value="selectedDestinationLabel"
                                       class="w-full border-b border-luxury-charcoal/20 py-2 focus:outline-none focus:border-luxury-gold bg-transparent text-sm transition-colors pr-8">
                                <div x-show="searchingDest" class="absolute right-2 top-2.5">
                                    <svg class="w-4 h-4 animate-spin text-luxury-gold" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" stroke-dasharray="32" stroke-dashoffset="32"/></svg>
                                </div>
                            </div>
                            <input type="hidden" name="city_name" :value="selectedDestinationLabel">
                            <input type="hidden" name="province" :value="selectedDestinationLabel">

                            {{-- Dropdown results --}}
                            <div x-show="showDropdown && destinationResults.length > 0" 
                                 x-transition
                                 class="absolute z-50 left-0 right-0 top-full mt-1 bg-white border border-luxury-gold/20 shadow-xl max-h-64 overflow-y-auto">
                                <template x-for="(dest, idx) in destinationResults" :key="idx">
                                    <button type="button" 
                                            @click="selectDestination(dest)"
                                            class="w-full text-left px-4 py-3 text-sm hover:bg-luxury-gold/5 transition-colors border-b border-luxury-gold/5 last:border-0">
                                        <span class="text-luxury-charcoal font-medium" x-text="dest.label || (dest.sub_district + ', ' + dest.city + ', ' + dest.province)"></span>
                                    </button>
                                </template>
                            </div>

                            {{-- Selected destination chip --}}
                            <template x-if="selectedDestinationId">
                                <div class="mt-2 inline-flex items-center gap-2 px-4 py-2 bg-luxury-charcoal text-white text-[10px] uppercase tracking-widest">
                                    <span x-text="selectedDestinationLabel"></span>
                                    <button type="button" @click="clearDestination()" class="text-white/60 hover:text-white text-lg leading-none">&times;</button>
                                </div>
                            </template>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] uppercase tracking-[0.2em] text-luxury-charcoal/60">Postal Code</label>
                            <input type="text" name="postal_code" required x-model="postalCode" class="w-full border-b border-luxury-charcoal/20 py-2 focus:outline-none focus:border-luxury-gold bg-transparent text-sm transition-colors">
                        </div>
                    </div>
                </div>

                {{-- Shipping Method --}}
                <div class="bg-white p-8 md:p-12 border border-luxury-gold/10">
                    <h2 class="text-xl font-serif italic mb-8 border-b border-luxury-gold/10 pb-4">Shipping Method</h2>

                    {{-- Calculate Button --}}
                    <div class="mb-6">
                        <button type="button" @click="fetchShippingCosts()"
                                :disabled="!selectedDestinationId"
                                :class="!selectedDestinationId ? 'opacity-40 cursor-not-allowed' : 'hover:bg-luxury-gold hover:text-white'"
                                class="w-full py-3 border border-luxury-gold text-luxury-gold text-[10px] uppercase tracking-[0.2em] font-bold transition-all duration-300">
                            <span x-text="loadingCost ? 'Calculating shipping costs...' : 'Calculate Shipping Cost'"></span>
                        </button>
                    </div>

                    {{-- Loading --}}
                    <div x-show="loadingCost" class="py-6 text-center">
                        <div class="inline-flex items-center space-x-2 text-luxury-charcoal/40">
                            <svg class="w-4 h-4 animate-spin" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" stroke-dasharray="32" stroke-dashoffset="32" class="animate-[dash_1.5s_ease-in-out_infinite]"/></svg>
                            <span class="text-[10px] uppercase tracking-[0.2em]">Fetching shipping options from couriers...</span>
                        </div>
                    </div>

                    {{-- Service Options --}}
                    <div x-show="shippingOptions.length > 0 && !loadingCost" class="space-y-3">
                        <template x-for="(opt, idx) in shippingOptions" :key="idx">
                            <label :class="selectedShippingService === idx ? 'border-luxury-gold bg-luxury-gold/5 ring-1 ring-luxury-gold' : 'border-luxury-charcoal/10 hover:border-luxury-gold/30'"
                                   class="flex items-center justify-between p-4 border cursor-pointer transition-all duration-300">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="shipping_service" :value="idx" x-model.number="selectedShippingService"
                                           @change="updateShippingCost()"
                                           class="text-luxury-gold focus:ring-luxury-gold">
                                    <div>
                                        <p class="text-sm font-semibold text-luxury-charcoal" x-text="opt.courier + ' - ' + opt.service"></p>
                                        <p class="text-[10px] text-luxury-charcoal/40 mt-0.5" x-text="'Estimasi: ' + opt.etd"></p>
                                    </div>
                                </div>
                                <span class="font-mono text-sm font-bold text-luxury-gold" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(opt.cost)"></span>
                            </label>
                        </template>
                    </div>

                    {{-- No destination selected --}}
                    <div x-show="!selectedDestinationId && shippingOptions.length === 0 && !loadingCost" class="py-6 text-center">
                        <p class="text-sm text-luxury-charcoal/40 italic">Please search and select your destination above to see shipping options.</p>
                    </div>

                    <input type="hidden" name="shipping_cost" :value="shippingCost">
                    <input type="hidden" name="shipping_courier" :value="selectedCourierName">
                    <input type="hidden" name="shipping_service_name" :value="selectedServiceName">
                </div>

                <input type="hidden" name="payment_method" value="midtrans">
            </div>

            {{-- Summary Kanan --}}
            <div class="lg:col-span-5">
                <div class="bg-luxury-charcoal text-white p-8 md:p-12 sticky top-32">
                    <h2 class="text-xl font-serif italic mb-8 border-b border-white/10 pb-4">Order Summary</h2>
                    
                    <div class="space-y-6 mb-8 max-h-[40vh] overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($cartItems as $item)
                        <div class="flex gap-4">
                            <div class="w-16 h-20 bg-white/5 flex-shrink-0">
                                @php($img = $item->productVariant->product->images->first()?->image_url)
                                @if($img)
                                <img src="{{ \Illuminate\Support\Str::startsWith($img, ['http://', 'https://', '/']) ? $img : asset('storage/' . ltrim($img, '/')) }}" class="w-full h-full object-cover opacity-80" alt="{{ $item->productVariant->product->name }}">
                                @endif
                            </div>
                            <div class="flex-1 text-sm">
                                <p class="font-serif">{{ $item->productVariant->product->name }}</p>
                                <p class="text-[10px] text-white/50 tracking-widest uppercase mt-1">{{ $item->productVariant->name }} x{{ $item->quantity }}</p>
                                <p class="text-luxury-gold mt-2 font-mono text-xs">Rp {{ number_format($item->productVariant->price * $item->quantity, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="space-y-4 border-t border-white/10 pt-6 text-sm">
                        <div class="flex justify-between text-white/70">
                            <span>Subtotal</span>
                            <span class="font-mono">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-white/70">
                            <span>Shipping</span>
                            <span class="font-mono" x-text="shippingCost > 0 ? 'Rp ' + new Intl.NumberFormat('id-ID').format(shippingCost) : 'Select shipping'"></span>
                        </div>
                        <div class="flex justify-between text-lg pt-4 border-t border-white/10">
                            <span class="font-serif italic">Total</span>
                            <span class="font-mono text-luxury-gold" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format({{ $subtotal }} + shippingCost)"></span>
                        </div>
                    </div>

                    <button type="button" id="pay-button"
                            :disabled="shippingCost <= 0"
                            :class="shippingCost <= 0 ? 'opacity-40 cursor-not-allowed' : 'hover:bg-white hover:text-luxury-charcoal'"
                            class="w-full mt-10 py-5 bg-luxury-gold transition-colors duration-500 text-[10px] uppercase tracking-[0.3em] font-bold text-white">
                        Pay Now
                    </button>
                    <p id="payment-error" class="text-xs text-red-400 mt-4 hidden"></p>
                    
                    <p class="text-[9px] text-center text-white/40 mt-6 leading-relaxed">
                        By placing your order, you agree to our Terms of Service and Privacy Policy. Secure payment processing provided by Sanctum.
                    </p>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
function checkoutForm() {
    return {
        // Destination search
        destinationKeyword: '',
        destinationResults: [],
        selectedDestinationId: '',
        selectedDestinationLabel: '',
        showDropdown: false,
        searchingDest: false,
        postalCode: '',

        // Shipping
        shippingOptions: [],
        selectedShippingService: -1,
        shippingCost: 0,
        selectedCourierName: '',
        selectedServiceName: '',
        loadingCost: false,

        init() {
            this.setupPayButton();
        },

        async searchDestination() {
            const keyword = this.destinationKeyword.trim();
            if (keyword.length < 3) {
                this.destinationResults = [];
                this.showDropdown = false;
                return;
            }

            this.searchingDest = true;
            try {
                const res = await fetch(`/api/shipping/search-destination?keyword=${encodeURIComponent(keyword)}`);
                const data = await res.json();
                
                // Normalize the response - Komerce may return different structures
                if (Array.isArray(data)) {
                    this.destinationResults = data.map(d => ({
                        id: String(d.id || d.destination_id || ''),
                        label: d.label || [d.sub_district, d.city, d.province].filter(Boolean).join(', '),
                        postal_code: d.postal_code || d.zip_code || '',
                    }));
                } else {
                    this.destinationResults = [];
                }
                
                this.showDropdown = this.destinationResults.length > 0;
            } catch (e) {
                console.error('Failed to search destination', e);
                this.destinationResults = [];
            } finally {
                this.searchingDest = false;
            }
        },

        selectDestination(dest) {
            this.selectedDestinationId = dest.id;
            this.selectedDestinationLabel = dest.label;
            this.destinationKeyword = dest.label;
            this.postalCode = dest.postal_code || this.postalCode;
            this.showDropdown = false;
            
            // Reset shipping when destination changes
            this.shippingOptions = [];
            this.shippingCost = 0;
            this.selectedShippingService = -1;
        },

        clearDestination() {
            this.selectedDestinationId = '';
            this.selectedDestinationLabel = '';
            this.destinationKeyword = '';
            this.postalCode = '';
            this.shippingOptions = [];
            this.shippingCost = 0;
            this.selectedShippingService = -1;
        },

        async fetchShippingCosts() {
            if (!this.selectedDestinationId) return;

            this.loadingCost = true;
            this.shippingOptions = [];
            this.shippingCost = 0;
            this.selectedShippingService = -1;

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                const res = await fetch('/api/shipping/calculate', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        receiver_destination_id: this.selectedDestinationId,
                        weight: 0.5,
                        item_value: {{ $subtotal }},
                    }),
                });

                const data = await res.json();
                
                // Normalize Komerce response to a flat list of options
                if (Array.isArray(data)) {
                    this.shippingOptions = data.map(d => ({
                        courier: d.shipping || d.courier || d.expedition || '-',
                        service: d.service || d.type || '-',
                        cost: d.cost || d.price || d.shipping_cost || 0,
                        etd: d.etd || d.estimation || d.estimate || '-',
                    })).filter(d => d.cost > 0);
                } else if (data && typeof data === 'object') {
                    // Might be nested by courier
                    const options = [];
                    Object.values(data).forEach(courierData => {
                        if (Array.isArray(courierData)) {
                            courierData.forEach(d => {
                                options.push({
                                    courier: d.shipping || d.courier || d.expedition || '-',
                                    service: d.service || d.type || '-',
                                    cost: d.cost || d.price || d.shipping_cost || 0,
                                    etd: d.etd || d.estimation || d.estimate || '-',
                                });
                            });
                        }
                    });
                    this.shippingOptions = options.filter(d => d.cost > 0);
                }
            } catch (e) {
                console.error('Failed to fetch shipping cost', e);
            } finally {
                this.loadingCost = false;
            }
        },

        updateShippingCost() {
            if (this.selectedShippingService >= 0 && this.shippingOptions[this.selectedShippingService]) {
                const opt = this.shippingOptions[this.selectedShippingService];
                this.shippingCost = opt.cost;
                this.selectedCourierName = opt.courier;
                this.selectedServiceName = opt.courier + ' - ' + opt.service;
            }
        },

        setupPayButton() {
            const payButton = document.getElementById('pay-button');
            const paymentError = document.getElementById('payment-error');
            const checkoutForm = document.getElementById('checkout-form');

            if (payButton && checkoutForm) {
                payButton.addEventListener('click', async () => {
                    if (this.shippingCost <= 0) return;
                    
                    payButton.disabled = true;
                    paymentError?.classList.add('hidden');

                    try {
                        const formData = new FormData(checkoutForm);
                        const response = await fetch(checkoutForm.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: formData
                        });

                        if (!response.ok) throw new Error('Failed to start payment');

                        const data = await response.json();
                        if (!data.snapToken || !data.order_number) throw new Error('Missing payment token');

                        window.snap.pay(data.snapToken, {
                            onSuccess: function () {
                                window.location.href = "{{ route('checkout.success', '__ORDER__') }}".replace('__ORDER__', data.order_number);
                            },
                            onPending: function () {
                                window.location.href = "{{ route('checkout.success', '__ORDER__') }}".replace('__ORDER__', data.order_number);
                            },
                            onError: function () {
                                if (paymentError) { paymentError.textContent = 'Payment failed. Please try again.'; paymentError.classList.remove('hidden'); }
                            },
                            onClose: function () {
                                if (paymentError) { paymentError.textContent = 'Payment popup closed. You can retry anytime.'; paymentError.classList.remove('hidden'); }
                            }
                        });
                    } catch (error) {
                        if (paymentError) { paymentError.textContent = 'Payment initialization failed. Please check your details.'; paymentError.classList.remove('hidden'); }
                    } finally {
                        payButton.disabled = false;
                    }
                });
            }
        },
    };
}
</script>
@endpush
