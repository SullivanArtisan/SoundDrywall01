<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('pvdr_name', 63);
			$table->string('pvdr_address',127);
			$table->string('pvdr_city',63);
			$table->string('pvdr_province', 31)->nullable();
			$table->string('pvdr_postcode', 15)->nullable();
			$table->string('pvdr_country', 31)->nullable();
			$table->string('pvdr_phone', 31)->nullable();
			$table->string('pvdr_contact', 31)->nullable();
            $table->string('pvdr_email')->nullable();
			$table->char('pvdr_deleted', 1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('providers');
    }
}
