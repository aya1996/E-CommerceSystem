<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
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
            // 'products' => 'required|array',
            // 'products.*' => 'required|exists:products,id',
            'taxes' => 'required|array',
            'invoice_number' => 'unique:invoices,invoice_number',
            'taxes.*' => 'required|exists:taxes,id',
            'user_id' => 'required|exists:users,id',
            'status' => 'required|boolean',
            'invoiceDate' => 'required|date',
        ];
    }
}
