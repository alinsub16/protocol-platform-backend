<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Domain\Protocols\Models\Protocol;
use App\Domain\Threads\Models\Thread;

class ThreadSeeder extends Seeder
{
    public function run(): void
    {
        $protocols = Protocol::all();

        foreach ($protocols as $protocol) {

            Thread::factory(rand(1, 3))->create([
                'protocol_id' => $protocol->id,
            ]);
        }
    }
}