<?php

namespace App\Http\Controllers;

use App\Filters\AttributeFilter;
use App\Filters\BrandFilter;
use App\Filters\CategoryFilter;
use App\Filters\NameFilter;
use App\Filters\PriceFilter;
use App\Filters\SortFilter;
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
        $min = null;
        $max = null;
        $products = Product::whereRelation('stocks', 'qty', '>', 0)->paginate(12);

        return view('site.products.search', compact('categories', 'brands', 'attributes', 'products', 'min', 'max'));
    }


    public function getFilters()
    {
        $products = Product::filter($this->filters())->whereRelation('stocks', 'qty', '>', 0)->latest()->paginate(12);

        $html = view('site.products.partials.search.result', compact('products'))->render();

        if(request()->wantsJson()) {
            return response()->json([
                'html' => $html,
                'has_more' => $products->hasMorePages(),
                'total' => $products->total()
            ]);
        }

        $categories = Category::whereActive(1)->whereNull('parent_id')->get();
        $brands = Brand::whereActive(1)->get();
        $attributes = Attribute::whereActive(1)->whereNull('parent_id')->with('children')->get();
        $price = request('price', []);
        $min = $price[0] ?? null;
        $max = $price[1] ?? null;

        return view('site.products.search', compact('categories', 'brands', 'attributes', 'products', 'min', 'max'));

    }

    protected function filters()
    {
        return [
            'name' => new NameFilter,
            'brand_id' => new BrandFilter,
            'price' => new PriceFilter,
            'category_id' => new CategoryFilter,
            'attributes' => new AttributeFilter,
            'sort' => new SortFilter
        ];
    }
}
