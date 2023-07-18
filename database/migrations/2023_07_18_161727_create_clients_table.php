<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('clnt_name', 63);
			$table->string('clnt_address',127);
			$table->string('clnt_city',63);
			$table->string('clnt_province', 31)->nullable();
			$table->string('clnt_postcode', 15)->nullable();
			$table->string('clnt_country', 31)->nullable();
			$table->string('clnt_phone', 31)->nullable();
			$table->string('clnt_contact', 31)->nullable();
            $table->string('clnt_email')->nullable();
			$table->char('clnt_deleted', 1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
