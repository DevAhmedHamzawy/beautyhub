<?php

use App\Http\Middleware\AssignGuard;
use App\Http\Middleware\Localization;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::prefix('admin')->as('admin.')->middleware(['web', 'assign.guard:admin,admin/login'])->group(__DIR__.'/../routes/admin.php');
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
           'guest' => RedirectIfAuthenticated::class,
           'assign.guard' => AssignGuard::class,
           'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
        ]);

        $middleware->web(
            append: [
                Localization::class
            ]
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
