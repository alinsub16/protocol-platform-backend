<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
        {
            Schema::create('votes', function (Blueprint $table) {
                $table->id();

                // 👤 User who voted
                $table->foreignId('user_id')
                    ->constrained()
                    ->cascadeOnDelete();

                // 🧠 Polymorphic target (Thread OR Comment)
                $table->morphs('votable'); 
                // creates: votable_id + votable_type

                // 👍 or 👎
                $table->tinyInteger('value'); 
                // +1 = upvote, -1 = downvote

                $table->timestamps();

                // 🚨 IMPORTANT: one vote per user per item
                $table->unique(['user_id', 'votable_id', 'votable_type']);
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
