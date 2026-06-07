<?php

namespace App\Domain\Reviews\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'protocol_id',
        'user_id',
        'rating',
        'feedback',
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

     protected static function newFactory()
    {
        return \Database\Factories\ReviewFactory::new();
    }
}