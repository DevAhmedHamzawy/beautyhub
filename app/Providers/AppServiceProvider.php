<?php

namespace App\Providers;

use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Auth;
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
        RedirectIfAuthenticated::redirectUsing(function ($request) {
            // استرجاع جميع الحراس الممررين (guards)
            $guards = $request->guards ?? [null];

            foreach ($guards as $guard) {
                if (Auth::guard($guard)->check()) {
                    return $guard === 'admin'
                        ? redirect('admin/dashboard')
                        : redirect(route('dashboard'));
                }
            }

            return null;
        });
    }
}
