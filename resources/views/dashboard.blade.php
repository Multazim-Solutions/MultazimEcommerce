<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display text-2xl text-ink-900">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-6">
            <x-ui.card>
                <div class="text-sm text-muted">Account</div>
                <div class="mt-2 font-display text-lg text-ink-900">{{ __("You're logged in!") }}</div>
            </x-ui.card>
        </div>
    </div>
</x-app-layout>
