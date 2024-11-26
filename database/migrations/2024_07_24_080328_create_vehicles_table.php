<?php

use App\Utils\VehicleClassEnum;
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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $allowedType = collect(VehicleClassEnum::cases())
                ->map(function ($case) {return $case->value;})
                ->toArray();

            $table->string('plat')->nullable(false)->unique();
            $table->enum('class', $allowedType);
            $table->string('type');
            $table->string('vendor');

            $table->foreignId('operator_id')
                ->nullable(false)
                ->constrained('operators');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
