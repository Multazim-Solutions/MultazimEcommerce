@props(['label' => 'Loading'])

<div data-ui="loading" {{ $attributes->merge(['class' => 'flex items-center gap-3 text-sm text-muted']) }}>
    <span class="relative flex h-2.5 w-2.5">
        <span class="absolute inline-flex h-full w-full animate-pulse rounded-full bg-accent-300 opacity-40"></span>
        <span class="relative inline-flex h-2.5 w-2.5 rounded-full bg-accent-600"></span>
    </span>
    <span>{{ $label }}</span>
</div>
