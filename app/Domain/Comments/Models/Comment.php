<?php

namespace App\Domain\Comments\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'thread_id',
        'user_id',
        'parent_id',
        'body',
        'votes_count',
    ];

    /*
    |-----------------------------
    | Relationships
    |-----------------------------
    */

    public function thread()
    {
        return $this->belongsTo(\App\Domain\Threads\Models\Thread::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    // parent comment
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    // child comments (replies)
   public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')
           ->with('user', 'replies');
    }

    public function votes()
    {
        return $this->morphMany(\App\Domain\Votes\Models\Vote::class, 'votable');
    }

     protected static function newFactory()
    {
        return \Database\Factories\CommentFactory::new();
    }
}