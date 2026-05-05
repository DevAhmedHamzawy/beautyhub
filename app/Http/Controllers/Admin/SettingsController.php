<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use App\Upload\Upload;
use Illuminate\Http\Request;

class SettingsController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:edit_settings'])->only(['update']);
    }
    public function edit()
    {
        return view('admin.settings.edit', [
            'settings' => \App\Models\Settings::whereId(1)->first(),
        ]);
    }

    public function update(Request $request)
    {
        $settings = Settings::whereId(1)->first();

        if($request->has('logo_img')){
            Upload::deleteImage('settings', $settings->logo);
            $request->merge(['logo' =>  Upload::uploadImage($request->logo_img, 'settings' , 'logo'), 'slug' => 'logo']);
        }

        if($request->has('favicon_img')){
            Upload::deleteImage('settings', $settings->favicon);
            $request->merge(['favicon' =>  Upload::uploadImage($request->favicon_img, 'settings' , 'favicon'), 'slug' => 'favicon']);
        }

        if($request->has('footer_logo_img')){
            Upload::deleteImage('settings', $settings->footer_logo);
            $request->merge(['footer_logo' =>  Upload::uploadImage($request->footer_logo_img, 'settings' , 'footer_logo'), 'slug' => 'footer_logo']);
        }

        if($request->has('banner_one_img')){
            Upload::deleteImage('settings', $settings->banner_one);
            $request->merge(['banner_one' =>  Upload::uploadImage($request->banner_one_img, 'settings' , 'banner_one'), 'slug' => 'banner_one']);
        }

        if($request->has('banner_two_img')){
            Upload::deleteImage('settings', $settings->banner_two);
            $request->merge(['banner_two' =>  Upload::uploadImage($request->banner_two_img, 'settings' , 'banner_two'), 'slug' => 'banner_two']);
        }

        if($request->has('banner_three_img')){
            Upload::deleteImage('settings', $settings->banner_three);
            $request->merge(['banner_three' =>  Upload::uploadImage($request->banner_three_img, 'settings' , 'banner_three'), 'slug' => 'banner_three']);
        }

        if($request->has('banner_four_img')){
            Upload::deleteImage('settings', $settings->banner_four);
            $request->merge(['banner_four' =>  Upload::uploadImage($request->banner_four_img, 'settings' , 'banner_four'), 'slug' => 'banner_four']);
        }

        if($request->has('banner_five_img')){
            Upload::deleteImage('settings', $settings->banner_five);
            $request->merge(['banner_five' =>  Upload::uploadImage($request->banner_five_img, 'settings' , 'banner_five'), 'slug' => 'banner_five']);
        }

        if($request->has('banner_six_img')){
            Upload::deleteImage('settings', $settings->banner_six);
            $request->merge(['banner_six' =>  Upload::uploadImage($request->banner_six_img, 'settings' , 'banner_six'), 'slug' => 'banner_six']);
        }


        $settings->update($request->except(1, 'slug', 'logo_img', 'favicon_img', 'footer_logo_img', 'banner_one_img', 'banner_two_img', 'banner_three_img', 'banner_four_img', 'banner_five_img', 'banner_six_img', 'footer_logo_img'));

        $message = [
            'alert-type' => 'success',
            'title' =>  trans('settings.updated_success'),
            'message' => trans('settings.updated_success')
        ];

        activity()->log('قام '.auth()->user()->name.'  بتعديل صفحة الاعدادات');

        return redirect()->route('admin.settings.edit')->with($message);

    }
}
