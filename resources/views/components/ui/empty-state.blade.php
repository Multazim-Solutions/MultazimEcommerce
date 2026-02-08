@props(['title' => 'Nothing here yet', 'description' => null, 'action' => null])

<div data-ui="empty" {{ $attributes->merge(['class' => 'rounded-2xl border border-dashed border-sand-300 bg-sand-100/60 px-6 py-8 text-center']) }}>
    <p class="font-display text-lg text-ink-900">{{ $title }}</p>
    @if ($description)
        <p class="mt-2 text-sm text-muted">{{ $description }}</p>
    @endif
    @if ($action)
        <div class="mt-4 flex justify-center">
            {{ $action }}
        </div>
    @endif
</div>
