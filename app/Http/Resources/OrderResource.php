<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_name' => $this->user_name,
            'surname' => $this->surname,
            'status' => $this->status,
            'total_amount' => $this->total_amount,
            'created_at' => $this->created_at,

        ];
    }
}
