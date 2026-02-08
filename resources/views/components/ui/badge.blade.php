@props(['variant' => 'neutral'])

@php
    $variants = [
        'neutral' => 'bg-sand-100 text-ink-700 ring-1 ring-sand-200',
        'brand' => 'bg-brand-100 text-brand-700 ring-1 ring-brand-200',
        'accent' => 'bg-accent-100 text-accent-700 ring-1 ring-accent-200',
        'success' => 'bg-success-100 text-success-700 ring-1 ring-success-100',
        'warning' => 'bg-warning-100 text-warning-700 ring-1 ring-warning-100',
        'danger' => 'bg-danger-100 text-danger-700 ring-1 ring-danger-100',
    ];

    $classes = $variants[$variant] ?? $variants['neutral'];
@endphp

<span data-ui="badge" data-variant="{{ $variant }}" {{ $attributes->merge(['class' => "inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold tracking-wide {$classes}"]) }}>
    {{ $slot }}
</span>
