<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AboutRequest;
use App\Models\About;
use App\Models\AboutTranslation;
use App\Models\AboutList;
use App\Models\AboutListTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AboutController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:edit_settings'])->only(['update']);
    }
    public function edit()
    {
        $about = About::with([
            'translations',
            'lists.translations'
        ])->findOrFail(1);

        return view('admin.about.edit', compact('about'));
    }

    public function update(AboutRequest $request)
    {
        DB::transaction(function () use ($request) {

            $about = About::findOrFail(1);
            $locales = ['ar', 'en'];

            // ===============================
            // 1️⃣ Update Main Translations
            // ===============================
            foreach ($locales as $locale) {
                AboutTranslation::updateOrCreate(
                    [
                        'about_id' => $about->id,
                        'locale'   => $locale
                    ],
                    [
                        'about_id' => $about->id,
                        'locale'   => $locale,
                        'title'   => $request->translations[$locale]['title'] ?? '',
                        'content' => $request->translations[$locale]['content'] ?? '',
                    ]
                );
            }

           if ($request->deleted_lists) {
                AboutListTranslation::whereIn('about_list_id', $request->deleted_lists)->delete();
                AboutList::whereIn('id', $request->deleted_lists)->delete();
            }

            // ===============================
            // 3️⃣ Update Existing Lists
            // ===============================
            if ($request->lists) {
                foreach ($request->lists as $listId => $translations) {

                    $list = AboutList::find($listId);
                    if($list){
                        $list->update([
                            'icon' => $translations['icon'] ?? $list->icon
                        ]);

                        foreach ($locales as $locale) {
                            AboutListTranslation::updateOrCreate(
                                [
                                    'about_list_id' => $listId,
                                    'locale'        => $locale,
                                ],
                                [
                                    'title'   => $translations[$locale]['title'] ?? null,
                                    'content' => $translations[$locale]['content'] ?? '',
                                ]
                            );
                        }
                    }
                }
            }

            // ===============================
            // 4️⃣ Create New Lists (list + column)
            // ===============================
            if ($request->new_lists) {
                foreach ($request->new_lists as $listData) {

                    $list = AboutList::create([
                        'about_id' => $about->id,
                        'place'    => $listData['place'] ?? 'list',
                        'icon'     => $listData['icon'] ?? null
                    ]);

                    foreach ($locales as $locale) {
                        AboutListTranslation::create([
                            'about_list_id' => $list->id,
                            'locale'        => $locale,
                            'title'         => $listData[$locale]['title'] ?? null,
                            'content'       => $listData[$locale]['content'] ?? '',
                        ]);
                    }
                }
            }
        });

        $message = [
            'alert-type' => 'success',
            'title' =>  trans('about.updated_success'),
            'message' => trans('about.updated_success')
        ];

        activity()->log('قام '.auth()->user()->name.' بتعديل صفحة عن الموقع');


        return redirect()->route('admin.about.edit')->with($message);
    }
}
