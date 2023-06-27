<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoteFromDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('note_from_drivers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
			$table->bigInteger('note_cntnr_id');
			$table->bigInteger('note_dvr_id');
			$table->datetime('note_sent_on');
			$table->string('note_info');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('note_from_drivers');
    }
}
