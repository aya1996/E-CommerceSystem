<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [

            'invoice_number' => $this->invoice_number,
            'total_amount' => $this->total_amount,
            'sub_total' => $this->sub_total,
            'discount' => $this->discount,
            'invoiceDate' => $this->invoiceDate,

            'taxes' => $this->taxes()->get()->map(function ($tax) {
                return [
                    'name' => $tax->name,
                    'amount' => $tax->rate,
                ];
            }),

        ];
    }
}
