<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Domain\Votes\Models\Vote;
use App\Domain\Threads\Models\Thread;
use App\Domain\Comments\Models\Comment;
use App\Models\User;

class VoteFactory extends Factory
{
    protected $model = Vote::class;

    public function definition(): array
    {
        $votableType = fake()->randomElement([
            Thread::class,
            Comment::class,
        ]);

        return [
            'user_id' => User::query()->inRandomOrder()->value('id'),

            'votable_type' => $votableType,

            'votable_id' => $votableType::query()
                ->inRandomOrder()
                ->value('id'),

            'value' => fake()->randomElement([1, -1]),
        ];
    }
}