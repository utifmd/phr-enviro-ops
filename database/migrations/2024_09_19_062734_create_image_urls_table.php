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
        Schema::create('image_urls', function (Blueprint $table) {
            $table->id();
            $table->string('url')->nullable(false);
            $table->string('path')->nullable(false);
            $table->timestamps();
            $table->foreignUuid('post_id')
                ->constrained('posts')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('image_urls');
    }
};
