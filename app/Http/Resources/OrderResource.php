<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'shipping_date' => $this->shipping_date,
            'delivery_date' => $this->delivery_date,
            'status' => $this->status,
            'products' => $this->products()->get(),
            'invoice' => $this->invoice()->get(),

        ];
    }
}
