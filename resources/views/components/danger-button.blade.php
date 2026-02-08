<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center gap-2 rounded-xl bg-danger-500 px-4 py-2 text-sm font-semibold text-white shadow-elev-1 transition hover:bg-danger-700 ui-ring disabled:pointer-events-none disabled:opacity-60']) }}>
    {{ $slot }}
</button>
