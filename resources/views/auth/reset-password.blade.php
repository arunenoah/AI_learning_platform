<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-900">Set new password</h2>
        <p class="text-slate-500 mt-2">Choose a strong password for your account</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <x-input-label for="email" :value="__('Email address')" />
            <x-text-input id="email" type="email" name="email" :value="old('email', $request->email)"
                required autofocus autocomplete="username"
                class="block mt-1.5 w-full" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('New password')" />
            <x-text-input id="password" type="password" name="password"
                required autocomplete="new-password"
                placeholder="Create a strong password"
                class="block mt-1.5 w-full" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm new password')" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation"
                required autocomplete="new-password"
                placeholder="Repeat your password"
                class="block mt-1.5 w-full" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <x-primary-button class="w-full justify-center">
            {{ __('Reset password') }}
        </x-primary-button>
    </form>
</x-guest-layout>
