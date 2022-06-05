<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class ProductResource extends JsonResource
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
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
            'feature_image' => $this->feature_image,
            'categories' => $this->categories()->get(),
            'colors' => $this->colors()->get(),
            'sizes' => $this->sizes()->get(),
            'images' => $this->images()->get(),

        ];
    }
}
