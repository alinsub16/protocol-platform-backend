<?php

namespace App\Domain\Threads\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ThreadResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'title' => $this->title,
            'body' => $this->body,

            'protocol' => [
                'id' => $this->protocol?->id,
                'title' => $this->protocol?->title,
            ],

            'author' => [
                'id' => $this->user?->id,
                'name' => $this->user?->name,
            ],

            'tags' => is_string($this->tags)
                ? json_decode($this->tags, true)
                : $this->tags,

            'votes_count' => $this->votes_count ?? 0,
            'comments_count' => $this->comments_count ?? 0,

            'created_at' => $this->created_at,
        ];
    }
}