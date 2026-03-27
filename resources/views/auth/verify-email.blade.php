<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-900">Verify your email</h2>
        <p class="text-slate-500 mt-2">{{ __('Thanks for signing up! Please verify your email address by clicking the link we just sent you.') }}</p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 font-medium text-sm text-green-600 bg-green-50 border border-green-200 rounded-lg px-4 py-3">
            {{ __('A new verification link has been sent to your email address.') }}
        </div>
    @endif

    <div class="flex items-center justify-between gap-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button>
                {{ __('Resend verification email') }}
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors">
                {{ __('Log out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
