<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AboutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $locales = ['ar', 'en'];

        $rules = [];

        // =======================
        // 1️⃣ Validation Translations
        // =======================
        foreach ($locales as $locale) {
            $rules["translations.$locale.title"]   = 'required|string|max:255';
            $rules["translations.$locale.content"] = 'required|string';
        }

        // =======================
        // 2️⃣ Validation Existing Lists
        // =======================
        if ($this->lists) {
            foreach ($this->lists as $listId => $translations) {
                foreach ($locales as $locale) {
                    $rules["lists.$listId.$locale.content"] = 'required|string';
                }
            }
        }

        // =======================
        // 3️⃣ Validation New Lists / Columns
        // =======================
        if ($this->new_lists) {
            foreach ($this->new_lists as $tempId => $listData) {
                $rules["new_lists.$tempId.place"] = 'required|in:list,column';

                foreach ($locales as $locale) {
                    $rules["new_lists.$tempId.$locale.content"] = 'required|string';
                }
            }
        }

        return $rules;

    }
}
