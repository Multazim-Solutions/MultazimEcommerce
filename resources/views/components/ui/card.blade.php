@props(['title' => null, 'description' => null, 'actions' => null])

<div data-ui="card" {{ $attributes->merge(['class' => 'rounded-2xl border border-sand-200 bg-white/90 shadow-elev-1']) }}>
    @if ($title || $description)
        <div class="border-b border-sand-200 px-5 py-4">
            @if ($title)
                <h3 class="font-display text-lg text-ink-900">{{ $title }}</h3>
            @endif
            @if ($description)
                <p class="mt-1 text-sm text-muted">{{ $description }}</p>
            @endif
        </div>
    @endif

    <div class="{{ $title || $description ? 'px-5 py-4' : 'p-5' }}">
        {{ $slot }}
    </div>

    @if ($actions)
        <div class="border-t border-sand-200 px-5 py-4">
            {{ $actions }}
        </div>
    @endif
</div>
