<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('missions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('max_score');
            $table->integer('id_vice_rector');
            $table->string('text');
            $table->integer('max_workers');
            $table->datetime('date_start');
            $table->datetime('date_start_application');
            $table->datetime('date_end_application');
            $table->datetime('date_start_mission');
            $table->datetime('date_end_mission');
            $table->datetime('date_start_attestation');
            $table->datetime('date_end_attestation');
            $table->datetime('date_end');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('missions');
    }
};
