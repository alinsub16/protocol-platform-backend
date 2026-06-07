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
            Schema::create('protocols', function (Blueprint $table) {
                $table->id();

                // 👤 Author
                $table->foreignId('user_id')
                    ->constrained()
                    ->cascadeOnDelete();

                // 📝 Content
                $table->string('title');
                $table->longText('content');

                // 🏷 Tags for search/filtering
                $table->json('tags')->nullable();

                // ⭐ Performance + sorting fields
                $table->float('avg_rating')->default(0);
                $table->unsignedInteger('votes_count')->default(0);
                $table->unsignedInteger('reviews_count')->default(0);

                $table->timestamps();

                // 📊 Indexes
                $table->index(['title']);
                $table->index(['avg_rating']);
                $table->index(['votes_count']);
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('protocols');
    }
};
