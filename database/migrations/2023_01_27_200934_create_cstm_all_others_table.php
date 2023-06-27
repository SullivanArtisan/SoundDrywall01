<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCstmAllOthersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cstm_all_others', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
			$table->bigInteger('cstm_account_no');
			$table->text('cstm_other_notes');
			$table->text('cstm_other_changes');
			$table->text('cstm_other_docket_msgs');
			$table->text('cstm_other_control_msgs');
			$table->text('cstm_other_additional_info');
			$table->text('cstm_other_special_instructions');
			$table->text('cstm_other_histories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cstm_all_others');
    }
}
