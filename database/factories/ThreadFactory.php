<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Domain\Threads\Models\Thread;
use App\Domain\Protocols\Models\Protocol;
use App\Models\User;

class ThreadFactory extends Factory
{
    protected $model = Thread::class;

    public function definition(): array
    {
        $threadTitles = [
            'Has anyone tried this protocol long term?',
            'Unexpected results after 7 days',
            'Is this safe for beginners?',
            'My experience using this method',
            'Struggling with consistency — advice?',
            'Does this actually improve sleep quality?',
            'Side effects after implementation',
            'Best time of day to follow this?',
            'Comparison with other protocols',
            'Real results after 30 days',
        ];

        return [
            'protocol_id' => Protocol::query()->inRandomOrder()->value('id'),
            'user_id' => User::query()->inRandomOrder()->value('id'),

            'title' => fake()->randomElement($threadTitles),

            'body' => fake()->paragraphs(3, true),

            'tags' => json_encode(fake()->words(3)),

            'votes_count' => fake()->numberBetween(0, 500),
            'comments_count' => fake()->numberBetween(0, 100),
        ];
    }
}