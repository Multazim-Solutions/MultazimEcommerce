@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-sm font-medium text-ink-700']) }}>
    {{ $value ?? $slot }}
</label>
