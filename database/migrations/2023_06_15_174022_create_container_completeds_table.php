<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContainerCompletedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('container_completeds', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
			$table->bigInteger('ccntnr_id');
			$table->bigInteger('ccntnr_dvr_id');
			$table->datetime('ccntnr_finished_on');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('container_completeds');
    }
}
