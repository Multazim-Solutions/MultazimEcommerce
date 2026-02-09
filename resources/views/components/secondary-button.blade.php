<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center gap-2 rounded-xl border border-primary-200 bg-primary-50 px-4 py-2 text-sm font-semibold text-primary-800 shadow-sm transition hover:bg-primary-100 ui-ring disabled:pointer-events-none disabled:opacity-60']) }}>
    {{ $slot }}
</button>
