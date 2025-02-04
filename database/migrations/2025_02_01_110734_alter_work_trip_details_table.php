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
        Schema::table('work_trip_details', function (Blueprint $table) {
            $statusAllowed = collect(\App\Utils\WorkTripStatusEnum::cases())
                ->map(fn($case) => $case->value)->toArray();

            $table->enum('status', $statusAllowed)
                ->default(\App\Utils\WorkTripStatusEnum::PENDING->value);
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
