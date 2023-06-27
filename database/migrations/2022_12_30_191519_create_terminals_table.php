<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTerminalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terminals', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
			$table->string('trmnl_name', 31);
			$table->string('trmnl_address', 127);
			$table->string('trmnl_city', 127);
			$table->string('trmnl_province', 127);
			$table->string('trmnl_postcode', 31);
			$table->string('trmnl_country', 127);
			$table->string('trmnl_area', 31);
			$table->string('trmnl_contact', 127);
			$table->string('trmnl_tel', 63);
			$table->string('trmnl_fax', 63);
			$table->string('trmnl_email', 127);
			$table->time('trmnl_cutoff_time');
			$table->boolean('trmnl_no_sig_required');
			$table->integer('trmnl_geofence_facility');
			$table->double('trmnl_latitude', 15, 8);
			$table->double('trmnl_longitude', 15, 8);
			$table->double('trmnl_arrived_latitude', 15, 8);
			$table->double('trmnl_arrived_longitude', 15, 8);
			$table->integer('trmnl_arrived_radius');
			$table->double('trmnl_halo_center_latitude', 15, 8);
			$table->double('trmnl_halo_center_longitude', 15, 8);
			$table->integer('trmnl_halo_center_radius');
			$table->double('trmnl_ingate_latitude', 15, 8);
			$table->double('trmnl_ingate_longitude', 15, 8);
			$table->integer('trmnl_ingate_radius');
			$table->double('trmnl_outgate1_latitude', 15, 8);
			$table->double('trmnl_outgate1_longitude', 15, 8);
			$table->integer('trmnl_outgate1_radius');
			$table->double('trmnl_outgate2_latitude', 15, 8);
			$table->double('trmnl_outgate2_longitude', 15, 8);
			$table->integer('trmnl_outgate2_radius');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('terminals');
    }
}
