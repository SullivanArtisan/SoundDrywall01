<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_charges', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
			$table->string('charge_job_no', 15);
			$table->string('charge_cntnr_name', 20);
			$table->string('charge_name', 63);
			$table->string('charge_desc', 63);
			$table->string('charge_3rd_party_inv_no', 15);
			$table->decimal('charge_quantity', 10, 2);
			$table->decimal('charge_rate', 10, 2);
			$table->decimal('charge_charge', 10, 2);
			$table->boolean('charge_override');
			$table->decimal('charge_fuel_surcharge', 10, 2);
			$table->string('charge_ledger_code', 15);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acc_charges');
    }
}
