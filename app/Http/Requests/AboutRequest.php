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
       $rules =  [

        // =======================
        // Main Translations
        // =======================
        'translations.ar.title'   => 'required|string|max:255',
        'translations.en.title'   => 'required|string|max:255',
        'translations.ar.content' => 'required|string',
        'translations.en.content' => 'required|string',

        // =======================
        // Existing Lists
        // =======================
        'lists' => 'nullable|array',


        'lists.*.ar.content' => 'required|string',
        'lists.*.en.content' => 'required|string',


        // =======================
        // New Lists
        // =======================
        'new_lists' => 'nullable|array',

        'new_lists.*.place' => 'required|in:list,column',

        'new_lists.*.ar.content' => 'required|string',
        'new_lists.*.en.content' => 'required|string',

        'new_lists.*.ar.title' => 'required_if:new_lists.*.place,column|string|max:255',
        'new_lists.*.en.title' => 'required_if:new_lists.*.place,column|string|max:255',

    ];

    foreach ($this->lists ?? [] as $id => $data) {

        if (($data['place'] ?? null) === 'column') {

            $rules["lists.$id.ar.title"] = 'required|string|max:255';
            $rules["lists.$id.en.title"] = 'required|string|max:255';
        }

        $rules["lists.$id.ar.content"] = 'required|string';
        $rules["lists.$id.en.content"] = 'required|string';
    }

        return $rules;
    }

    public function attributes()
{
    $locale = app()->getLocale();

    if ($locale == 'ar') {
        return [
            'translations.ar.title' => 'العنوان بالعربي',
            'translations.en.title' => 'العنوان بالانجليزي',
            'translations.ar.content' => 'المحتوى بالعربي',
            'translations.en.content' => 'المحتوى بالانجليزي',

            'lists.*.ar.title' => 'عنوان الليست بالعربي',
            'lists.*.en.title' => 'عنوان الليست بالانجليزى',

            'new_lists.*.ar.title' => 'عنوان الليست بالعربي',
            'new_lists.*.en.title' => 'عنوان الليست بالانجليزى',

            'lists.*.ar.content' => 'محتوى الليست بالعربي',
            'lists.*.en.content' => 'محتوى الليست بالانجليزي',

            'new_lists.*.ar.content' => 'محتوى العنصر الجديد بالعربي',
            'new_lists.*.en.content' => 'محتوى العنصر الجديد بالانجليزي',

            'lists.*.place' => 'مكان الليست بالعربي',

            'new_lists.*.place' => 'مكان العنصر الجديد بالانجليزي'
        ];
    }

    return [
        'translations.ar.title' => 'Arabic title',
        'translations.en.title' => 'English title',
        'translations.ar.content' => 'Arabic content',
        'translations.en.content' => 'English content',

        'lists.*.ar.title' => 'Arabic list title',
        'lists.*.en.title' => 'English list title',

        'new_lists.*.ar.title' => 'New Arabic title',
        'new_lists.*.en.title' => 'New English title',

        'lists.*.ar.content' => 'Arabic list content',
        'lists.*.en.content' => 'English list content',

        'new_lists.*.ar.content' => 'New Arabic content',
        'new_lists.*.en.content' => 'New English content',

        'lists.*.place' => 'Arabic list place',

        'new_lists.*.place' => 'New English place'
    ];
}
}
