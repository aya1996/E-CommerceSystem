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
            'transaction_id' => 'unique:transactions,transaction_id',
            'payment_method.en' => 'required|string|regex:/^[a-zA-Z 0-9 ]+$/u',
            'payment_method.ar'         => 'required|string|regex:/^[\p{Arabic} 0-9 ]+$/u',
            'payment_status.en' => 'required|string|regex:/^[a-zA-Z 0-9 ]+$/u',
            'payment_status.ar'         => 'required|string|regex:/^[\p{Arabic} 0-9 ]+$/u',
            'payment_currency.en' => 'required|string|regex:/^[a-zA-Z 0-9 ]+$/u',
            'payment_currency.ar'         => 'required|string|regex:/^[\p{Arabic} 0-9 ]+$/u',
            'payment_amount' => 'exists:invoices,sub_total',
            'payment_date' => 'required|date',

        ];
    }
}
