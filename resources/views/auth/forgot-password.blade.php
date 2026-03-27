<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-900">Reset password</h2>
        <p class="text-slate-500 mt-2">{{ __('Enter your email address and we\'ll send you a link to reset your password.') }}</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email address')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')"
                required autofocus
                placeholder="you@example.com"
                class="block mt-1.5 w-full" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <x-primary-button class="w-full justify-center">
            {{ __('Send reset link') }}
        </x-primary-button>
    </form>

    <p class="mt-8 text-center text-sm text-slate-500">
        <a href="{{ route('login') }}" class="font-semibold text-primary-600 hover:text-primary-700 transition-colors">
            {{ __('Back to sign in') }}
        </a>
    </p>
</x-guest-layout>
