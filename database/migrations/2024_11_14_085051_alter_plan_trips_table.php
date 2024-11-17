<?php

use App\Utils\WorkTripTypeEnum;
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
        Schema::table('plan_trips', function (Blueprint $table) {
            $table->addColumn('string', 'status')
                ->nullable(false)
                ->default(WorkTripTypeEnum::PLAN->value);

            $table->enum('status', collect(WorkTripTypeEnum::cases())->map(fn ($case) => $case->value)->toArray())
                ->default(WorkTripTypeEnum::PLAN->value)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plan_trips', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
