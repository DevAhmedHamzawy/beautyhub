<?php

namespace App\Providers;

use App\Listeners\SyncSessionCartWithDatabase;
use Closure;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
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
        view()->composer('*', function ($view)
        {
            $view->with('locale', \Session::get('locale') );
            $view->with('compare', session()->get('compare', []));
            $view->with('wishlists', auth()->guard('web')->user()?->wishlist()->get());
            $view->with('cart', auth()->guard('web')->user()?->cart()->get() ?? session()->get('cart', []));
        });

        Event::listen(
    Login::class,
  SyncSessionCartWithDatabase::class,
        );

        Event::listen(
    Registered::class,
  SyncSessionCartWithDatabase::class,
        );
    }
}
