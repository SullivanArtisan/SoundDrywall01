<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCstmDispatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cstm_dispatches', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
			$table->bigInteger('cstm_account_no');
			$table->boolean('cstm_dspch_force_ref');
			$table->boolean('cstm_dspch_email_pod');
			$table->boolean('cstm_dspch_email_pickup');
			$table->string('cstm_dspch_pod_email1', 127);
			$table->string('cstm_dspch_pod_email2', 127);
			$table->string('cstm_dspch_pod_email3', 127);
			$table->boolean('cstm_dspch_priority');
			$table->string('cstm_dspch_group1', 15);
			$table->string('cstm_dspch_group2', 15);
			$table->string('cstm_dspch_group3', 15);
			$table->string('cstm_dspch_group4', 15);
			$table->string('cstm_dspch_group5', 15);
			$table->boolean('cstm_dspch_one_container_per_job');
			$table->text('cstm_dspch_import_driver_notes');
			$table->text('cstm_dspch_export_driver_notes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cstm_dispatches');
    }
}
