<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlackoutModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blackout_models', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('queue_model_id')->constrained('queue_models')->onDelete('cascade');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blackout_models');
    }
}
