<x-guest-layout>
    <div class="mb-4 text-sm text-muted">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <x-ui.alert class="mb-4" variant="success" title="Email sent">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </x-ui.alert>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="text-sm text-muted hover:text-ink-900 ui-ring">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
