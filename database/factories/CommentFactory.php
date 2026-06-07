<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Domain\Threads\Models\Thread;
use App\Domain\Comments\Models\Comment;
use App\Models\User;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        $commentOpeners = [
            'I actually tried this and...',
            'From my experience...',
            'This worked differently for me...',
            'I’m not fully convinced because...',
            'One thing to consider is...',
            'I had similar results...',
            'Important note:',
            'Based on research and usage...',
            'This might depend on your situation...',
            'What worked for me was...',
        ];

        return [
            'thread_id' => Thread::query()->inRandomOrder()->value('id'),

            'user_id' => User::query()->inRandomOrder()->value('id'),

            'parent_id' => null,

            'body' => fake()->randomElement($commentOpeners)
                . ' ' .
                fake()->sentence(10),

            'votes_count' => fake()->numberBetween(0, 200),
        ];
    }
}