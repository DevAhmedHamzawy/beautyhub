<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('site.contact.index');
    }

    public function save(ContactRequest $request)
    {
        Contact::create($request->except('sort'));

        if($request->sort == 'contact'){
            return  redirect()->route('contact')->with('success', trans('main.send_success'));
        }else {
            return  redirect()->route('faqs')->with('success', trans('main.send_success'));
        }

    }
}
