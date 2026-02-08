@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full border-l-4 border-brand-400 bg-sand-100 px-4 py-2 text-start text-base font-medium text-ink-900 transition'
            : 'block w-full border-l-4 border-transparent px-4 py-2 text-start text-base font-medium text-muted transition hover:border-sand-300 hover:bg-sand-100 hover:text-ink-900';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
