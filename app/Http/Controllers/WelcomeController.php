<?php

namespace App\Http\Controllers;

use App\Helper\FlashSaleHelper;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::whereActive(1)->get();
        $categories = Category::whereActive(1)->whereAppearHome(1)->whereNull('parent_id')->get();
        $brands = Brand::whereActive(1)->get();

        $new_arrivals = Cache::remember('new_arrivals', now()->addMinutes(30), function () {
            return Product::whereRelation('stocks', 'qty', '>', 0)->orderBy('created_at', 'desc')->take(8)->get();
        });

        $flash_sale = FlashSaleHelper::getActiveFlashSale();

        $top_selling = Cache::remember('top_selling', now()->addMinutes(30), function () {
            return Product::select(
                        'products.*',
                        DB::raw('SUM(order_items.qty) as total_sold')
                    )
                    ->join('stocks', 'stocks.product_id', '=', 'products.id')
                    ->join('order_items', 'order_items.stock_id', '=', 'stocks.id')
                    ->groupBy('products.id')
                    ->orderByDesc('total_sold')
                    ->limit(10)
                    ->get();
        });

        $weekly_top_selling = Cache::remember('weekly_top_selling', now()->addMinutes(30), function () {
            return Product::select(
                        'products.*',
                        DB::raw('SUM(order_items.qty) as total_sold')
                    )
                    ->join('stocks', 'stocks.product_id', '=', 'products.id')
                    ->join('order_items', 'order_items.stock_id', '=', 'stocks.id')
                    ->where('order_items.created_at', '>=', now()->subDays(7))
                    ->groupBy('products.id')
                    ->orderByDesc('total_sold')
                    ->limit(10)
                    ->get();
        });

        return view('site.welcome.welcome', compact('sliders', 'categories', 'brands', 'new_arrivals', 'flash_sale', 'top_selling', 'weekly_top_selling'));
    }

    public function categories()
    {
        $categories = Category::whereActive(1)->whereNull('parent_id')->get();
        return view('site.welcome.categories', compact('categories'));
    }

    public function brands()
    {
        $brands = Brand::whereActive(1)->get();
        return view('site.welcome.brands', compact('brands'));
    }

    public function new_arrivals()
    {
        $new_arrivals = Product::whereRelation('stocks', 'qty', '>', 0)->orderBy('created_at', 'desc')->paginate(12);
        return view('site.welcome.new_arrivals', compact('new_arrivals'));
    }

   public function top_selling()
    {
        $top_selling = Product::select(
                    'products.*',
                    DB::raw('SUM(order_items.qty) as total_sold')
                )
                ->join('stocks', 'stocks.product_id', '=', 'products.id')
                ->join('order_items', 'order_items.stock_id', '=', 'stocks.id')
                ->groupBy('products.id')
                ->orderByDesc('total_sold')
                ->paginate(10);
        return view('site.welcome.top_selling', compact('top_selling'));
    }

    public function weekly_top_selling()
    {
        $weekly_top_selling = Product::select(
                    'products.*',
                    DB::raw('SUM(order_items.qty) as total_sold')
                )
                ->join('stocks', 'stocks.product_id', '=', 'products.id')
                ->join('order_items', 'order_items.stock_id', '=', 'stocks.id')
                ->where('order_items.created_at', '>=', now()->subDays(7))
                ->groupBy('products.id')
                ->orderByDesc('total_sold')
                ->paginate(10);
        return view('site.welcome.weekly_top_selling', compact('weekly_top_selling'));
    }
}
