<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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

            'products' => 'required|array | min:1 | max:10',
            'products.*' => 'required|exists:products,id',
            'user_id' => 'exists:users,id',
            'shipping_date' => 'required|date',
            'delivery_date' => 'required|date',
            'status' => 'string',
            'delivery_id' => 'exists:deliveries,id|nullable',
            'latitude' => 'required|string|max:255',
            'longitude' => 'required|string|max:255',





        ];
    }

    public function prepareForValidation()
    {
        return $this->merge([
            'status' => 'pending',
        ]);
    }
}
