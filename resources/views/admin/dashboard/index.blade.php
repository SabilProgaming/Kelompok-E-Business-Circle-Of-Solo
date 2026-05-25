@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
	@php
		$salesData = collect($sales_chart ?? []);
		$statusData = collect($order_status_summary ?? []);

		$lineLabels = $salesData
			->map(fn ($item) => \Carbon\Carbon::parse($item->date)->format('d M'))
			->values();

		$lineRevenue = $salesData
			->map(fn ($item) => (float) $item->total_revenue)
			->values();

		$barLabels = $statusData->keys()->map(fn ($key) => ucfirst($key))->values();
		$barValues = $statusData->values();

		$growthPercent = (float) ($revenue_growth_percent ?? 0);
		$growthLabel = ($growthPercent >= 0 ? '+' : '').number_format($growthPercent, 1).'% from last month';
	@endphp

	<div class="space-y-6">
		<div>
			<h2 class="text-sm font-bold uppercase tracking-widest text-luxury-charcoal">Dashboard Overview</h2>
			<p class="text-luxury-charcoal/60 mt-1 text-xs">Welcome back, here's what's happening with your store today.</p>
		</div>

		<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
			<x-admin.ui.card class="p-6 group">
				<div class="absolute top-0 right-0 p-4 opacity-15 group-hover:scale-110 transition-transform duration-500"><i data-lucide="banknote" class="w-16 h-16 text-luxury-charcoal"></i></div>
				<p class="text-[10px] uppercase tracking-widest text-luxury-charcoal/50 font-bold mb-1 relative z-10">Total Revenue</p>
				<p class="text-3xl font-serif text-luxury-charcoal relative z-10">Rp {{ number_format((float) ($total_revenue ?? 0), 0, ',', '.') }}</p>
				<p class="text-[10px] {{ $growthPercent >= 0 ? 'text-emerald-600' : 'text-red-600' }} font-bold mt-3 relative z-10 flex items-center gap-1">
                    <i data-lucide="{{ $growthPercent >= 0 ? 'trending-up' : 'trending-down' }}" class="w-3 h-3"></i>
                    {{ $growthLabel }}
                </p>
			</x-admin.ui.card>

			<x-admin.ui.card class="p-6 group">
				<div class="absolute top-0 right-0 p-4 opacity-15 group-hover:scale-110 transition-transform duration-500"><i data-lucide="shopping-bag" class="w-16 h-16 text-luxury-charcoal"></i></div>
				<p class="text-[10px] uppercase tracking-widest text-luxury-charcoal/50 font-bold mb-1 relative z-10">Total Orders</p>
				<p class="text-3xl font-serif text-luxury-charcoal relative z-10">{{ number_format((int) ($total_orders ?? 0)) }}</p>
				<p class="text-[10px] text-luxury-gold font-bold mt-3 relative z-10 flex items-center gap-1">
                    <i data-lucide="clock" class="w-3 h-3"></i>
                    {{ (int) ($pending_orders ?? 0) }} orders pending
                </p>
			</x-admin.ui.card>

			<x-admin.ui.card class="p-6 group">
				<div class="absolute top-0 right-0 p-4 opacity-15 group-hover:scale-110 transition-transform duration-500"><i data-lucide="users" class="w-16 h-16 text-luxury-charcoal"></i></div>
				<p class="text-[10px] uppercase tracking-widest text-luxury-charcoal/50 font-bold mb-1 relative z-10">Customers</p>
				<p class="text-3xl font-serif text-luxury-charcoal relative z-10">{{ number_format((int) ($total_customers ?? 0)) }}</p>
				<p class="text-[10px] text-luxury-gold font-bold mt-3 relative z-10 flex items-center gap-1">
                    <i data-lucide="star" class="w-3 h-3"></i>
                    Active Resellers
                </p>
			</x-admin.ui.card>

			<div class="bg-gradient-to-br from-luxury-charcoal to-luxury-charcoal/90 rounded-2xl p-6 shadow-2xl border border-luxury-gold/20 relative overflow-hidden group">
				<div class="absolute top-0 right-0 p-4 opacity-30 group-hover:scale-110 transition-transform duration-500"><i data-lucide="activity" class="w-16 h-16 text-luxury-gold"></i></div>
				<p class="text-[10px] uppercase tracking-widest text-white/50 font-bold mb-1 relative z-10">Avg. Order Value</p>
				<p class="text-3xl font-serif text-luxury-gold relative z-10 group-hover:scale-105 transition-transform duration-500 origin-left">Rp {{ number_format((float) ($average_order_value ?? 0), 0, ',', '.') }}</p>
				<p class="text-[10px] text-luxury-gold/60 font-bold mt-3 relative z-10 flex items-center gap-1">
                    <i data-lucide="sparkles" class="w-3 h-3"></i>
                    Consistent growth
                </p>
			</div>
		</div>

		<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
			<x-admin.ui.card class="p-6 col-span-1 lg:col-span-2">
				<h3 class="text-sm font-bold uppercase tracking-widest mb-6">Revenue Over Time</h3>
				<div class="h-[300px] w-full">
					@if($salesData->isEmpty())
						<div class="h-full flex items-center justify-center text-gray-500">No revenue data yet.</div>
					@else
						<canvas id="revenueOverTimeChart"></canvas>
					@endif
				</div>
			</x-admin.ui.card>

			<x-admin.ui.card class="p-6 col-span-1">
				<h3 class="text-sm font-bold uppercase tracking-widest mb-6">Orders by Status</h3>
				<div class="h-[300px] w-full">
					@if($statusData->isEmpty())
						<div class="h-full flex items-center justify-center text-gray-500">No order status data yet.</div>
					@else
						<canvas id="ordersByStatusChart"></canvas>
					@endif
				</div>
			</x-admin.ui.card>
		</div>
	</div>

	@if($salesData->isNotEmpty() || $statusData->isNotEmpty())
		<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
		<script>
			(() => {
				if (typeof Chart === 'undefined') {
					return;
				}

				const revenueCanvas = document.getElementById('revenueOverTimeChart');
				const statusCanvas = document.getElementById('ordersByStatusChart');
				const rootStyles = getComputedStyle(document.documentElement);
				const secondaryColor = rootStyles.getPropertyValue('--color-secondary').trim() || '#D4AF37';
				const primaryColor = rootStyles.getPropertyValue('--color-primary').trim() || '#0F0F0F';

				if (revenueCanvas) {
					const revenueLabels = @json($lineLabels);
					const revenueValues = @json($lineRevenue);

					new Chart(revenueCanvas, {
						type: 'line',
						data: {
							labels: revenueLabels,
							datasets: [{
								label: 'Revenue',
								data: revenueValues,
								borderColor: secondaryColor,
								backgroundColor(context) {
									const chart = context.chart;
									const area = chart.chartArea;
									if (!area) {
										return 'rgba(212, 175, 55, 0.25)';
									}

									const gradient = chart.ctx.createLinearGradient(0, area.top, 0, area.bottom);
									gradient.addColorStop(0.05, 'rgba(212, 175, 55, 0.3)');
									gradient.addColorStop(0.95, 'rgba(212, 175, 55, 0)');
									return gradient;
								},
								fill: true,
								tension: 0.35,
								pointRadius: 2,
								pointHoverRadius: 4,
								pointBackgroundColor: secondaryColor,
							}],
						},
						options: {
							maintainAspectRatio: false,
							plugins: {
								legend: { display: false },
								tooltip: {
									backgroundColor: '#fff',
									titleColor: '#0F0F0F',
									bodyColor: '#0F0F0F',
									borderColor: 'rgba(0,0,0,0.08)',
									borderWidth: 1,
									displayColors: false,
									callbacks: {
										label(context) {
											const value = Number(context.raw || 0);
											return `Revenue: Rp ${value.toLocaleString('id-ID')}`;
										},
									},
								},
							},
							scales: {
								x: {
									grid: { display: false },
									ticks: { color: '#888' },
								},
								y: {
									beginAtZero: true,
									grid: { color: '#eee' },
									ticks: {
										color: '#888',
										callback(value) {
											const numeric = Number(value);
											if (numeric >= 1000000) {
												return `Rp${(numeric / 1000000).toFixed(1)}M`;
											}
											return `Rp${numeric.toLocaleString('id-ID')}`;
										},
									},
								},
							},
						},
					});
				}

				if (statusCanvas) {
					const statusLabels = @json($barLabels);
					const statusValues = @json($barValues);

					new Chart(statusCanvas, {
						type: 'bar',
						data: {
							labels: statusLabels,
							datasets: [{
								label: 'Orders',
								data: statusValues,
								backgroundColor: primaryColor,
								borderRadius: 6,
								maxBarThickness: 36,
							}],
						},
						options: {
							maintainAspectRatio: false,
							plugins: {
								legend: { display: false },
								tooltip: {
									backgroundColor: '#fff',
									titleColor: '#0F0F0F',
									bodyColor: '#0F0F0F',
									borderColor: 'rgba(0,0,0,0.08)',
									borderWidth: 1,
									displayColors: false,
								},
							},
							scales: {
								x: {
									grid: { display: false },
									ticks: { color: '#888' },
								},
								y: {
									beginAtZero: true,
									grid: { color: '#eee' },
									ticks: { color: '#888', precision: 0 },
								},
							},
						},
					});
				}
			})();
		</script>
	@endif
@endsection
