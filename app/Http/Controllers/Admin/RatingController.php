<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:view_ratings'])->only(['index']);
        $this->middleware(['permission:approve_rating'])->only(['approve']);
    }

    public function index()
    {
        $ratings = Rating::with('user', 'product')->get();
        return view('admin.ratings.index', compact('ratings'));
    }

    public function approve(Rating $rating)
    {
        $rating->approved ^= 1;
        $rating->save();

        $message = [
            'alert-type' => 'success',
            'title' =>  $rating->approved ? trans('rating.approve_success') : trans('rating.unapprove_success'),
            'message' => $rating->approved ? trans('rating.approve_success') : trans('rating.unapprove_success'),
        ];

        $rating->approved ?  activity()->log('قام '.auth()->user()->name.'باعتماد التقييم '.$rating->review) : activity()->log('قام '.auth()->user()->name.'بالغاء اعتماد التقييم '.$rating->review);

        return redirect()->back()->with($message);
    }

}
