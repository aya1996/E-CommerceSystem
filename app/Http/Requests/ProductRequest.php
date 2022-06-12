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
            'name.en' => 'required|string|regex:/^[a-zA-Z 0-9 ]+$/u',
            'name.ar'         => 'required|string|regex:/^[\p{Arabic} 0-9 ]+$/u',
            'price' => 'required|integer',
            'description.en' => 'required|string|regex:/^[a-zA-Z 0-9 ]+$/u',
            'description.ar'         => 'required|string|regex:/^[\p{Arabic} 0-9 ]+$/u',
            'feature_image' => 'required|image ',
            'categories' => 'required|array|min:1max:5|exists:categories,id',
            'colors' => 'required|array|min:1max:5|exists:colors,id',
            'sizes' => 'required|array|min:1max:5|exists:sizes,id',
            // 'images' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }
}
