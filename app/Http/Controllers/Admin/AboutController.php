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
                        'title'   => $request->translations[$locale]['title'] ?? '',
                        'content' => $request->translations[$locale]['content'] ?? '',
                    ]
                );
            }

            // ===============================
            // 2️⃣ Track Existing Lists (for delete detection)
            // ===============================
            $existingIds = AboutList::where('about_id', $about->id)->pluck('id')->toArray();
            $submittedIds = array_keys($request->lists ?? []);

            // lists that were removed from UI
            $deletedIds = array_diff($existingIds, $submittedIds);

            if (!empty($deletedIds)) {
                AboutListTranslation::whereIn('about_list_id', $deletedIds)->delete();
                AboutList::whereIn('id', $deletedIds)->delete();
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

        return back()->with('success', 'تم تحديث صفحة من نحن بنجاح');
    }
}
