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
                'status' => 'removed',
            ]);
        }

        if(count($compare) >= 4){
            return response()->json([
                'status' => 'full',
            ]);
        }


        $compare[] = $product->id;

        session()->put('compare', $compare);

        return response()->json([
            'status' => 'added',
        ]);

    }
}
