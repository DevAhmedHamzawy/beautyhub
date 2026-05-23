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
            return Product::join('new_arrivals', 'new_arrivals.product_id', '=', 'products.id')
            ->whereRelation('stocks', 'qty', '>', 0)
            ->select('products.*')
            ->latest('products.created_at')
            ->take(8)
            ->get();
        });

        $flash_sale = FlashSaleHelper::getActiveFlashSale();

        $top_selling = Cache::remember('top_selling', now()->addMinutes(30), function () {
            return Product::select(
                        'products.*',
                        DB::raw('SUM(order_items.qty) as total_sold')
                    )
                    ->join('top_sellings', 'top_sellings.product_id', '=', 'products.id')
                    ->join('stocks', 'stocks.product_id', '=', 'products.id')
                    ->leftJoin('order_items', 'order_items.stock_id', '=', 'stocks.id')
                    ->groupBy('products.id')
                    ->orderByDesc('total_sold')
                    ->limit(10)
                    ->get();
        });

        $weekly_top_selling = Cache::remember('weekly_top_selling', now()->addMinutes(30), function () {

            return Product::select(
                        'products.*',
                        DB::raw('COALESCE(SUM(order_items.qty), 0) as total_sold')
                    )
                    ->join('best_sell_weeks', 'best_sell_weeks.product_id', '=', 'products.id')
                    ->join('stocks', 'stocks.product_id', '=', 'products.id')
                    ->leftJoin('order_items', function ($join) {
                        $join->on('order_items.stock_id', '=', 'stocks.id')
                            ->where('order_items.created_at', '>=', now()->subDays(7));
                    })
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
         $new_arrivals = Cache::remember('new_arrivals', now()->addMinutes(30), function () {
            return Product::join('new_arrivals', 'new_arrivals.product_id', '=', 'products.id')
            ->whereRelation('stocks', 'qty', '>', 0)
            ->select('products.*')
            ->latest('products.created_at')
            ->take(8)
            ->get();
        });
        return view('site.welcome.new_arrivals', compact('new_arrivals'));
    }

   public function top_selling()
    {
        $top_selling = Cache::remember('top_selling', now()->addMinutes(30), function () {
            return Product::select(
                        'products.*',
                        DB::raw('SUM(order_items.qty) as total_sold')
                    )
                    ->join('top_sellings', 'top_sellings.product_id', '=', 'products.id')
                    ->join('stocks', 'stocks.product_id', '=', 'products.id')
                    ->leftJoin('order_items', 'order_items.stock_id', '=', 'stocks.id')
                    ->groupBy('products.id')
                    ->orderByDesc('total_sold')
                    ->paginate(10);
        });
        return view('site.welcome.top_selling', compact('top_selling'));
    }

    public function weekly_top_selling()
    {
        $weekly_top_selling = Cache::remember('weekly_top_selling', now()->addMinutes(30), function () {

            return Product::select(
                        'products.*',
                        DB::raw('COALESCE(SUM(order_items.qty), 0) as total_sold')
                    )
                    ->join('best_sell_weeks', 'best_sell_weeks.product_id', '=', 'products.id')
                    ->join('stocks', 'stocks.product_id', '=', 'products.id')
                    ->leftJoin('order_items', function ($join) {
                        $join->on('order_items.stock_id', '=', 'stocks.id')
                            ->where('order_items.created_at', '>=', now()->subDays(7));
                    })
                    ->groupBy('products.id')
                    ->orderByDesc('total_sold')
                    ->paginate(10);
        });

        return view('site.welcome.weekly_top_selling', compact('weekly_top_selling'));
    }
}
