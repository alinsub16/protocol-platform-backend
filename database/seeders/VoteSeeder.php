<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Domain\Votes\Models\Vote;
use App\Domain\Threads\Models\Thread;
use App\Domain\Comments\Models\Comment;

class VoteSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        // Thread votes
        foreach (Thread::all() as $thread) {

            $selectedUsers = $users->random(
                min(5, $users->count())
            );

            foreach ($selectedUsers as $user) {

                Vote::firstOrCreate([
                    'user_id' => $user->id,
                    'votable_id' => $thread->id,
                    'votable_type' => Thread::class,
                ], [
                    'value' => fake()->randomElement([1, -1]),
                ]);
            }
        }

        // Comment votes
        foreach (Comment::all() as $comment) {

            $selectedUsers = $users->random(
                min(3, $users->count())
            );

            foreach ($selectedUsers as $user) {

                Vote::firstOrCreate([
                    'user_id' => $user->id,
                    'votable_id' => $comment->id,
                    'votable_type' => Comment::class,
                ], [
                    'value' => fake()->randomElement([1, -1]),
                ]);
            }
        }
    }
}