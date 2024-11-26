<?php

use App\Utils\ActNameEnum;
use App\Utils\AreaNameEnum;
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
        Schema::create('work_trip_infos', function (Blueprint $table) {
            $areaNameAllowed = collect(AreaNameEnum::cases())
                ->map(fn($case) => $case->value)->toArray();

            $actNameAllowed = collect(ActNameEnum::cases())
                ->map(fn($case) => $case->value)->toArray();

            $table->uuid('id')->primary();
            $table->date('date');
            $table->time('time');
            $table->enum('act_name', $actNameAllowed);
            $table->string('act_process');
            $table->string('act_unit');
            $table->integer('act_value');
            $table->enum('area_name', $areaNameAllowed);
            $table->string('area_loc');

            $table->foreignUuid('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_trip_infos');
    }
};
