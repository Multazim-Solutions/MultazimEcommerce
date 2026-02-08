@props(['alt' => 'Multazim'])

<img
    src="{{ asset('brand/multazim_logo.png') }}"
    alt="{{ $alt }}"
    {{ $attributes->merge(['class' => 'h-10 w-auto']) }}
/>
