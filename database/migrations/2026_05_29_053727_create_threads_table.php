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
            Schema::create('threads', function (Blueprint $table) {
                $table->id();

                // 🔗 Relationships
                $table->foreignId('protocol_id')
                    ->constrained()
                    ->cascadeOnDelete();

                $table->foreignId('user_id')
                    ->constrained()
                    ->cascadeOnDelete();

                // 📝 Content
                $table->string('title');
                $table->longText('body');

                // 🏷 Optional tags (for filtering + Typesense)
                $table->json('tags')->nullable();

                // ⚡ Performance counters (VERY IMPORTANT)
                $table->unsignedInteger('votes_count')->default(0);
                $table->unsignedInteger('comments_count')->default(0);

                // ⏱ timestamps
                $table->timestamps();

                // 📊 Indexes (important for speed + sorting)
                $table->index(['protocol_id']);
                $table->index(['user_id']);
                $table->index(['votes_count']);
                $table->index(['created_at']);
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('threads');
    }
};
