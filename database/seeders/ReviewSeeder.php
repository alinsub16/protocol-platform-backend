<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Domain\Protocols\Models\Protocol;
use App\Domain\Reviews\Models\Review;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach (Protocol::all() as $protocol) {

            $selectedUsers = $users->random(
                min(3, $users->count())
            );

            foreach ($selectedUsers as $user) {

                Review::factory()->create([
                    'protocol_id' => $protocol->id,
                    'user_id' => $user->id,
                ]);
            }
        }
    }
}