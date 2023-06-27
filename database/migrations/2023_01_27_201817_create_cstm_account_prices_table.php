<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCstmAccountPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cstm_account_prices', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
			$table->bigInteger('cstm_account_no');
			$table->string('cstm_account_chassis', 127);
			$table->string('cstm_account_from', 31);
			$table->string('cstm_account_to', 31);
			$table->double('cstm_account_charge', 10, 2);
			$table->string('cstm_account_job_type', 31);
			$table->string('cstm_account_one_way', 7);
			$table->string('cstm_account_mt_return', 127);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cstm_account_prices');
    }
}
