@props(['messages'])

@if ($messages)
    <ul role="alert" aria-live="polite" {{ $attributes->merge(['class' => 'text-sm text-danger-500 space-y-1']) }}>
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif
