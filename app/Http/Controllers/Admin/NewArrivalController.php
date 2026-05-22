<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewArrival;
use App\Models\Product;
use Illuminate\Http\Request;

class NewArrivalController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:edit_settings'])->only(['update']);
    }

    public function create()
    {
        $products = Product::whereRelation('stocks', 'qty', '>', 0)->get();

        $new_arrivals = NewArrival::all();

        return view('admin.new_arrivals.add', compact('products', 'new_arrivals'));
    }

    public function store(Request $request)
    {
        NewArrival::truncate();

       foreach ($request->product_ids as $product_id) {
            NewArrival::updateOrCreate(['product_id' => $product_id]);
       }

       $message = [
            'alert-type' => 'success',
            'title' =>  trans('new_arrival.add_success'),
            'message' => trans('new_arrival.add_success')
        ];

        activity()->log('قام '.auth()->user()->name.'  بتعديل اضيف حديثا ');

        return redirect()->route('admin.new_arrivals.create')->with($message);
    }
}
