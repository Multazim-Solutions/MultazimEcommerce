@props(['variant' => 'info', 'title' => null])

@php
    $variants = [
        'info' => 'border-accent-200 bg-accent-50 text-ink-900',
        'success' => 'border-success-100 bg-success-100 text-success-700',
        'warning' => 'border-warning-100 bg-warning-100 text-warning-700',
        'danger' => 'border-danger-100 bg-danger-100 text-danger-700',
    ];

    $classes = $variants[$variant] ?? $variants['info'];
    $bodyClass = $variant === 'info' ? 'text-ink-700' : 'text-current';
    $titleClass = $variant === 'info' ? 'text-ink-900' : 'text-current';
@endphp

<div data-ui="alert" data-variant="{{ $variant }}" role="status" aria-live="polite" {{ $attributes->merge(['class' => "rounded-xl border px-4 py-3 text-sm {$classes}"]) }}>
    @if ($title)
        <p class="font-semibold {{ $titleClass }}">{{ $title }}</p>
    @endif
    <div class="text-sm {{ $bodyClass }}">
        {{ $slot }}
    </div>
</div>
