<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Domain\Threads\Models\Thread;
use App\Domain\Comments\Models\Comment;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Relation::enforceMorphMap([ 
            'thread' => Thread::class,
            'comment' => Comment::class,
        ]);
    }
}