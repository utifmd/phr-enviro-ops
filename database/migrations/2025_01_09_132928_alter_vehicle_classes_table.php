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
        Schema::table('vehicle_classes', function (Blueprint $table) {
            $allowed = collect(\App\Utils\VehicleClassEnum::cases())->map(fn ($case) => $case->value)->toArray();
            $table->enum('name', $allowed)->change();
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
