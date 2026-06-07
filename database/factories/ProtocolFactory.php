<?php

namespace Database\Factories;

use App\Domain\Protocols\Models\Protocol;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProtocolFactory extends Factory
{
    protected $model = Protocol::class;

    public function definition(): array
    {
        $protocolTitles = [
            'Cold Exposure Therapy',
            'Morning Breathwork Routine',
            'Sleep Optimization Guide',
            'Meditation Reset Protocol',
            'Digital Detox Recovery',
            'Hydration Therapy Plan',
            'Stress Relief Protocol',
            'Intermittent Fasting Guide',
            'Deep Focus Routine',
            'Natural Energy Reset',
        ];

        return [
            'user_id' => User::factory(),

            'title' => fake()->randomElement($protocolTitles),

            'content' => fake()->paragraphs(5, true),

            'tags' => fake()->randomElements([
                'wellness',
                'healing',
                'sleep',
                'focus',
                'recovery',
                'mindfulness',
                'energy',
                'therapy',
                'fitness',
                'mental-health',
            ], rand(2, 5)),

            'avg_rating' => fake()->randomFloat(1, 3, 5),

            'votes_count' => fake()->numberBetween(0, 500),

            'reviews_count' => fake()->numberBetween(0, 120),
        ];
    }
}