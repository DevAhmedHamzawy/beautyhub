<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\About;
use App\Models\AboutTranslation;
use App\Models\AboutList;
use App\Models\AboutListTranslation;

class AboutSeeder extends Seeder
{
    public function run()
    {
        $about = About::firstOrCreate(['id' => 1]);

        // =====================
        // About Translations
        // =====================
        $translations = [
            'ar' => [
                'title' => 'من نحن',
                'content' => 'هذا نص تجريبي لصفحة من نحن...'
            ],
            'en' => [
                'title' => 'About Us',
                'content' => 'This is a sample about us content...'
            ],
        ];

        foreach ($translations as $locale => $data) {
            AboutTranslation::updateOrCreate(
                ['about_id' => $about->id, 'locale' => $locale],
                $data
            );
        }

        // =====================
        // LIST TYPE
        // =====================
        $list = AboutList::firstOrCreate([
            'about_id' => $about->id,
            'place' => 'list',
        ]);

        foreach ([
            'ar' => 'جودة عالية',
            'en' => 'High quality',
        ] as $locale => $content) {
            AboutListTranslation::updateOrCreate(
                [
                    'about_list_id' => $list->id,
                    'locale' => $locale
                ],
                ['content' => $content]
            );
        }

        // =====================
        // COLUMN TYPE
        // =====================
        $column = AboutList::firstOrCreate([
            'about_id' => $about->id,
            'place' => 'column',
        ]);

        foreach ([
            'ar' => [
                'title' => 'جودة عالية',
                'content' => 'وصف جودة عالي'
            ],
            'en' => [
                'title' => 'High Quality',
                'content' => 'Premium quality description'
            ],
        ] as $locale => $data) {
            AboutListTranslation::updateOrCreate(
                [
                    'about_list_id' => $column->id, // ✅ FIXED
                    'locale' => $locale
                ],
                $data
            );
        }
    }
}
