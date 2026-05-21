<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\Area;
use App\Models\Order;
use App\Upload\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function show()
    {
        $areas = Area::getMainAreas();

        $city = Area::where('id', auth()->user()->defaultAddress?->area_id)->first();
        $city == null ? $governorate = null : $governorate = Area::where('id', $city->parent_id)->first();
        $governorate == null ? $country = null : $country = Area::where('id', $governorate->parent_id)->first();

        $new_orders = Order::whereIn('status_id',[1, 2])->where('user_id', auth()->id())->count();

        $orders_delivered = Order::whereIn('status_id',[5])->where('user_id', auth()->id())->count();


        return view('site.profile.show', ['areas' => $areas, 'theCity' => $city, 'theGovernorate' => $governorate , 'theCountry' => $country , 'new_orders' => $new_orders , 'orders_delivered' => $orders_delivered]);
    }

    public function updateAddress(AddressRequest $request)
    {
        if($request->has('main_image')){
            Upload::deleteImage('users', auth()->user()->image);
            $request->merge(['image' =>  Upload::uploadImage($request->main_image, 'users' , $request->name)]);
        }

        auth()->user()->update($request->only('name', 'email', 'image'));

        auth()->user()->defaultAddress()->update($request->except('name', 'email', 'main_image', "image", "_token"));

        return redirect()->back()->with('success', trans('main.updated_success'));
    }

    public function updatePassword(ChangePasswordRequest $request)
    {
        $user = auth()->user();

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->back()->with('success', trans('main.updated_success'));

    }
}
