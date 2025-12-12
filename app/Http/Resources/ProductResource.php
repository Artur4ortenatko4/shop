<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'product_photo' => $this->when($this->hasMedia('product_photo'), function () {
                return $this->getFirstMedia('product_photo')->getUrl();
            }),
            'price' => $this->price,
            'old_price' => $this->old_price,
            'brand' => $this->brand,
            'article'=> $this->article,
            'slug'=> $this->slug
        ];
    }
}
