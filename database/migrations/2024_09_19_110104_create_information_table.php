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
        Schema::create('information', function (Blueprint $table) {
            $vehicleTypes = collect(\App\Utils\InformationVehicleTypeEnum::cases())
                ->map(function ($item) {return $item->value;})->toArray();

            $shifts = collect(\App\Utils\InformationShiftEnum::cases())
                ->map(function ($item) {return $item->value;})->toArray();

            $areas = collect(\App\Utils\InformationAreaEnum::cases())
                ->map(function ($item) {return $item->value;})->toArray();

            $table->uuid('id')->primary();
            $table->string('operator')->nullable();
            $table->enum('vehicle_type', $vehicleTypes);
            $table->string('police_number')->nullable();
            $table->string('driver_name')->nullable();
            $table->dateTime('start_plan')->nullable();
            $table->dateTime('end_plan')->nullable();
            $table->enum('shift', $shifts);
            $table->enum('area', $areas);

            $table->foreignUuid('post_id')
                ->constrained('posts')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('information');
    }
};
