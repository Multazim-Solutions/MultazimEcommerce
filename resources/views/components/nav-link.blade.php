@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center border-b-2 border-brand-400 pb-1 text-sm font-medium text-ink-900 transition'
            : 'inline-flex items-center border-b-2 border-transparent pb-1 text-sm font-medium text-muted transition hover:text-ink-900 hover:border-sand-300';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
