<x-guest-layout>
    <div class="max-w-3xl mx-auto px-6 py-8">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Checkout</h1>
            <a class="text-sm text-gray-600 hover:text-gray-900" href="{{ route('storefront.cart.index') }}">Back to cart</a>
        </div>

        @if (session('status'))
            <div class="mb-4 rounded-md bg-green-50 p-3 text-sm text-green-700">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->has('cart') || $errors->has('payment'))
            <div class="mb-4 rounded-md bg-red-50 p-3 text-sm text-red-700">
                @foreach (['cart', 'payment'] as $key)
                    @foreach ($errors->get($key) as $message)
                        <div>{{ $message }}</div>
                    @endforeach
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('storefront.checkout.store') }}" class="space-y-4">
            @csrf

            <div>
                <x-input-label for="full_name" :value="__('Full name')" />
                <x-text-input id="full_name" class="block mt-1 w-full" type="text" name="full_name" :value="old('full_name')" required />
                <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="phone" :value="__('Phone')" />
                <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required />
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="address_line1" :value="__('Address line 1')" />
                <x-text-input id="address_line1" class="block mt-1 w-full" type="text" name="address_line1" :value="old('address_line1')" required />
                <x-input-error :messages="$errors->get('address_line1')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="address_line2" :value="__('Address line 2')" />
                <x-text-input id="address_line2" class="block mt-1 w-full" type="text" name="address_line2" :value="old('address_line2')" />
                <x-input-error :messages="$errors->get('address_line2')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="city" :value="__('City')" />
                <x-text-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city')" required />
                <x-input-error :messages="$errors->get('city')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="postal_code" :value="__('Postal code')" />
                <x-text-input id="postal_code" class="block mt-1 w-full" type="text" name="postal_code" :value="old('postal_code')" required />
                <x-input-error :messages="$errors->get('postal_code')" class="mt-2" />
            </div>

            <div class="flex justify-end">
                <x-primary-button>Continue</x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
