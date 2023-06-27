<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContainerSurchargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('container_surcharges', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
			$table->bigInteger('cntnrsurchrg_cntnr_id');
			$table->string('cntnrsurchrg_type', 63);
			$table->string('cntnrsurchrg_desc', 127);
			$table->string('cntnrsurchrg_ledger_code', 15);
			$table->string('cntnrsurchrg_3rd_pty_inv_no', 31);
			$table->decimal('cntnrsurchrg_quantity', 8, 2);
			$table->decimal('cntnrsurchrg_rate', 8, 2);
			$table->decimal('cntnrsurchrg_charge', 8, 2);
			$table->char('cntnrsurchrg_override', 1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('container_surcharges');
    }
}
