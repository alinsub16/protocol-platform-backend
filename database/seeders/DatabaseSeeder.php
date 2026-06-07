<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(10)->create();

        $this->call([
            ProtocolSeeder::class,
            ThreadSeeder::class,
            CommentSeeder::class,
            ReviewSeeder::class,
            VoteSeeder::class,
        ]);
    }
}