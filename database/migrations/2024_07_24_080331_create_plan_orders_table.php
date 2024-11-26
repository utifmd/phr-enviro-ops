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
        Schema::create('plan_orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('status')->nullable(false);
            $table->string('description')->nullable(false);
            $table->integer('req_qty')->nullable(false);
            $table->integer('rem_qty')->nullable(false);
            $table->integer('sch_qty')->nullable(false);
            $table->string('uom')->nullable(false);
            $table->dateTime('required_date')->nullable(false);
            $table->string( 'pick_up_from')->nullable(false);
            $table->string('destination')->nullable(false);
            $table->string('yard')->nullable(false);
            $table->integer('trip')->nullable(false);
            $table->string('wr_number')->nullable(false);
            $table->string('rig_name')->nullable(false);
            $table->string('pic')->nullable(false);
            $table->string('charge')->nullable(false);

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
        Schema::dropIfExists('plan_orders');
    }
};
