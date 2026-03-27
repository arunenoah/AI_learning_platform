<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-900">Confirm password</h2>
        <p class="text-slate-500 mt-2">{{ __('This is a secure area. Please confirm your password before continuing.') }}</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" type="password" name="password"
                required autocomplete="current-password"
                placeholder="Enter your password"
                class="block mt-1.5 w-full" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <x-primary-button class="w-full justify-center">
            {{ __('Confirm') }}
        </x-primary-button>
    </form>
</x-guest-layout>
