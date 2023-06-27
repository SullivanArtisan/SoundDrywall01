<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCstmInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cstm_invoices', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
			$table->bigInteger('cstm_account_no');
			$table->string('cstm_invoice_period', 31);
			$table->string('cstm_invoice_layout', 31);
			$table->string('cstm_invoice_style', 31);
			$table->string('cstm_invoice_pdf_style', 31);
			$table->boolean('cstm_invoice_requires_pod');
			$table->boolean('cstm_invoice_by_group_only');
			$table->boolean('cstm_invoice_tax');
			$table->boolean('cstm_invoice_no_bridge_toll');
			$table->integer('cstm_invoice_attachments_needed');
			$table->string('cstm_invoice_local_office', 31);
			$table->integer('cstm_invoice_payment_terms');
			$table->string('cstm_invoice_account_status', 15);
			$table->boolean('cstm_invoice_email_in_pdf_fmt');
			$table->boolean('cstm_invoice_include_in_print_run');
			$table->string('cstm_invoice_export_job_fmt', 15);
			$table->string('cstm_invoice_email_addr1', 127);
			$table->string('cstm_invoice_email_addr2', 127);
			$table->string('cstm_invoice_email_addr3', 127);
			$table->string('cstm_invoice_email_addr4', 127);
			$table->string('cstm_invoice_email_addr5', 127);
			$table->string('cstm_invoice_email_addr6', 127);
			$table->date('cstm_invoice_account_opened');
			$table->boolean('cstm_invoice_deleted');
			$table->string('cstm_invoice_currency', 7);
			$table->double('cstm_invoice_credit_limit', 15, 8);
			$table->boolean('cstm_invoice_local_fuel_if_surcharged');
			$table->double('cstm_invoice_local_fuel_surcharged', 15, 8);
			$table->boolean('cstm_invoice_hwy_fuel_if_surcharged');
			$table->double('cstm_invoice_hwy_fuel_surcharged', 15, 8);
			$table->text('cstm_invoice_additional_email_addr');
			$table->text('cstm_invoice_fsc_email_addr');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cstm_invoices');
    }
}
