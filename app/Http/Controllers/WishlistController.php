<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{

    public function index() {
        $wishlists = auth()->user()?->wishlist()->get();

        if(!$wishlists) {
            return view('site.wishlist_empty');
        }

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
                'title' => trans('main.removed'),
                'message' => trans('main.wishlist_removed_successfully'),
                'status' => 'removed',
                'active' => 0,
                "wishlist_count" => $user->wishlist()->count()
            ]);

        } else {
            $user->wishlist()->attach($product->id);

            return response()->json([
                'type' => 'success',
                'title' => trans('main.added'),
                'message' => trans('main.wishlist_added_successfully'),
                'status' => 'added',
                'active' => 1,
                "wishlist_count" => $user->wishlist()->count()
            ]);
        }
    }

    public function remove(Request $request) {
        $user = auth()->user();
        $user->wishlist()->detach($request->product_id);

        return response()->json([
            'type' => 'success',
            'title' => trans('main.removed'),
            'message' => trans('main.wishlist_removed_successfully'),
            'status' => 'removed',
            'active' => 0,
            "count" => $user->wishlist()->count()
        ]);
    }
}
