<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $guard = null): Response
    {
        if (Auth::guard($guard)->check()) {

            $redirect = session('redirect_after_auth');

            if ($redirect === 'checkout') {
                session()->forget('redirect_after_auth');
                return redirect()->route('checkout');
            }

            if (session()->has('url.intended')) {
                return redirect()->intended();
            }

            return $guard == 'admin' ? redirect('admin/dashboard') : redirect('/profile');
        }

        return $next($request);
    }
}
