<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-900">Create your account</h2>
        <p class="text-slate-500 mt-2">Start your learning journey today — it's free</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Full name')" />
            <x-text-input id="name" type="text" name="name" :value="old('name')"
                required autofocus autocomplete="name"
                placeholder="John Doe"
                class="block mt-1.5 w-full" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email address')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')"
                required autocomplete="username"
                placeholder="you@example.com"
                class="block mt-1.5 w-full" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" type="password" name="password"
                required autocomplete="new-password"
                placeholder="Create a strong password"
                class="block mt-1.5 w-full" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm password')" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation"
                required autocomplete="new-password"
                placeholder="Repeat your password"
                class="block mt-1.5 w-full" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <x-primary-button class="w-full justify-center">
            {{ __('Create account') }}
        </x-primary-button>
    </form>

    <p class="mt-8 text-center text-sm text-slate-500">
        {{ __('Already have an account?') }}
        <a href="{{ route('login') }}" class="font-semibold text-primary-600 hover:text-primary-700 transition-colors">
            {{ __('Sign in') }}
        </a>
    </p>
</x-guest-layout>
