<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrderAttribute extends Model
{
    protected $guarded = [];

    public function getTranslatedNameAttribute()
    {
        $locale = app()->getLocale();

        $attribute = Attribute::whereTranslation('name', $this->name)->first();

        return $attribute?->translate($locale)?->name ?? $this->name;
    }

    public function getTranslatedValueAttribute()
    {
       $locale = app()->getLocale();

        // 1️⃣ هات attribute_id من الإنجليزي
        $attributeId = DB::table('attribute_translations')
            ->where('name', $this->value)
            ->where('locale', 'en') // اللغة الأصلية
            ->value('attribute_id');

        if (!$attributeId) {
            return $this->value;
        }

        // 2️⃣ هات الترجمة باللغة الحالية
        $translation = DB::table('attribute_translations')
            ->where('attribute_id', $attributeId)
            ->where('locale', $locale)
            ->value('name');

        return $translation ?? $this->value;
    }

}
