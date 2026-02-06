@props(['title' => null])

<x-app-layout>
    @if ($title)
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $title }}</h2>
        </x-slot>
    @endif

    <div class="py-8">
        <div class="max-w-6xl mx-auto px-6">
            @if (session('status'))
                <div class="mb-4 rounded-md bg-green-50 p-3 text-sm text-green-700">
                    {{ session('status') }}
                </div>
            @endif

            {{ $slot }}
        </div>
    </div>
</x-app-layout>
