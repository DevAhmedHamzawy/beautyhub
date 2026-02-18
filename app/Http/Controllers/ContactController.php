<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('site.contact.index');
    }

    public function save(Request $request)
    {
        Contact::create($request->except('sort'));

        if($request->sort == 'contact'){
            return  redirect()->route('contact')->with('success', 'تم الارسال بنجاح');
        }else {
            return  redirect()->route('faqs')->with('success', 'تم الارسال بنجاح');
        }

    }
}
