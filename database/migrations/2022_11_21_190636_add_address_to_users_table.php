<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
			$table->string('address',127);
        });
		
        Schema::table('users', function (Blueprint $table) {
			$table->string('town',127);
        });
		
        Schema::table('users', function (Blueprint $table) {
			$table->string('county', 127);
        });
		
        Schema::table('users', function (Blueprint $table) {
			$table->string('postcode', 31);
        });
		
        Schema::table('users', function (Blueprint $table) {
			$table->string('country', 127);
        });
		
        Schema::table('users', function (Blueprint $table) {
			$table->string('work_phone', 63);
        });
		
        Schema::table('users', function (Blueprint $table) {
			$table->string('home_phone', 63);
        });
		
        Schema::table('users', function (Blueprint $table) {
			$table->string('mobile_phone', 63);
        });
		
        Schema::table('users', function (Blueprint $table) {
			$table->string('email2', 127);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('address');
        });
		
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('town');
        });
		
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('county');
        });
		
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('postcode');
        });
		
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('country');
        });
		
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('work_phone');
        });
		
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('home_phone');
        });
		
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('mobile_phone');
        });
		
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('email2');
        });
    }
}
