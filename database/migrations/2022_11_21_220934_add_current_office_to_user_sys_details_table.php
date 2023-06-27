<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCurrentOfficeToUserSysDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_sys_details', function (Blueprint $table) {
			$table->timestamp('last_login');
			$table->string('current_office', 15);
			$table->string('default_office', 15);
			$table->boolean('can_change_office');
			$table->boolean('currently_logged_in');
			$table->boolean('startup_caps_lock_on');
			$table->boolean('startup_num_lock_on');
			$table->boolean('startup_insert_on');
			$table->string('ops_code', 31);
			$table->boolean('show_mobile_data_messages');
			$table->boolean('show_internet_bookings');
			$table->boolean('show_incoming_control_emails');
			$table->string('picture_file', 255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_sys_details', function (Blueprint $table) {
            $table->dropColumn('last_login');
            $table->dropColumn('current_office');
            $table->dropColumn('default_office');
            $table->dropColumn('can_change_office');
            $table->dropColumn('currently_logged_in');
            $table->dropColumn('startup_caps_lock_on');
            $table->dropColumn('startup_num_lock_on');
            $table->dropColumn('startup_insert_on');
            $table->dropColumn('ops_code');
            $table->dropColumn('show_mobile_data_messages');
            $table->dropColumn('show_internet_bookings');
            $table->dropColumn('show_incoming_control_emails');
            $table->dropColumn('picture_file');
        });
    }
}
