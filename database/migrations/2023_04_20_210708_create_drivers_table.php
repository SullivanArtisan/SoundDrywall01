<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
			$table->string('dvr_pwr_unit_no_1', 15);
			$table->string('dvr_pwr_unit_no_2', 15);
			$table->string('dvr_name', 47);
			$table->string('dvr_address', 63);
			$table->string('dvr_city', 31);
			$table->string('dvr_province', 7);
			$table->string('dvr_postcode', 15);
			$table->string('dvr_country', 31);
			$table->string('dvr_cell_phone', 15);
			$table->string('dvr_home_phone', 15);
			$table->string('dvr_other_phone', 15);
			$table->string('dvr_email', 127);
			$table->string('dvr_emergency_contact', 63);
			$table->string('dvr_emergency_phone', 15);
			$table->string('dvr_ops_code', 31);
			$table->string('dvr_dayornight', 1);
			$table->string('dvr_fuel_card_no', 23);
			$table->string('dvr_mobile_data_type', 15);
			$table->string('dvr_mobile_call_sign', 15);
			$table->string('dvr_mobile_phone_no', 15);
			$table->boolean('dvr_mobile_out_action');
			$table->string('dvr_altern_data_type', 15);
			$table->string('dvr_altern_call_sign', 15);
			$table->string('dvr_altern_phone_no', 15);
			$table->boolean('dvr_altern_out_action');
			$table->string('dvr_local_office', 15);
			$table->date('dvr_start_date');
			$table->date('dvr_termination_date');
			$table->date('dvr_return_date');
			$table->boolean('dvr_unavailable');
			$table->string('dvr_unavailability_comments', 127);
			$table->string('dvr_paye_no', 31);
			$table->string('dvr_type', 15);
			$table->boolean('dvr_harbourlink_fuel_card');
			$table->date('dvr_birth_date');
			$table->date('dvr_license_exp_date');
			$table->string('dvr_license_no', 15);
			$table->string('dvr_license_province', 7);
			$table->date('dvr_abstract_exp_date');
			$table->date('dvr_tdg_exp_date');
			$table->boolean('dvr_drug_alcohol_test');
			$table->boolean('dvr_road_test');
			$table->boolean('dvr_port_pass');
			$table->string('dvr_port_pass_no', 15);
			$table->date('dvr_port_pass_exp_date');
			$table->boolean('dvr_twic_card');
			$table->string('dvr_twic_card_no', 15);
			$table->date('dvr_twic_card_exp_date');
			$table->boolean('dvr_fast_pass');
			$table->string('dvr_fast_pass_no', 15);
			$table->date('dvr_fast_pass_exp_date');
			$table->boolean('dvr_tls_license');
			$table->date('dvr_tls_license_exp_date');
			$table->boolean('dvr_security');
			$table->string('dvr_sin', 15);
			$table->boolean('dvr_exclude_from_pay_run');
			$table->decimal('dvr_pay_set_amount', 8, 2);
			$table->boolean('dvr_email_invoices');
			$table->boolean('dvr_include_in_print_run');
			$table->string('dvr_paye_type', 31);
			$table->decimal('dvr_hourly_rate', 8, 2);
			$table->decimal('dvr_safe_driving_premium', 8, 2);
			$table->decimal('dvr_clean_nsc_premium', 8, 2);
			$table->decimal('dvr_ot_rate', 8, 2);
			$table->decimal('dvr_stat_holiday_rate', 8, 2);
			$table->decimal('dvr_max_standard_hous_perweek', 4, 2);
			$table->decimal('dvr_milage_rate', 8, 2);
			$table->decimal('dvr_safe_driving_premium2', 8, 2);
			$table->decimal('dvr_clean_nsc_premium2', 8, 2);
			$table->string('dvr_vendor_code', 31);
			$table->string('dvr_wcb_no', 31);
			$table->string('dvr_ledger_code', 31);
			$table->text('dvr_subhauler_address');
			$table->boolean('dvr_add_tax_to_pay_sheet');
			$table->text('dvr_notes');
			$table->text('dvr_change_log');
			$table->text('dvr_history');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drivers');
    }
}
