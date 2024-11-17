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
        Schema::create('trip_plans', function (Blueprint $table) {
            $tripType = collect(\App\Utils\PlanTripTypeEnum::cases())
                ->map(function ($item) { return $item->value; })
                ->toArray();

            $table->uuid('id')->primary();
            $table->dateTime('start_from')->nullable(false);
            $table->dateTime('finish_to')->nullable(false);
            $table->enum('trip_type', $tripType);
            $table->dateTime('actual_start')->nullable(false);
            $table->dateTime('actual_finish')->nullable(false);
            $table->integer('km_start')->nullable();
            $table->integer('km_end')->nullable();
            $table->integer('km_actual')->nullable();
            $table->integer('km_contract')->nullable();
            $table->dateTime('start_working_date')->nullable();
            $table->dateTime('end_working_date')->nullable();
            $table->integer('total_standby_hour')->nullable();
            $table->integer('total_working_hour')->nullable();
            $table->string('job_ticket_number')->nullable();

            $table->timestamps();
            $table->foreignUuid('post_id')
                ->constrained('posts')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_plans');
    }
};
