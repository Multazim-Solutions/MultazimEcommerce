@props(['status'])

@if ($status)
    <x-ui.alert variant="success" title="Success" {{ $attributes }}>
        {{ $status }}
    </x-ui.alert>
@endif
