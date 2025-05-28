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
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('operator_id', 'company_id');
        });
        Schema::table('posts', function (Blueprint $table) {
            $table->renameColumn('operator_id', 'company_id');
        });
        Schema::table('vehicles', function (Blueprint $table) {
            $table->renameColumn('operator_id', 'company_id');
        });
        Schema::table('man_powers', function (Blueprint $table) {
            $table->renameColumn('operator_id', 'company_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('company_id', 'operator_id');
        });
        Schema::table('posts', function (Blueprint $table) {
            $table->renameColumn('company_id', 'operator_id');
        });
        Schema::table('vehicles', function (Blueprint $table) {
            $table->renameColumn('company_id', 'operator_id');
        });
        Schema::table('man_power', function (Blueprint $table) {
            $table->renameColumn('company_id', 'operator_id');
        });
    }
};
