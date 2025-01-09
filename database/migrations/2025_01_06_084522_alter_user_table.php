<?php

use App\Utils\UserRoleEnum;
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
        Schema::table('users', function (Blueprint $table) {
            $rolesAllowed = collect(UserRoleEnum::cases())
                ->map(fn ($case) => $case->value)
                ->toArray();

            $table->enum('role', $rolesAllowed)->change();
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
