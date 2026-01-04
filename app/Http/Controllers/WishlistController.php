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
            return response()->json([
                'type' => 'warning',
                'title' => 'Warning',
                'status' => 'guest'
            ]);
        }

        $user = auth()->user();

        if($user->wishlist()->where('product_id', $product->id)->exists()) {
            $user->wishlist()->detach($product->id);

            return response()->json([
                'type' => 'success',
                'title' => 'Removed',
                'message' => 'Wishlist Removed Successfully',
                'status' => 'removed',
                'active' => 0,
                "wishlist_count" => $user->wishlist()->count()
            ]);

        } else {
            $user->wishlist()->attach($product->id);

            return response()->json([
                'type' => 'success',
                'title' => 'Added',
                'message' => 'Wishlist Added Successfully',
                'status' => 'added',
                'active' => 1,
                "wishlist_count" => $user->wishlist()->count()
            ]);
        }
    }
}
