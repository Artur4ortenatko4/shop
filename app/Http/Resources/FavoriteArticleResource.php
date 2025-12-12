<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteArticleResource extends JsonResource
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
            'content' => $this->model->content,
            'photo' => $this->model->when($this->model->hasMedia('photo'), function () {
                return $this->model->getFirstMedia('photo')->getUrl();
            }),
            'created_at' => $this->model->price,

        ];
    }
}
