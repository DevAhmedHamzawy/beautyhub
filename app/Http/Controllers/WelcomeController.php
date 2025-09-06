<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\FlashSale;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class WelcomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::whereActive(1)->get();
        $categories = Category::whereActive(1)->whereNull('parent_id')->get();
        $brands = Brand::whereActive(1)->get();

        $new_arrivals = Cache::remember('new_arrivals', now()->addMinutes(30), function () {
            return Product::orderBy('created_at', 'desc')->take(8)->get();
        });

        $flash_sale = Cache::remember('flash_sales', now()->addMinutes(30), function () {
            return FlashSale::where('start_time', '<=', now())->where('end_time', '>=', now())->with('products')->first();
        });

        return view('site.welcome.welcome', compact('sliders', 'categories', 'brands', 'new_arrivals', 'flash_sale'));
    }
}
