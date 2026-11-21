<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

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
        // Point reset links at our own /reset-password page
        ResetPassword::createUrlUsing(function ($user, string $token) {
            $url = url('/reset-password?token=' . $token . '&email=' . urlencode($user->getEmailForPasswordReset()));

            // Local testing only: a clean copy of the link in laravel.log
            if (app()->environment('local')) {
                Log::info('Password reset link for ' . $user->email . ': ' . $url);
            }

            return $url;
        });
    }
}