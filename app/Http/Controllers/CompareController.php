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
                'title' => 'Removed',
                'message' => 'Compare Removed Successfully',
                'status' => 'removed',
                'active' => 0,
                "compare_count" => count($compare)
            ]);
        }

        if(count($compare) >= 3){
            return response()->json([
                'type' => 'warning',
                'title' => 'Full',
                'message' => 'Cannot add more than 3 products',
                'status' => 'full',
            ]);
        }


        $compare[] = $product->id;

        session()->put('compare', $compare);

        return response()->json([
            'type' => 'success',
            'title' => 'Added',
            'message' => 'Compare Added Successfully',
            'status' => 'added',
            'active' => 1,
            "compare_count" => count($compare)
        ]);

    }
}
