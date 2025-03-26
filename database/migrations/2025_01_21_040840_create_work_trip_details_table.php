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
        Schema::create('work_trip_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('transporter')->nullable(false);
            $table->string('driver')->nullable(false);
            $table->string('police_number')->nullable(false);
            $table->time('time_in')->nullable(false);
            $allowedType = collect(\App\Utils\ActNameEnum::cases())->map(fn($case) => $case->value);
            $table->enum('type', $allowedType->toArray());
            $table->integer('load')->nullable(false);
            $table->integer('volume')->nullable();
            $table->integer('tds')->nullable();
            $areas = collect(\App\Utils\AreaNameEnum::cases())->map(fn($case) => $case->value);
            $table->enum('area_name', $areas->toArray());
            $table->time('time_out')->nullable(false);
            $table->string('remarks')->nullable();
            $statusAllowed = collect(\App\Utils\PostFacReportStatusEnum::cases())->map(fn($case) => $case->value)->toArray();
            $table->enum('status', $statusAllowed)->default(\App\Utils\PostFacReportStatusEnum::PENDING->value);

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
        Schema::dropIfExists('work_trip_details');
    }
};
