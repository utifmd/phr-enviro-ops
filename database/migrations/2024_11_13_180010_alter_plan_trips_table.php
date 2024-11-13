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
        Schema::table('plan_trips', function (Blueprint $table) {
            $table->dropColumn(
                'actual_start', 'actual_finish', 'km_start',
                'km_end', 'km_actual', 'km_contract', 'start_working_date',
                'end_working_date', 'total_standby_hour',
                'total_working_hour', 'job_ticket_number'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plan_trips', function (Blueprint $table) {
            $table->addColumn('dateTime', 'actual_start');
            $table->addColumn('dateTime', 'actual_finish');
            $table->addColumn('integer', 'km_start');
            $table->addColumn('integer', 'km_end');
            $table->addColumn('integer', 'km_actual');
            $table->addColumn('integer', 'km_contract');
            $table->addColumn('dateTime', 'start_working_date');
            $table->addColumn('dateTime', 'end_working_date');
            $table->addColumn('integer', 'total_standby_hour');
            $table->addColumn('integer', 'total_working_hour');
            $table->addColumn('string', 'job_ticket_number');
        });
    }
};
