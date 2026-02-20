<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function edit()
    {
        return view('admin.settings.edit', [
            'settings' => \App\Models\Settings::whereId(1)->first(),
        ]);
    }

    public function update(Request $request)
    {
        $settings = \App\Models\Settings::whereId(1)->first();
        $settings->update($request->except(1));
        return redirect()->route('admin.settings.edit')->with('success', 'Settings updated successfully');
    }
}
