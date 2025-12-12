<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->model->name,
            'description' => $this->model->description,
            'product_photo' => $this->model->when($this->model->hasMedia('product_photo'), function () {
                return $this->model->getFirstMedia('product_photo')->getUrl();
            }),
            'price' => $this->model->price,
            'brand' => $this->model->brand,
            'article' => $this->model->article,
        ];
    }
}
