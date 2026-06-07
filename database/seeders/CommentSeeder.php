<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Domain\Threads\Models\Thread;
use App\Domain\Comments\Models\Comment;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $threads = Thread::all();

        foreach ($threads as $thread) {

            // Main comments
            $comments = Comment::factory(rand(3, 8))->create([
                'thread_id' => $thread->id,
                'parent_id' => null,
            ]);

            // Replies
            foreach ($comments as $comment) {

                if (rand(0, 100) < 50) {

                    Comment::factory(rand(1, 3))->create([
                        'thread_id' => $thread->id,
                        'parent_id' => $comment->id,
                    ]);
                }
            }
        }
    }
}