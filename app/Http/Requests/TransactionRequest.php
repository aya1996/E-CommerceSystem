<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'payment_method' => 'required|string',
            'payment_status' => 'required|string',
            'payment_amount' => 'required|string',
            'payment_currency' => 'required|string',
            'payment_date' => 'required|date',

        ];
    }
}
