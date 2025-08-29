<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Slider;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::whereActive(1)->get();
        $categories = Category::whereActive(1)->whereNull('parent_id')->get();
        $brands = Brand::whereActive(1)->get();

        return view('site.welcome.welcome', compact('sliders', 'categories', 'brands'));
    }
}
