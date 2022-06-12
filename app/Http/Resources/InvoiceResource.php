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
            'id' => $this->id,
            'user_id' => $this->user_id,
            'status' => $this->status,
            'invoice_number' => $this->invoice_number,
            'total_amount' => $this->total_amount,
            'sub_total' => $this->sub_total,
            'discount' => $this->discount,
            'invoiceDate' => $this->invoiceDate,
            'products' => $this->products()->get(),
            'taxes' => $this->taxes()->get(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
