<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{

    public function index() {
        $wishlists = auth()->user()->wishlist()->get();
        return view('site.wishlist.index', compact('wishlists'));
    }
    public function toggle(Product $product)
    {

        if (!auth()->check()) {
            return response()->json(['status' => 'guest']);
        }

        $user = auth()->user();

        if($user->wishlist()->where('product_id', $product->id)->exists()) {
            $user->wishlist()->detach($product->id);

            return response()->json([
                'status' => 'added',
            ]);

        } else {
            $user->wishlist()->attach($product->id);

            return response()->json([
                'status' => 'removed',
            ]);
        }
    }
}
