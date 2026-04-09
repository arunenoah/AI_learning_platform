<x-guest-layout>
    <div style="margin-bottom: 28px;">
        <h2 style="font-family: 'Playfair Display', serif; font-size: 26px; font-weight: 700; color: #1c1917; margin-bottom: 6px;">Create your account</h2>
        <p style="font-size: 14px; color: #64748b;">Start your learning journey today — it's free</p>
    </div>

    <form method="POST" action="{{ route('register') }}" style="display: flex; flex-direction: column; gap: 18px;">
        @csrf

        <div>
            <label for="name" class="input-label">Full name</label>
            <x-text-input id="name" type="text" name="name" :value="old('name')"
                required autofocus autocomplete="name"
                placeholder="John Doe" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <label for="email" class="input-label">Email address</label>
            <x-text-input id="email" type="email" name="email" :value="old('email')"
                required autocomplete="username"
                placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label for="password" class="input-label">Password</label>
            <x-text-input id="password" type="password" name="password"
                required autocomplete="new-password"
                placeholder="Create a strong password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <label for="password_confirmation" class="input-label">Confirm password</label>
            <x-text-input id="password_confirmation" type="password" name="password_confirmation"
                required autocomplete="new-password"
                placeholder="Repeat your password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <x-primary-button style="margin-top: 4px;">
            Create account →
        </x-primary-button>
    </form>

    <p style="margin-top: 24px; text-align: center; font-size: 13.5px; color: #64748b;">
        Already have an account?
        <a href="{{ route('login') }}" style="font-weight: 600; color: #ea580c; text-decoration: none; margin-left: 4px;">
            Sign in
        </a>
    </p>
</x-guest-layout>
