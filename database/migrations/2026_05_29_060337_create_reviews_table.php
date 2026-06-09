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
            Schema::create('reviews', function (Blueprint $table) {
                $table->id();

                //  Protocol being reviewed
                $table->foreignId('protocol_id')
                    ->constrained()
                    ->cascadeOnDelete();

                //  Reviewer
                $table->foreignId('user_id')
                    ->constrained()
                    ->cascadeOnDelete();

                //  Rating (1–5)
                $table->unsignedTinyInteger('rating');

                //  Optional feedback
                $table->text('feedback')->nullable();

                $table->timestamps();

                //  One review per user per protocol
                // $table->unique(['protocol_id', 'user_id']);

                //  Indexes
                $table->index(['rating']);
                $table->index(['created_at']);
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
