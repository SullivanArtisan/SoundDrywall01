<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
			$table->bigInteger('bk_cstm_account_no');
			$table->string('bk_cstm_account_name', 127);
			$table->string('bk_job_type', 15);
			$table->boolean('bk_one_way');
			$table->string('bk_ops_code', 31);
			$table->integer('bk_containers_no');
			$table->string('bk_vessel', 63);
			$table->string('bk_voyage', 63);
			$table->integer('bk_imo_no');
			$table->string('bk_ssl_name', 23);
			$table->string('bk_terminal_name', 127);
			$table->integer('bk_gate');
			$table->date('bk_vessel_eta');
			$table->date('bk_terminal_lfd');
			$table->date('bk_ssl_lfd');
			$table->string('bk_pickup_type', 23);
			$table->string('bk_pickup_remarks', 127);
			$table->string('bk_delivery_type', 23);
			$table->string('bk_delivery_remarks', 127);
			$table->string('bk_booker_name');
			$table->string('bk_booker_tel', 15);
			$table->string('bk_booker_email', 127);
			$table->string('bk_cstm_order_no', 15);
			$table->integer('bk_booking_no');
			$table->string('bk_goods_desc', 127);
			$table->double('bk_cargo_weight', 10, 2);
			$table->tinyInteger('bk_weight_unit');
			$table->integer('bk_invoice_group_no');
			$table->boolean('bk_taxable');
			$table->string('bk_internal_notes');
			$table->string('bk_driver_notes');
			$table->string('bk_status', 23);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
