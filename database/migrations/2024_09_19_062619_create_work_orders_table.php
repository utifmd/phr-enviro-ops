<?php

use App\Utils\PostWoShiftEnum;
use App\Utils\PostWoStatusEnum;
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
        Schema::create('work_orders', function (Blueprint $table) {

            $shiftAllowed = collect(PostWoShiftEnum::cases())
                ->map(function ($case) { return $case->value; })
                ->toArray();
            $statusAllowed = collect(PostWoStatusEnum::cases())
                ->map(function ($case) { return $case->value; })
                ->toArray();

            $table->uuid('id')->primary()->unique();
            $table->enum('shift', $shiftAllowed);
            $table->boolean('is_rig');
            $table->enum('status', $statusAllowed);
            $table->string('ids_wellname');
            $table->timestamps();

            $table->foreignUuid('post_id')
                ->constrained()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_orders');
    }
};
