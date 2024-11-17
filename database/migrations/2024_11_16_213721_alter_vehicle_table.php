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
        Schema::table('vehicles', function (Blueprint $table) {
            //$table->dropColumn('type', 'class');
            $table->addColumn('string','vehicle_class_id')->nullable();

            $table->foreign('vehicle_class_id')
                ->references('id')->on('vehicle_classes')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->addColumn('string','class');
            $table->addColumn('string','type');

            $table->dropforeign('vehicle_class_id');
        });
    }
};
