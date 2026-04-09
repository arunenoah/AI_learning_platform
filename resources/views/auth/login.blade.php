<x-guest-layout>
    <div style="margin-bottom: 28px;">
        <h2 style="font-family: 'Playfair Display', serif; font-size: 26px; font-weight: 700; color: #1c1917; margin-bottom: 6px;">Welcome back</h2>
        <p style="font-size: 14px; color: #64748b;">Sign in to continue your learning journey</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" style="display: flex; flex-direction: column; gap: 18px;">
        @csrf

        <div>
            <label for="email" class="input-label">Email address</label>
            <x-text-input id="email" type="email" name="email" :value="old('email')"
                required autofocus autocomplete="username"
                placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px;">
                <label for="password" class="input-label" style="margin-bottom: 0;">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="font-size: 12.5px; font-weight: 500; color: #ea580c; text-decoration: none;">
                        Forgot password?
                    </a>
                @endif
            </div>
            <x-text-input id="password" type="password" name="password"
                required autocomplete="current-password"
                placeholder="Enter your password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div style="display: flex; align-items: center; gap: 8px;">
            <input id="remember_me" type="checkbox" name="remember"
                   style="width: 15px; height: 15px; accent-color: #ea580c; cursor: pointer;">
            <label for="remember_me" style="font-size: 13px; color: #475569; cursor: pointer;">Remember me</label>
        </div>

        <x-primary-button style="margin-top: 4px;">
            Sign in →
        </x-primary-button>
    </form>

    <p style="margin-top: 24px; text-align: center; font-size: 13.5px; color: #64748b;">
        Don't have an account?
        <a href="{{ route('register') }}" style="font-weight: 600; color: #ea580c; text-decoration: none; margin-left: 4px;">
            Create one for free
        </a>
    </p>
</x-guest-layout>
