<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function save(Request $request)
    {
        Contact::create($request->all());

        return  redirect()->route('faqs')->with('success', 'تم الارسال بنجاح');

    }
}
