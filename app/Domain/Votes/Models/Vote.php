<?php

namespace App\Domain\Votes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\VoteFactory;
use App\Models\User;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'votable_id',
        'votable_type',
        'value',
    ];

    /*
    |-----------------------------
    | Relationships
    |-----------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function votable()
    {
        return $this->morphTo();
    }

     protected static function newFactory()
    {
        return VoteFactory::new();
    }
}