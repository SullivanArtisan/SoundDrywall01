<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
			$table->string('cmpny_name', 63);
			$table->string('cmpny_address', 63);
			$table->string('cmpny_city', 31);
			$table->string('cmpny_province', 7);
			$table->string('cmpny_postcode', 15);
			$table->string('cmpny_country', 31);
			$table->string('cmpny_zone', 15);
			$table->string('cmpny_contact', 63);
			$table->string('cmpny_tel', 15);
			$table->string('cmpny_email', 127);
			$table->string('cmpny_chassis_capability', 15);
			$table->string('cmpny_driver_notes', 15);
			$table->string('cmpny_logs', 47);
			$table->string('cmpny_deleted', 1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
