<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CompareController extends Controller
{
    public function index()
    {
        $compare = session()->get('compare', []);

        return view('site.compare.index', ['products' => Product::whereIn('id', $compare)->get()]);
    }

    public function toggle(Product $product)
    {
        $compare = session()->get('compare', []);

        if(in_array($product->id, $compare)){
            $compare = array_filter($compare, fn($p) => $p != $product->id);

            session()->put('compare', $compare);

            return response()->json([
                'type' => 'success',
                'title' => trans('main.removed'),
                'message' => trans('main.comparison_removed_successfully'),
                'status' => 'removed',
                'active' => 0,
                "compare_count" => count($compare)
            ]);
        }

        if(count($compare) >= 3){
            return response()->json([
                'type' => 'warning',
                'title' => trans('main.full'),
                'message' => trans('main.cannot_add_more_than_3_products'),
                'status' => 'full',
            ]);
        }


        $compare[] = $product->id;

        session()->put('compare', $compare);

        return response()->json([
            'type' => 'success',
            'title' => trans('main.added'),
            'message' => trans('main.comparison_added_successfully'),
            'status' => 'added',
            'active' => 1,
            "compare_count" => count($compare)
        ]);

    }

    public function remove(Request $request)
    {
        $compare = session()->get('compare', []);
        $id = $request->input('product_id');
        $compare = array_filter($compare, fn($p) => $p != $id);
        session()->put('compare', $compare);

        return response()->json([
            'type' => 'success',
            'title' => trans('main.removed'),
            'message' => trans('main.comparison_removed_successfully'),
            'status' => 'removed',
            'active' => 1,
            "count" => count($compare)
        ]);
    }
}
