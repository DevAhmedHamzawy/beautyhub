<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\AdminForgotPasswordController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CompareController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SubCategoryController as ControllersSubCategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\WishlistController;
use App\Models\About;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::post('/products/{product}/price', [ProductController::class, 'getPrice'])->name('products.getPrice');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout');
Route::get('search', [SearchController::class, 'index'])->name('search');
Route::get('/search/filter', [SearchController::class, 'getFilters'])->name('search.filter');
Route::get('wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::post('wishlist/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
Route::get('compare', [CompareController::class, 'index'])->name('compare.index');
Route::post('compare/toggle/{product}', [CompareController::class, 'toggle'])->name('compare.toggle');
Route::get('/product/details/{product}', [ProductController::class, 'getDetails'])->name('products.getDetails');
Route::post('/cart/update', [CartController::class, 'update']);
Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('applyCoupon');
Route::get('/faqs', [FaqController::class, 'index'])->name('faqs');
Route::post('/contact/save', [ContactController::class, 'save'])->name('contact.save');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/pages/{page}', [PageController::class, 'show'])->name('pages.show');

Route::middleware('auth')->group(function () {

    Route::post('/save_order', [OrderController::class, 'save'])->name('save_order');
    Route::get('/profile', [UserController::class, 'show'])->name('profile');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');

    Route::post('/products/{product}/rate', [RatingController::class, 'store'])->name('products.rate');

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
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');


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
