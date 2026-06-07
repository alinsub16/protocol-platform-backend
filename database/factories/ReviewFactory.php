<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Domain\Reviews\Models\Review;
use App\Domain\Protocols\Models\Protocol;
use App\Models\User;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition(): array
    {
        $reviewFeedback = [
            'This protocol was surprisingly effective.',
            'I noticed improvements after consistent usage.',
            'Not ideal for beginners in my opinion.',
            'The results were mixed but mostly positive.',
            'Very easy to follow and implement daily.',
            'I experienced some minor side effects.',
            'This worked better than expected.',
            'I would definitely recommend this to others.',
            'The structure of the protocol is very practical.',
            'Helpful overall, but requires discipline.',
        ];

        return [
            'protocol_id' => Protocol::query()
                ->inRandomOrder()
                ->value('id'),

            'user_id' => User::query()
                ->inRandomOrder()
                ->value('id'),

            'rating' => fake()->numberBetween(1, 5),

            'feedback' => fake()->optional(80)->randomElement($reviewFeedback),
        ];
    }
}