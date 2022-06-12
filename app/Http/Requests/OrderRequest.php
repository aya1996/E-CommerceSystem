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

            'products' => 'required|array',
            'products.*' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
            'shipping_date' => 'required|date',
            'delivery_date' => 'required|date',
            'status.en' => 'required|string|regex:/^[a-zA-Z 0-9 ]+$/u',
            'status.ar'         => 'required|string|regex:/^[\p{Arabic} 0-9 ]+$/u',


        ];
    }
}
