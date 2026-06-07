<?php

namespace App\Domain\Threads\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Thread extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'protocol_id',
        'user_id',
        'title',
        'body',
        'tags',
        'votes_count',
        'comments_count',
    ];

    protected $casts = [
        'tags' => 'array',
    ];

    /*
    |-----------------------------
    | Relationships
    |-----------------------------
    */

    public function protocol()
    {
        return $this->belongsTo(\App\Domain\Protocols\Models\Protocol::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function comments()
    {
        return $this->hasMany(\App\Domain\Comments\Models\Comment::class);
    }

    public function votes()
    {
        return $this->morphMany(\App\Domain\Votes\Models\Vote::class, 'votable');
    }

    protected static function newFactory()
    {
        return \Database\Factories\ThreadFactory::new();
    }

    public function searchableAs(): string
    {
        return 'threads';
    }

   public function toSearchableArray(): array
    {
        return [
            'id' => (string) $this->id,
            'title' => $this->title,
            'body' => $this->body,

            'tags' => is_array($this->tags)
                ? $this->tags
                : (json_decode($this->tags, true) ?? []),

            'protocol_id' => (string) $this->protocol_id,
            'votes_count' => (string) $this->votes_count,
            'user_id' => (string) $this->user_id,
            'user_name' => $this->user?->name,

            'created_at' => $this->created_at?->timestamp,
        ];
    }
}