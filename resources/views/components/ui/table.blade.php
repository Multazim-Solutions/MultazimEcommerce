@props([])

<div data-ui="table" class="overflow-x-auto rounded-2xl border border-sand-200 bg-white/90 shadow-elev-1">
    <table {{ $attributes->merge(['class' => 'min-w-full text-left text-sm']) }}>
        {{ $slot }}
    </table>
</div>
