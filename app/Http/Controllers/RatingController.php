<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RatingController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:1000'
        ]);

        if ($validator->fails()) {

        return back()
            ->withInput()
            ->withErrors($validator)
            ->with('error', $validator->errors()->first());
         }

        Rating::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'product_id' => $product->id
            ],
            [
                'rating' => $request->rating,
                'review' => $request->review
            ]
        );

        return back()->with('success', trans('main.review_added_successfully'));
    }
}
