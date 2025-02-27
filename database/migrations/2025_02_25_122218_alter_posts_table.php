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
        Schema::table('posts', static function (Blueprint $table) {

            $postStatus = collect(\App\Utils\PostStatusEnum::cases())
                ->map(fn ($item) => $item->value)->toArray();

            $table->enum('status', $postStatus)->default(\App\Utils\PostStatusEnum::OPEN->value);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
