<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
        return [
            'main_image' => 'mimes:jpeg,jpg,png,gif|sometimes|max:10000',
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'additional_phone' => 'required',
            'address' => 'required',
            'area_id' => 'required|exists:areas,id',
        ];
    }
}
