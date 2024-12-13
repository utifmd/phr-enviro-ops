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
        Schema::dropIfExists('logs');
        Schema::create('logs', function (Blueprint $table) {
            $allowedArea = collect(\App\Utils\AreaNameEnum::cases())
                ->map(fn($case) => $case->value)->toArray();

            $table->uuid('id')->primary();
            $table->string('event')->nullable();
            $table->string('highlight')->nullable(false);
            $table->string('notification_count')->nullable(false);
            $table->enum('area', $allowedArea);
            $table->string('refer_to_table')->nullable();
            $table->foreignUuid('refer_to_table_id')->nullable();
            $table->foreignUuid('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
