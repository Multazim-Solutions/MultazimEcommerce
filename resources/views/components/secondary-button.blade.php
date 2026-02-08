<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center gap-2 rounded-xl border border-sand-200 bg-white px-4 py-2 text-sm font-semibold text-ink-700 shadow-sm transition hover:bg-sand-100 ui-ring disabled:pointer-events-none disabled:opacity-60']) }}>
    {{ $slot }}
</button>
