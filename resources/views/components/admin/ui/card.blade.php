@props(['class' => ''])

<div {{ $attributes->merge(['class' => 'bg-white/80 backdrop-blur-md rounded-2xl border border-white/40 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300 relative overflow-hidden '.$class]) }}>
    {{ $slot }}
</div>
