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
        Schema::create('work_trips', function (Blueprint $table) {
            $areaNameAllowed = collect(\App\Utils\AreaNameEnum::cases())
                ->map(fn($case) => $case->value)->toArray();

            $actNameAllowed = collect(\App\Utils\ActNameEnum::cases())
                ->map(fn($case) => $case->value)->toArray();

            $typeAllowed = collect(\App\Utils\WorkTripTypeEnum::cases())
                ->map(fn($case) => $case->value)->toArray();

            $statusAllowed = collect(\App\Utils\WorkTripStatusEnum::cases())
                ->map(fn($case) => $case->value)->toArray();

            $table->uuid('id')->primary();
            $table->enum('type', $typeAllowed);
            $table->date('date');
            $table->time('time');
            $table->enum('act_name', $actNameAllowed);
            $table->string('act_process');
            $table->string('act_unit');
            $table->integer('act_value');
            $table->enum('area_name', $areaNameAllowed);
            $table->string('area_loc');
            $table->enum('status', $statusAllowed);

            $table->foreignUuid('work_trip_info_id')
                ->constrained('work_trips')
                ->cascadeOnDelete();

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
        Schema::dropIfExists('work_trips');
    }
};
