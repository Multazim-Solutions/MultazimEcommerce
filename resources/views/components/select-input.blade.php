@props(['disabled' => false])

<select @disabled($disabled) {{ $attributes->merge(['class' => 'rounded-xl border border-sand-200 bg-white px-3 py-2 text-sm text-ink-900 shadow-sm focus:border-accent-500 focus:ring-accent-500 ui-ring disabled:bg-sand-100 disabled:text-muted']) }}>
    {{ $slot }}
</select>
