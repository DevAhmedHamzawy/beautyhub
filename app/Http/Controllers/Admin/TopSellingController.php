<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TopSelling;
use App\Models\Product;
use Illuminate\Http\Request;

class TopSellingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:edit_settings'])->only(['update']);
    }

    public function create()
    {
        $products = Product::whereRelation('stocks', 'qty', '>', 0)->get();

        $top_sellings = TopSelling::all();

        return view('admin.top_sellings.add', compact('products', 'top_sellings'));
    }

    public function store(Request $request)
    {
        TopSelling::truncate();

       foreach ($request->product_ids as $product_id) {
            TopSelling::updateOrCreate(['product_id' => $product_id]);
       }

       $message = [
            'alert-type' => 'success',
            'title' =>  trans('top_selling.add_success'),
            'message' => trans('top_selling.add_success')
        ];

        activity()->log('قام '.auth()->user()->name.'  بتعديل الأكثر مبيعا ');

        return redirect()->route('admin.top_sellings.create')->with($message);
    }
}
