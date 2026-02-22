<?php

namespace App\Providers;

use App\Listeners\SyncSessionCartWithDatabase;
use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use App\Models\Stock;
use Closure;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;
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
            $view->with('settings', \App\Models\Settings::first());
            $view->with('categories', Category::whereActive(1)->whereNull('parent_id')->get());
            $view->with('pages', Page::all());

            if (auth('web')->check()) {

                $cart = auth()->guard('web')->user()
                    ->cart()
                    ->with('product', 'stock') // كفاية بس
                    ->get()
                    ->map(function ($item) {
                        $product = $item->product;

                        return (object) [
                            'quantity'   => $item->quantity,
                            'product'    => $product,
                            'stock'    => $item->stock ?? null,
                            'tax_amount' => $product ? $product->tax_amount : 0,
                            'unit_price' => $product ? $product->price_with_tax : 0,
                        ];
                    });

            } else {

                $cartSession = collect(session()->get('cart', []));

                $products = Product::with('tax')->whereIn(
                    'id',
                    $cartSession->pluck('product_id')
                )->get()->keyBy('id');

                $stocks = Stock::whereIn(
                    'id',
                    $cartSession->pluck('stock_id')
                )->get()->keyBy('id');

                $cart = $cartSession->map(function ($item) use ($products, $stocks) {

                    return (object) [
                        'quantity' => $item['quantity'],
                        'product'  => $products[$item['product_id']] ?? null,
                        'stock'    => $stocks[$item['stock_id']] ?? null,
                        'tax_amount' => $products[$item['product_id']]->tax_amount,
                        'unit_price' => $products[$item['product_id']]->price_with_tax,
                    ];
                });
            }

            $view->with('cart', $cart);

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
