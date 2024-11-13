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
        Schema::table('work_trips', function (Blueprint $table) {
            // Hapus constraint foreign key lama
            $table->dropForeign(['post_id']);

            // Tambahkan constraint foreign key baru dengan cascadeOnDelete
            $table->foreign('post_id')
                ->references('id')->on('posts')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_trips', function (Blueprint $table) {
            // Hapus constraint foreign key dengan cascadeOnDelete
            $table->dropForeign(['post_id']);

            // Kembalikan constraint foreign key ke versi tanpa cascadeOnDelete
            $table->foreign('post_id')
                ->references('id')->on('posts');
        });
    }
};
