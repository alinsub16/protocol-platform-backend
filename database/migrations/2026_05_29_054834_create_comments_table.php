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
            Schema::create('comments', function (Blueprint $table) {
                $table->id();

                // 🔗 Parent relationship (thread)
                $table->foreignId('thread_id')
                    ->constrained()
                    ->cascadeOnDelete();

                // 👤 Author
                $table->foreignId('user_id')
                    ->constrained()
                    ->cascadeOnDelete();

                // 🧠 Nested comments (SELF-REFERENCE)
                $table->foreignId('parent_id')
                    ->nullable()
                    ->constrained('comments')
                    ->cascadeOnDelete();

                // 📝 Content
                $table->longText('body');

                // ⚡ Performance
                $table->unsignedInteger('votes_count')->default(0);

                $table->timestamps();

                // 📊 Indexes (VERY IMPORTANT for nested performance)
                $table->index(['thread_id']);
                $table->index(['parent_id']);
                $table->index(['user_id']);
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
