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
            $vehicleTypes = collect(\App\Utils\PostWoInfoVehicleTypeEnum::cases())
                ->map(fn ($item) => $item->value)->toArray();

            $shifts = collect(\App\Utils\PostWoInfoShiftEnum::cases())
                ->map(fn ($item) => $item->value)->toArray();

            $areas = collect(\App\Utils\PostWoInfoAreaEnum::cases())
                ->map(fn ($item) => $item->value)->toArray();

            $table->uuid('id')->primary();
            $table->enum('vehicle_type', $vehicleTypes);
            $table->dateTime('start_plan')->nullable();
            $table->dateTime('end_plan')->nullable();
            $table->enum('shift', $shifts);
            $table->enum('area', $areas);

            $table->foreignUuid('operator_id')
                ->constrained('operators');
            $table->foreignUuid('vehicle_id')
                ->constrained('vehicles');
            $table->foreignUuid('crew_id')
                ->constrained('crews');
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
