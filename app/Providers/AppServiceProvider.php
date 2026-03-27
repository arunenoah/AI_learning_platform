<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configurePasswordPolicy();
        $this->configureRateLimiting();
    }

    /**
     * Configure application-wide password validation defaults.
     * Applied everywhere Password::defaults() is used (register, reset, update).
     */
    private function configurePasswordPolicy(): void
    {
        Password::defaults(fn () => Password::min(8)
            ->mixedCase()
            ->numbers()
            ->symbols()
            ->uncompromised()
        );
    }

    /**
     * Configure rate limiters for authentication endpoints.
     */
    private function configureRateLimiting(): void
    {
        // Login: 5 failed attempts per IP per minute
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by('login|' . $request->ip());
        });

        // Signup: 15 attempts per IP per hour
        RateLimiter::for('signup', function (Request $request) {
            return Limit::perHour(15)->by('signup|' . $request->ip());
        });

        // Forgot password: 5 attempts per IP per hour
        RateLimiter::for('forgot-password', function (Request $request) {
            return Limit::perHour(5)->by('forgot-password|' . $request->ip());
        });
    }
}
