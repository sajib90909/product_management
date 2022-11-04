<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'price' => 'required',
            'category_id' => 'required',
            'display_image' => 'nullable|image|mimes:png,jpg,png,jpeg|max:1024',
            'gallery_image.*' => 'nullable|image|mimes:png,jpg,jpeg|max:1024'
        ];
    }
}
