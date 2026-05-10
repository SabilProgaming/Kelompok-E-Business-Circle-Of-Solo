@extends('layouts.app')

@section('title', "Order #{$order->order_number} - Sanctum")

@section('content')
<div class="pt-32 pb-24 px-6 md:px-24 bg-luxury-cream min-h-screen">
    <div class="max-w-5xl mx-auto">

        {{-- Back button --}}
        <a href="{{ route('user.dashboard') }}" class="inline-flex items-center text-[10px] uppercase tracking-[0.3em] font-bold text-luxury-charcoal/50 hover:text-luxury-gold transition-colors mb-8 group">
            <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
            Back to Dashboard
        </a>

        {{-- Header --}}
        <div class="mb-12">
            <span class="text-luxury-gold text-[9px] font-bold tracking-[0.5em] uppercase">Order Details</span>
            <h1 class="text-4xl font-serif font-light mt-2">Order <span class="italic">{{ $order->order_number }}</span></h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Left Column: Items + Timeline --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- Order Items --}}
                <div class="bg-white border border-luxury-gold/10 p-8">
                    <h2 class="text-xl font-serif italic mb-6 border-b border-luxury-gold/10 pb-4">Items Ordered</h2>
                    <div class="space-y-6">
                        @foreach($order->items as $item)
                        <div class="flex items-center gap-5">
                            <div class="w-20 h-24 bg-luxury-cream flex-shrink-0 overflow-hidden">
                                @php($img = $item->productVariant?->product?->images?->first()?->image_url)
                                @if($img)
                                <img src="{{ \Illuminate\Support\Str::startsWith($img, ['http://', 'https://', '/']) ? $img : asset('storage/' . ltrim($img, '/')) }}" 
                                     class="w-full h-full object-cover" alt="{{ $item->product_name }}">
                                @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-luxury-charcoal/20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                                        <path d="M9 2h6a1 1 0 0 1 1 1v2H8V3a1 1 0 0 1 1-1zM11 5h2v2h-2zM6 7h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2zM9 12h6v5H9z" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-serif text-lg">{{ $item->product_name ?? $item->productVariant?->product?->name }}</h3>
                                <p class="text-[10px] uppercase tracking-widest text-luxury-charcoal/50 mt-1">
                                    {{ $item->variant_name ?? $item->productVariant?->name }} &bull; Qty: {{ $item->quantity }}
                                </p>
                                <p class="text-xs text-luxury-charcoal/40 mt-1">
                                    Rp {{ number_format($item->unit_price, 0, ',', '.') }} / item
                                </p>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <p class="font-mono text-sm font-bold text-luxury-charcoal">
                                    Rp {{ number_format($item->subtotal ?? ($item->unit_price * $item->quantity), 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Totals --}}
                    <div class="border-t border-luxury-charcoal/10 mt-8 pt-6 space-y-3 text-sm">
                        <div class="flex justify-between text-luxury-charcoal/60">
                            <span>Subtotal</span>
                            <span class="font-mono">Rp {{ number_format($order->total_price - $order->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-luxury-charcoal/60">
                            <span>Shipping</span>
                            <span class="font-mono">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-xl pt-4 border-t border-luxury-charcoal/10">
                            <span class="font-serif italic">Total</span>
                            <span class="font-mono font-bold text-luxury-gold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Order Timeline --}}
                <div class="bg-white border border-luxury-gold/10 p-8">
                    <h2 class="text-xl font-serif italic mb-6 border-b border-luxury-gold/10 pb-4">Order Timeline</h2>
                    @php
                        $statuses = ['paid' => 'Payment Confirmed', 'processing' => 'Being Prepared', 'shipped' => 'Shipped', 'completed' => 'Delivered'];
                        $statusOrder = array_keys($statuses);
                        $currentIndex = array_search($order->status, $statusOrder);
                        if ($currentIndex === false) $currentIndex = -1;
                    @endphp
                    <div class="space-y-0">
                        @foreach($statuses as $key => $label)
                        @php
                            $stepIndex = array_search($key, $statusOrder);
                            $isCompleted = $stepIndex <= $currentIndex;
                            $isCurrent = $key === $order->status;
                        @endphp
                        <div class="flex items-start gap-4 relative">
                            {{-- Connector Line --}}
                            @if(!$loop->last)
                            <div class="absolute left-[15px] top-[30px] w-0.5 h-[calc(100%)] {{ $isCompleted ? 'bg-luxury-gold' : 'bg-luxury-charcoal/10' }}"></div>
                            @endif

                            {{-- Dot --}}
                            <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 relative z-10
                                {{ $isCompleted ? 'bg-luxury-gold text-white' : 'bg-luxury-charcoal/10 text-luxury-charcoal/30' }}
                                {{ $isCurrent ? 'ring-4 ring-luxury-gold/20' : '' }}">
                                @if($isCompleted)
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                @else
                                <div class="w-2 h-2 rounded-full bg-current"></div>
                                @endif
                            </div>

                            {{-- Label --}}
                            <div class="pb-8">
                                <p class="text-sm font-semibold {{ $isCompleted ? 'text-luxury-charcoal' : 'text-luxury-charcoal/30' }}">{{ $label }}</p>
                                @if($isCurrent)
                                <p class="text-[10px] uppercase tracking-[0.2em] text-luxury-gold font-bold mt-1">Current Status</p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

                @if(in_array($order->status, ['shipped', 'completed']))
                {{-- RajaOngkir Waybill Simulation --}}
                <div class="bg-white border border-luxury-gold/10 p-8 mt-8">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b border-luxury-gold/10 pb-4 mb-6 gap-3">
                        <div>
                            <h2 class="text-xl font-serif italic">Live Tracking</h2>
                            <p class="text-[9px] uppercase tracking-widest text-luxury-charcoal/50 mt-1">RajaOngkir Simulated Waybill</p>
                        </div>
                        <div class="flex flex-col items-end">
                            <span class="px-3 py-1 bg-luxury-charcoal text-[9px] uppercase tracking-[0.2em] font-bold text-luxury-cream">AWB: JNE-{{ rand(1000000000, 9999999999) }}</span>
                            <span class="text-[9px] uppercase tracking-widest text-luxury-charcoal/40 mt-1">Courier: JNE REG</span>
                        </div>
                    </div>
                    
                    <div class="space-y-6 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-luxury-gold/50 before:via-luxury-gold/20 before:to-transparent">
                        
                        @if($order->status === 'completed')
                        {{-- Delivered --}}
                        <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group">
                            <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white bg-emerald-500 text-white shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                            </div>
                            <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded bg-emerald-50/50 border border-emerald-100 shadow-sm relative">
                                <div class="flex items-center justify-between space-x-2 mb-1">
                                    <div class="font-bold text-emerald-800 text-xs uppercase tracking-widest">Delivered</div>
                                    <div class="text-[9px] text-emerald-600/70">{{ now()->subHours(2)->format('d M Y, H:i') }}</div>
                                </div>
                                <div class="text-emerald-700 text-xs mt-2">Paket telah diterima oleh: {{ explode(' ', $order->recipient_name)[0] }} (Ybs)</div>
                            </div>
                        </div>
                        @endif

                        {{-- In Transit --}}
                        <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group">
                            <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white {{ $order->status === 'shipped' ? 'bg-luxury-gold text-white animate-pulse' : 'bg-luxury-charcoal/20 text-luxury-charcoal' }} shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
                            </div>
                            <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded bg-white {{ $order->status === 'shipped' ? 'border border-luxury-gold/50 shadow-md ring-1 ring-luxury-gold/10' : 'border border-luxury-charcoal/10 shadow-sm' }} relative">
                                <div class="flex items-center justify-between space-x-2 mb-1">
                                    <div class="font-bold {{ $order->status === 'shipped' ? 'text-luxury-gold' : 'text-luxury-charcoal/60' }} text-xs uppercase tracking-widest">With Courier</div>
                                    <div class="text-[9px] text-luxury-charcoal/40">{{ now()->subHours(8)->format('d M Y, H:i') }}</div>
                                </div>
                                <div class="text-luxury-charcoal/70 text-xs mt-2">Pesanan dibawa kurir (KIRIMAN DIBAWA OLEH KURIR MENUJU ALAMAT TUJUAN)</div>
                            </div>
                        </div>

                        {{-- Hub Facility --}}
                        <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group">
                            <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white bg-luxury-charcoal/20 text-luxury-charcoal shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                            </div>
                            <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded bg-white border border-luxury-charcoal/10 shadow-sm relative">
                                <div class="flex items-center justify-between space-x-2 mb-1">
                                    <div class="font-bold text-luxury-charcoal/60 text-xs uppercase tracking-widest">At Hub Facility</div>
                                    <div class="text-[9px] text-luxury-charcoal/40">{{ now()->subDays(1)->format('d M Y, H:i') }}</div>
                                </div>
                                <div class="text-luxury-charcoal/60 text-xs mt-2">Pesanan telah tiba di Hub pengiriman kota tujuan (JAKARTA)</div>
                            </div>
                        </div>
                        
                        {{-- Picked Up --}}
                        <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group">
                            <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white bg-luxury-charcoal/20 text-luxury-charcoal shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                            </div>
                            <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded bg-white border border-luxury-charcoal/10 shadow-sm relative">
                                <div class="flex items-center justify-between space-x-2 mb-1">
                                    <div class="font-bold text-luxury-charcoal/60 text-xs uppercase tracking-widest">Manifested</div>
                                    <div class="text-[9px] text-luxury-charcoal/40">{{ $order->created_at->addHours(4)->format('d M Y, H:i') }}</div>
                                </div>
                                <div class="text-luxury-charcoal/60 text-xs mt-2">Pesanan diserahkan ke pihak logistik (SHIPMENT RECEIVED BY JNE COUNTER OFFICER)</div>
                            </div>
                        </div>

                    </div>
                </div>
                @endif
            </div>

            {{-- Right Column: Summary --}}
            <div class="lg:col-span-1">
                <div class="bg-luxury-charcoal text-white p-8 sticky top-32">
                    <h2 class="text-xl font-serif italic mb-8 border-b border-white/10 pb-4">Summary</h2>

                    <div class="space-y-5 text-sm">
                        <div>
                            <p class="text-[9px] uppercase tracking-[0.2em] text-white/40 mb-1">Order Number</p>
                            <p class="font-mono font-bold">{{ $order->order_number }}</p>
                        </div>
                        <div>
                            <p class="text-[9px] uppercase tracking-[0.2em] text-white/40 mb-1">Date Placed</p>
                            <p class="font-serif">{{ $order->created_at->format('d F Y, H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-[9px] uppercase tracking-[0.2em] text-white/40 mb-1">Status</p>
                            <span class="inline-block px-3 py-1 text-[9px] uppercase tracking-[0.2em] font-bold rounded-full mt-1
                                {{ $order->status === 'paid' ? 'bg-emerald-500/20 text-emerald-400' :
                                   ($order->status === 'processing' ? 'bg-blue-500/20 text-blue-400' :
                                   ($order->status === 'shipped' ? 'bg-purple-500/20 text-purple-400' :
                                   ($order->status === 'completed' ? 'bg-luxury-gold/20 text-luxury-gold' :
                                   'bg-yellow-500/20 text-yellow-400'))) }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-[9px] uppercase tracking-[0.2em] text-white/40 mb-1">Payment Method</p>
                            <p class="font-serif capitalize">{{ str_replace('_', ' ', $order->payment_method) }}</p>
                        </div>

                        <div class="border-t border-white/10 pt-5 mt-5">
                            <p class="text-[9px] uppercase tracking-[0.2em] text-white/40 mb-1">Total Amount</p>
                            <p class="font-mono text-xl font-bold text-luxury-gold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    {{-- Shipping Info --}}
                    <div class="border-t border-white/10 mt-8 pt-6">
                        <h3 class="text-[9px] uppercase tracking-[0.3em] text-white/40 mb-4 font-bold">Shipping Address</h3>
                        <div class="text-sm text-white/80 space-y-1.5">
                            <p class="font-semibold text-white">{{ $order->recipient_name }}</p>
                            <p>{{ $order->phone }}</p>
                            <p>{{ $order->shipping_address }}</p>
                            <p>{{ $order->city }} {{ $order->postal_code }}</p>
                        </div>
                    </div>

                    {{-- Payment Info --}}
                    @if($order->payment)
                    <div class="border-t border-white/10 mt-8 pt-6">
                        <h3 class="text-[9px] uppercase tracking-[0.3em] text-white/40 mb-4 font-bold">Payment Details</h3>
                        <div class="text-sm text-white/70 space-y-2">
                            <div class="flex justify-between">
                                <span>Transaction ID</span>
                                <span class="font-mono text-white/90 text-xs">{{ $order->payment->transaction_id ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Payment Type</span>
                                <span class="capitalize text-white/90">{{ str_replace('_', ' ', $order->payment->payment_type ?? '-') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Payment Status</span>
                                <span class="font-bold {{ $order->payment->payment_status === 'success' ? 'text-emerald-400' : 'text-yellow-400' }}">
                                    {{ ucfirst($order->payment->payment_status ?? '-') }}
                                </span>
                            </div>
                            @if($order->payment->paid_at)
                            <div class="flex justify-between">
                                <span>Paid At</span>
                                <span class="text-white/90">{{ $order->payment->paid_at->format('d M Y H:i') }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <div class="mt-8">
                        <a href="{{ route('products.index') }}" class="block w-full text-center py-3 bg-luxury-gold text-[10px] uppercase tracking-[0.3em] font-bold text-white hover:bg-white hover:text-luxury-charcoal transition-colors duration-500">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
