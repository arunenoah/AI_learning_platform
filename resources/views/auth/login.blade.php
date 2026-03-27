<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-900">Welcome back</h2>
        <p class="text-slate-500 mt-2">Sign in to continue your learning journey</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email address')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')"
                required autofocus autocomplete="username"
                placeholder="you@example.com"
                class="block mt-1.5 w-full" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <div class="flex items-center justify-between">
                <x-input-label for="password" :value="__('Password')" />
                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-primary-600 hover:text-primary-700 transition-colors" href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>
            <x-text-input id="password" type="password" name="password"
                required autocomplete="current-password"
                placeholder="Enter your password"
                class="block mt-1.5 w-full" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center">
            <input id="remember_me" type="checkbox"
                   class="w-4 h-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500 transition"
                   name="remember">
            <label for="remember_me" class="ml-2.5 text-sm text-slate-600">{{ __('Remember me') }}</label>
        </div>

        <x-primary-button class="w-full justify-center">
            {{ __('Sign in') }}
        </x-primary-button>
    </form>

    <p class="mt-8 text-center text-sm text-slate-500">
        {{ __("Don't have an account?") }}
        <a href="{{ route('register') }}" class="font-semibold text-primary-600 hover:text-primary-700 transition-colors">
            {{ __('Create one for free') }}
        </a>
    </p>
</x-guest-layout>
