<?php

namespace App\Domain\Protocols\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProtocolResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,

            'tags' => is_string($this->tags)
                ? json_decode($this->tags, true)
                : $this->tags,

            'avg_rating' => round($this->reviews_avg_rating ?? 0, 1),
            'reviews_count' => $this->reviews_count ?? 0,

            'author' => [
                'id' => $this->user?->id,
                'name' => $this->user?->name,
            ],

            

            'created_at' => $this->created_at,
        ];
    }
}