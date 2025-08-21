<?php

use App\Http\Controllers\Admin\AdminForgotPasswordController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\SubCategoryController as ControllersSubCategoryController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// DON'T Put it inside the '/admin' Prefix , Otherwise you'll never get the page due to assign.guard that will redirect you too many times
Route::get('admin/login', [AdminLoginController::class, 'showLoginForm']);
Route::post('admin/login', [AdminLoginController::class, 'login'])->name('admin.login');
Route::post('admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

// Forget Password
Route::prefix('admin')->group(function () {
    Route::get('forget-password', [AdminForgotPasswordController::class, 'showForgetPasswordForm'])->name('admin.forget-password');
    Route::post('forget-password', [AdminForgotPasswordController::class, 'sendResetLink'])->name('admin.send-reset-link');
    Route::get('reset-password/{token}', [AdminForgotPasswordController::class, 'showResetPasswordForm'])->name('admin.reset-password');
    Route::post('reset-password', [AdminForgotPasswordController::class, 'resetPassword'])->name('admin.reset-password.submit');
});


// Change Language
Route::get('lang/{lang}', [LocalizationController::class, 'index'])->name('language');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('areas', [AreaController::class, 'index'])->name('get_areas');

Route::get('list_subcategories/{id}', [ControllersSubCategoryController::class, 'list'])->name('list_subcategories');

Route::get('/storage_link', function () {
    Artisan::call('storage:link');
});

Route::get('/optimize-clear', function () {
    Artisan::call('optimize:clear');
    return 'Optimization cache cleared!';
});
