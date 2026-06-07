<?php

namespace App\Domain\Votes\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VoteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'value' => $this->value, // 1 or -1

            'user' => [
                'id' => $this->user?->id,
                'name' => $this->user?->name,
            ],

            'votable_type' => class_basename($this->votable_type),
            'votable_id' => $this->votable_id,

            'created_at' => $this->created_at,
        ];
    }
}