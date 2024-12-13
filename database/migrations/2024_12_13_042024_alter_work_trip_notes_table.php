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
        Schema::dropIfExists('work_trip_notes');

        Schema::create('work_trip_notes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('message');

            $table->foreignUuid('post_id')
                ->references('id')
                ->on('posts')
                ->cascadeOnDelete();

            $table->foreignUuid('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_trip_notes');
    }
};
