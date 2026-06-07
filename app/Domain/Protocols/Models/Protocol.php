<?php

namespace App\Domain\Protocols\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Protocol extends Model
{
    use HasFactory, Searchable;

    protected $table = 'protocols';

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'tags',
        'avg_rating',
        'votes_count',
        'reviews_count',
    ];

    protected $casts = [
        'tags' => 'array',
    ];

    /*
    |-----------------------------
    | Relationships
    |-----------------------------
    */

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function threads()
    {
        return $this->hasMany(\App\Domain\Threads\Models\Thread::class);
    }

    public function reviews()
    {
        return $this->hasMany(\App\Domain\Reviews\Models\Review::class);
    }
    public function votes()
        {
            return $this->morphMany(\App\Domain\Votes\Models\Vote::class, 'votable');
        }

    protected static function newFactory()
        {
            return \Database\Factories\ProtocolFactory::new();
        }

    public function searchableAs(): string
    {
        return 'protocols';
    }

    public function toSearchableArray(): array
        {
            return [
                'id' => (string) $this->id,
                'title' => $this->title,
                'tags' => $this->tags ?? [],
                'votes_count' => (int) $this->votes_count,
            ];
        }

}