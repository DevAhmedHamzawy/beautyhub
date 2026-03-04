<?php

namespace App\Http\Controllers;

use App\Models\About;

class AboutController extends Controller
{
    public function index()
    {
        $about = About::where('id', 1)->first();
        $lists = $about->lists->where('place', 'list');
        $columns = $about->lists->where('place', 'column');
        return view('site.about.index', compact('about', 'lists', 'columns'));
    }
}
