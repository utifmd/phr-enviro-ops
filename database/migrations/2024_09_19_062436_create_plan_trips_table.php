<?php

use App\Utils\PostFacReportTypeEnum;
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
        Schema::create('plan_trips', function (Blueprint $table) {
            $tripType = collect(\App\Utils\PostWoPlanTripTypeEnum::cases())
                ->map(function ($item) { return $item->value; })->toArray();

            $statusAllowed = collect(PostFacReportTypeEnum::cases())
                ->map(fn($case) => $case->value)->toArray();

            $table->uuid('id')->primary();
            $table->dateTime('start_from')->nullable(false);
            $table->dateTime('finish_to')->nullable(false);
            $table->enum('trip_type', $tripType);

            $table->enum('status', $statusAllowed)
                ->default(PostFacReportTypeEnum::PLAN->value);

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
        Schema::dropIfExists('plan_trips');
    }
};
