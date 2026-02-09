<x-guest-layout>
    @php
        $adminIntent = request()->boolean('admin') || str_contains((string) session('url.intended', ''), '/admin');
    @endphp

    @if ($adminIntent)
        <x-ui.alert class="mb-4" variant="info" title="Admin sign-in">
            Sign in with an admin account to access the operations console.
        </x-ui.alert>
    @endif

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-sand-200 text-accent-600 shadow-sm focus:ring-accent-500" name="remember">
                <span class="ms-2 text-sm text-muted">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="text-sm text-muted hover:text-ink-900 ui-ring" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <div class="mt-6">
        <a href="{{ route('google.redirect') }}" class="w-full inline-flex items-center justify-center rounded-xl border border-sand-200 bg-white px-4 py-2 text-sm font-medium text-ink-700 shadow-sm transition hover:bg-sand-100 ui-ring">
            {{ __('Continue with Google') }}
        </a>
    </div>
</x-guest-layout>
