<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_prices', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
			$table->string('drvr_pay_price_chassis', 127);
			$table->string('drvr_pay_price_zone_from', 31);
			$table->string('drvr_pay_price_zone_to', 31);
			$table->string('drvr_pay_price_job_type', 31);
			$table->tinyInteger('drvr_pay_price_one_way');
			$table->double('drvr_pay_price_charge', 10, 2);
			$table->text('drvr_pay_price_notes');
			$table->text('drvr_pay_price_changes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('driver_prices');
    }
}
