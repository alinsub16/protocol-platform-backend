<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Domain\Protocols\Models\Protocol;

class ProtocolSeeder extends Seeder
{
    public function run(): void
    {
        Protocol::factory(12)->create();
    }
}