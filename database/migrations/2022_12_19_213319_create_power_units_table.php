<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePowerUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('power_units', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
			$table->string('unit_id', 15);
			$table->integer('year');
			$table->string('make', 31);
			$table->string('color', 31)->nullable();
			$table->string('seniority', 15)->nullable();
			$table->string('plate_number', 15)->unique();
			$table->string('vin', 31)->unique();
            $table->timestamp('insurance_expiry_date')->nullable();
			$table->integer('max_licensed_weight')->nullable();
			$table->integer('cargo_weight')->nullable();
            $table->timestamp('mvi_expiry_date')->nullable();
            $table->integer('current_driver')->nullable();
            $table->integer('last_driver')->nullable();
            $table->string('current_location', 63)->nullable();
			$table->string('ops_code', 31)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('power_units');
    }
}
