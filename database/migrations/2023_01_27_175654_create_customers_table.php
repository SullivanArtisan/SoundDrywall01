<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
			$table->bigInteger('cstm_account_no');
			$table->string('cstm_account_name', 127);
			$table->string('cstm_address', 127);
			$table->string('cstm_city', 63);
			$table->string('cstm_province', 31);
			$table->string('cstm_postcode', 31);
			$table->string('cstm_country', 127);
			$table->string('cstm_zone', 31);
			$table->string('cstm_fax', 31);
			$table->string('cstm_account_contact', 127);
			$table->string('cstm_account_tel', 31);
			$table->string('cstm_account_email', 127);
			$table->string('cstm_hst_no', 15);
			$table->string('cstm_contact_name1', 127);
			$table->string('cstm_contact_tel1', 31);
			$table->string('cstm_contact_email1', 127);
			$table->string('cstm_contact_name2', 127);
			$table->string('cstm_contact_tel2', 31);
			$table->string('cstm_contact_email2', 127);
			$table->string('cstm_contact_name3', 127);
			$table->string('cstm_contact_tel3', 31);
			$table->string('cstm_contact_email3', 127);
			$table->string('cstm_invoice_name', 127);
			$table->string('cstm_invoice_addr', 127);
			$table->string('cstm_invoice_city', 63);
			$table->string('cstm_invoice_province', 31);
			$table->string('cstm_invoice_postcode', 31);
			$table->string('cstm_invoice_country', 127);
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
