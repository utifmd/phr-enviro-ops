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
        Schema::create('work_trip_out_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('transporter')->nullable(false);
            $table->string('driver')->nullable(false);
            $table->string('police_number')->nullable(false);
            $table->time('time_in')->nullable(false);
            $table->time('time_out')->nullable(false);
            $table->string('from_pit')->nullable(false);
            $table->string('from_facility')->nullable(false);
            $table->string('to_facility')->nullable(false);
            $rigOrMudPit = collect(\App\Utils\WorkTripDetailTypeEnum::cases())->map(fn($case) => $case->value);
            $table->enum('type', $rigOrMudPit->toArray());
            $table->integer('tds')->nullable();
            $table->integer('volume')->nullable();
            $table->integer('load')->nullable(false);
            $areas = collect(\App\Utils\AreaNameEnum::cases())->map(fn($case) => $case->value);
            $table->enum('area_name', $areas->toArray());
            $table->string('remarks')->nullable();

            $table->foreignUuid('post_id')
                ->constrained('posts')
                ->cascadeOnDelete();

            $table->foreignUuid('user_id')->constrained('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_trip_out_details');
    }
};
