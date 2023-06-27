<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movements', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
			$table->string('mvmt_job_no', 15);
			$table->string('mvmt_cntnr_name', 20);
			$table->string('mvmt_type', 23);
			$table->string('mvmt_ops_code', 31);
			$table->date('mvmt_operation_date');
			$table->time('mvmt_operation_time_since');
			$table->time('mvmt_operation_time_to');
			$table->string('mvmt_cmpny_name', 63);
			$table->string('mvmt_cmpny_address_1', 63);
			$table->string('mvmt_cmpny_address_2', 63);
			$table->string('mvmt_cmpny_address_3', 63);
			$table->string('mvmt_cmpny_city', 31);
			$table->string('mvmt_cmpny_province', 7);
			$table->string('mvmt_cmpny_postcode', 15);
			$table->string('mvmt_cmpny_country', 31);
			$table->string('mvmt_cmpny_zone', 15);
			$table->string('mvmt_cmpny_contact', 63);
			$table->string('mvmt_cmpny_tel', 15);
			$table->string('mvmt_cmpny_email', 127);
			$table->string('mvmt_cmpny_desc', 63);
			$table->string('mvmt_cmpny_dvr_no', 15);
			$table->text('mvmt_remarks');
			$table->text('mvmt_dspcher_notes');
			$table->text('mvmt_dvr_notes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movements');
    }
}
