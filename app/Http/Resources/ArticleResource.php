<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
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
            'content' => $this->content,
            'photo' => $this->when($this->hasMedia('photo'), function () {
                return $this->getFirstMedia('photo')->getUrl();
            }),
            'created_at' => $this->created_at,
        ];
    }
}
