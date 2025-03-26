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
        Schema::create('work_trip_details_out', function (Blueprint $table) {
            $rigOrMudPit = collect(\App\Utils\PostFacTypeEnum::cases())->map(fn($case) => $case->value);

            $table->uuid('id')->primary();
            $table->string('from_facility')->nullable(false);
            $table->string('from_pit')->nullable(false);
            $table->string('to_facility')->nullable(false);
            $table->enum('type', $rigOrMudPit->toArray());

            $table->foreignUuid('work_trip_detail_id')
                ->constrained('work_trip_details')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_trip_details_out');
    }
};
