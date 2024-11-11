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
        Schema::table('information', function (Blueprint $table) {
            $vehicleTypes = collect(\App\Utils\VehicleTypeEnum::cases())
                ->map(fn ($item) => $item->value)->toArray();

            $table->enum('vehicle_type', $vehicleTypes)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('information', function (Blueprint $table) {
            $vehicleTypes = collect(\App\Utils\InformationVehicleTypeEnum::cases())
                ->map(fn ($item) => $item->value)->toArray();

            $table->enum('vehicle_type', $vehicleTypes)->change();
        });
    }
};
