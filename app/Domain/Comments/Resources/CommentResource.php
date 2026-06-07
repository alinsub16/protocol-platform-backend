<?php

namespace App\Domain\Comments\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'body' => $this->body,

            'author' => [
                'id' => $this->user?->id,
                'name' => $this->user?->name,
            ],

            'thread_id' => $this->thread_id,
            'parent_id' => $this->parent_id,

            'votes_count' => $this->votes_count ?? 0,

            // nested replies support
            'replies' => $this->whenLoaded('replies', function () {
                return CommentResource::collection($this->replies);
            }),

            'created_at' => $this->created_at,
        ];
    }
}