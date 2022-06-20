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
            'user_id' => 'exists:users,id',
            'transaction_id' => 'unique:transactions,transaction_id',
            'payment_method' => 'required|in:credit_card,debit_card,paypal',

            'payment_status' => 'required|string|in:paid,pending,cancelled',

            'payment_currency' => 'required|string',

            'payment_amount' => 'exists:invoices,sub_total',
            'payment_date' => 'required|date',

        ];
    }
}
