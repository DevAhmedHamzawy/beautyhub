<?php

namespace App\Http\Controllers;

use App\Filters\AttributeFilter;
use App\Filters\BrandFilter;
use App\Filters\CategoryFilter;
use App\Filters\NameFilter;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {
        $categories = Category::whereActive(1)->whereNull('parent_id')->get();
        $brands = Brand::whereActive(1)->get();
        $attributes = Attribute::whereActive(1)->whereNull('parent_id')->with('children')->get();

        $products = Product::whereRelation('stocks', 'qty', '>', 0)->get();

        return view('site.products.search', compact('categories', 'brands', 'attributes', 'products'));
    }


    public function getFilters()
    {
        $products = Product::filter($this->filters())->whereRelation('stocks', 'qty', '>', 0)->latest()->get();

        $html = view('site.products.partials.search.result', compact('products'))->render();

        return response()->json(compact('html'));

    }

    protected function filters()
    {
        return [
            'name' => new NameFilter,
            'brand_id' => new BrandFilter,
            'category_id' => new CategoryFilter,
            'attributes' => new AttributeFilter
        ];
    }
}
