<?php

namespace App\Domain\Reviews\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'rating' => (int) $this->rating,
            'feedback' => $this->feedback,

            'user' => [
                'id' => $this->user?->id,
                'name' => $this->user?->name,
            ],

            'protocol_id' => $this->protocol_id,

            'created_at' => $this->created_at,
        ];
    }
}