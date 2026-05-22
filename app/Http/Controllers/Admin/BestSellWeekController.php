<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BestSellWeek;
use App\Models\Product;
use Illuminate\Http\Request;

class BestSellWeekController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:edit_settings'])->only(['update']);
    }

    public function create()
    {
        $products = Product::whereRelation('stocks', 'qty', '>', 0)->get();

        $best_sell_weeks = BestSellWeek::all();

        return view('admin.best_sell_weeks.add', compact('products', 'best_sell_weeks'));
    }

    public function store(Request $request)
    {
        BestSellWeek::truncate();

       foreach ($request->product_ids as $product_id) {
            BestSellWeek::updateOrCreate(['product_id' => $product_id]);
       }

       $message = [
            'alert-type' => 'success',
            'title' =>  trans('best_sell_week.add_success'),
            'message' => trans('best_sell_week.add_success')
        ];

        activity()->log('قام '.auth()->user()->name.'  بتعديل  الأكثر مبيعا في الاسبوع ');

        return redirect()->route('admin.best_sell_weeks.create')->with($message);
    }
}
