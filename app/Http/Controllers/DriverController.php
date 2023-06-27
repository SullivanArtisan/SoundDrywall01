<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Driver;
use App\Helper\MyHelper;

class DriverController extends Controller
{
    public function store(Request $request)
    {
		$validated = $request->validate([
			'dvr_pwr_unit_no_1' => 'required',
			'dvr_no'            => 'required',
			'dvr_name'          => 'required',
			'dvr_email'         => 'required',
			'dvr_start_date'    => 'required',
			'dvr_type'          => 'required',
			'dvr_license_no'    => 'required',
			'dvr_sin'           => 'required',
		]);
		
		$driver = new Driver;
		$driver->dvr_pwr_unit_no_1      = $request->dvr_pwr_unit_no_1;
		$driver->dvr_pwr_unit_no_2      = $request->dvr_pwr_unit_no_2;
		$driver->dvr_no                 = $request->dvr_no;
		$driver->dvr_name               = $request->dvr_name;
		$driver->dvr_address            = $request->dvr_address;
		$driver->dvr_city               = $request->dvr_city;
		$driver->dvr_province           = $request->dvr_province;
		$driver->dvr_postcode           = $request->dvr_postcode;
		$driver->dvr_country            = $request->dvr_country;
		$driver->dvr_cell_phone         = MyHelper::GetNumericPhoneNo($request->dvr_cell_phone);
		$driver->dvr_home_phone         = MyHelper::GetNumericPhoneNo($request->dvr_home_phone);
		$driver->dvr_other_phone        = MyHelper::GetNumericPhoneNo($request->dvr_other_phone);
		$driver->dvr_email              = $request->dvr_email;
		$driver->dvr_emergency_contact  = $request->dvr_emergency_contact;
		$driver->dvr_emergency_phone    = MyHelper::GetNumericPhoneNo($request->dvr_emergency_phone);
		$driver->dvr_ops_code           = $request->dvr_ops_code;
		$driver->dvr_dayornight         = $request->dvr_dayornight;
		$driver->dvr_fuel_card_no       = $request->dvr_fuel_card_no;
		$driver->dvr_mobile_data_type   = $request->dvr_mobile_data_type;
		$driver->dvr_mobile_call_sign   = $request->dvr_mobile_call_sign;
		$driver->dvr_mobile_phone_no    = MyHelper::GetNumericPhoneNo($request->dvr_mobile_phone_no);
		if ($request->dvr_mobile_out_action == 'on') {
			$driver->dvr_mobile_out_action = 1;
		} else {
			$driver->dvr_mobile_out_action = 0;
		}
		$driver->dvr_altern_data_type   = $request->dvr_altern_data_type;
		$driver->dvr_altern_call_sign   = $request->dvr_altern_call_sign;
		$driver->dvr_altern_phone_no    = MyHelper::GetNumericPhoneNo($request->dvr_altern_phone_no);
		if ($request->dvr_altern_out_action == 'on') {
			$driver->dvr_altern_out_action = 1;
		} else {
			$driver->dvr_altern_out_action = 0;
		}
		$driver->dvr_local_office       = $request->dvr_local_office;
		$driver->dvr_start_date         = $request->dvr_start_date;
		$driver->dvr_termination_date   = $request->dvr_termination_date;
		$driver->dvr_return_date = $request->dvr_return_date;
		if ($request->dvr_unavailable == 'on') {
			$driver->dvr_unavailable = 1;
		} else {
			$driver->dvr_unavailable = 0;
		}
		$driver->dvr_unavailability_comments    = $request->dvr_unavailability_comments;
		$driver->dvr_paye_no                    = $request->dvr_paye_no;
		$driver->dvr_type = $request->dvr_type;
		if ($request->dvr_harbourlink_fuel_card == 'on') {
			$driver->dvr_harbourlink_fuel_card = 1;
		} else {
			$driver->dvr_harbourlink_fuel_card  = 0;
		}
		$driver->dvr_birth_date                 = $request->dvr_birth_date;
		$driver->dvr_license_exp_date           = $request->dvr_license_exp_date;
		$driver->dvr_license_no                 = $request->dvr_license_no;
		$driver->dvr_license_province           = $request->dvr_license_province;
		$driver->dvr_abstract_exp_date          = $request->dvr_abstract_exp_date;
		$driver->dvr_tdg_exp_date               = $request->dvr_tdg_exp_date;
		if ($request->dvr_drug_alcohol_test == 'on') {
			$driver->dvr_drug_alcohol_test = 1;
		} else {
			$driver->dvr_drug_alcohol_test = 0;
		}
		if ($request->dvr_road_test == 'on') {
			$driver->dvr_road_test = 1;
		} else {
			$driver->dvr_road_test = 0;
		}
		if ($request->dvr_port_pass == 'on') {
			$driver->dvr_port_pass = 1;
		} else {
			$driver->dvr_port_pass = 0;
		}
		$driver->dvr_port_pass_no           = $request->dvr_port_pass_no;
		$driver->dvr_port_pass_exp_date     = $request->dvr_port_pass_exp_date;
		if ($request->dvr_twic_card == 'on') {
			$driver->dvr_twic_card = 1;
		} else {
			$driver->dvr_twic_card = 0;
		}
		$driver->dvr_twic_card_no           = $request->dvr_twic_card_no;
		$driver->dvr_twic_card_exp_date     = $request->dvr_twic_card_exp_date;
		if ($request->dvr_fast_pass == 'on') {
			$driver->dvr_fast_pass = 1;
		} else {
			$driver->dvr_fast_pass = 0;
		}
		$driver->dvr_fast_pass_no           = $request->dvr_fast_pass_no;
		$driver->dvr_fast_pass_exp_date     = $request->dvr_fast_pass_exp_date;
		if ($request->dvr_tls_license == 'on') {
			$driver->dvr_tls_license = 1;
		} else {
			$driver->dvr_tls_license = 0;
		}
		$driver->dvr_tls_license_no         = $request->dvr_tls_license_no;
		$driver->dvr_tls_license_exp_date   = $request->dvr_tls_license_exp_date;
		if ($request->dvr_security == 'on') {
			$driver->dvr_security = 1;
		} else {
			$driver->dvr_security = 0;
		}
		$driver->dvr_sin                    = $request->dvr_sin;
		if ($request->dvr_exclude_from_pay_run == 'on') {
			$driver->dvr_exclude_from_pay_run = 1;
		} else {
			$driver->dvr_exclude_from_pay_run = 0;
		}
		$driver->dvr_pay_set_amount         = $request->dvr_pay_set_amount;
		if ($request->dvr_email_invoices == 'on') {
			$driver->dvr_email_invoices = 1;
		} else {
			$driver->dvr_email_invoices = 0;
		}
		if ($request->dvr_include_in_print_run == 'on') {
			$driver->dvr_include_in_print_run = 1;
		} else {
			$driver->dvr_include_in_print_run = 0;
		}
		$driver->dvr_paye_type                  = $request->dvr_paye_type;
		$driver->dvr_hourly_rate                = $request->dvr_hourly_rate;
		$driver->dvr_safe_driving_premium       = $request->dvr_safe_driving_premium;
		$driver->dvr_clean_nsc_premium          = $request->dvr_clean_nsc_premium;
		$driver->dvr_ot_rate                    = $request->dvr_ot_rate;
		$driver->dvr_stat_holiday_rate          = $request->dvr_stat_holiday_rate;
		$driver->dvr_max_standard_hous_perweek  = $request->dvr_max_standard_hous_perweek;
		$driver->dvr_milage_rate                = $request->dvr_milage_rate;
		$driver->dvr_safe_driving_premium2      = $request->dvr_safe_driving_premium2;
		$driver->dvr_clean_nsc_premium2         = $request->dvr_clean_nsc_premium2;
		$driver->dvr_vendor_code                = $request->dvr_vendor_code;
		$driver->dvr_wcb_no                     = $request->dvr_wcb_no;
        $ledgerResults                          = explode("/", $request->dvr_ledger_code);
		$driver->dvr_ledger_code                = $ledgerResults[0];
		$driver->dvr_subhauler_address          = $request->dvr_subhauler_address;
		if ($request->dvr_add_tax_to_pay_sheet == 'on') {
			$driver->dvr_add_tax_to_pay_sheet = 1;
		} else {
			$driver->dvr_add_tax_to_pay_sheet = 0;
		}
		$driver->dvr_notes          = $request->dvr_notes;
		$driver->dvr_change_log     = $request->dvr_change_log;
		$driver->dvr_history        = $request->dvr_history;

        $saved = $driver->save();
		
		if(!$saved) {
			return redirect()->route('op_result.driver')->with('status', ' <span style="color:red">Data Has NOT Been inserted!</span>');
		} else {
			return redirect()->route('op_result.driver')->with('status', 'The new driver,  <span style="font-weight:bold;font-style:italic;color:blue">'.$request->dvr_name.'</span>, has been inserted successfully.');
		}
    }

    public function update(Request $request)
    {
		$validated = $request->validate([
			'dvr_pwr_unit_no_1' => 'required',
			'dvr_no'            => 'required',
			'dvr_name'          => 'required',
			'dvr_email'         => 'required',
			'dvr_start_date'    => 'required',
			'dvr_type'          => 'required',
			'dvr_license_no'    => 'required',
			'dvr_sin'           => 'required',
		]);
		
		//$gf_facility = \App\Models\GeofenceFacility::where('facility_name', $request->trmnl_geofence_facility)->first();
		
		$driver = Driver::where('id', $request->id)->first();
		$driver->dvr_pwr_unit_no_1          = $request->dvr_pwr_unit_no_1;
		$driver->dvr_pwr_unit_no_2          = $request->dvr_pwr_unit_no_2;
		$driver->dvr_no                     = $request->dvr_no;
		$driver->dvr_name                   = $request->dvr_name;
		$driver->dvr_address                = $request->dvr_address;
		$driver->dvr_city                   = $request->dvr_city;
		$driver->dvr_province               = $request->dvr_province;
		$driver->dvr_postcode               = $request->dvr_postcode;
		$driver->dvr_country                = $request->dvr_country;
		$driver->dvr_cell_phone             = $request->dvr_cell_phone;
		$driver->dvr_home_phone             = $request->dvr_home_phone;
		$driver->dvr_other_phone            = $request->dvr_other_phone;
		$driver->dvr_email                  = $request->dvr_email;
		$driver->dvr_emergency_contact      = $request->dvr_emergency_contact;
		$driver->dvr_emergency_phone        = $request->dvr_emergency_phone;
		$driver->dvr_ops_code               = $request->dvr_ops_code;
		$driver->dvr_picture_file           = $request->dvr_picture_file;
		$driver->dvr_dayornight             = $request->dvr_dayornight;
		$driver->dvr_fuel_card_no           = $request->dvr_fuel_card_no;
		$driver->dvr_mobile_data_type       = $request->dvr_mobile_data_type;
		$driver->dvr_mobile_call_sign       = $request->dvr_mobile_call_sign;
		$driver->dvr_mobile_phone_no        = $request->dvr_mobile_phone_no;
		if ($request->dvr_mobile_out_action == 'on') {
			$driver->dvr_mobile_out_action = 1;
		} else {
			$driver->dvr_mobile_out_action = 0;
		}
		$driver->dvr_altern_data_type       = $request->trmnl_dvr_altern_data_typelatitude;
		$driver->dvr_altern_call_sign       = $request->dvr_altern_call_sign;
		$driver->dvr_altern_phone_no        = $request->dvr_altern_phone_no;
		$driver->dvr_altern_phone_no        = $request->dvr_altern_phone_no;
		if ($request->dvr_altern_out_action == 'on') {
			$driver->dvr_altern_out_action = 1;
		} else {
			$driver->dvr_altern_out_action = 0;
		}
		$driver->dvr_local_office           = $request->dvr_local_office;
		$driver->dvr_start_date             = $request->dvr_start_date;
		$driver->dvr_termination_date       = $request->dvr_termination_date;
		$driver->dvr_return_date            = $request->dvr_return_date;
		if ($request->dvr_unavailable == 'on') {
			$driver->dvr_unavailable = 1;
		} else {
			$driver->dvr_unavailable = 0;
		}
		$driver->dvr_unavailability_comments    = $request->dvr_unavailability_comments;
		$driver->dvr_paye_no                    = $request->dvr_paye_no;
		$driver->dvr_type                       = $request->dvr_type;
		if ($request->dvr_harbourlink_fuel_card == 'on') {
			$driver->dvr_harbourlink_fuel_card = 1;
		} else {
			$driver->dvr_harbourlink_fuel_card = 0;
		}
		$driver->dvr_birth_date             = $request->dvr_birth_date;
		$driver->dvr_license_exp_date       = $request->dvr_license_exp_date;
		$driver->dvr_license_no             = $request->dvr_license_no;
		$driver->dvr_license_province       = $request->dvr_license_province;
		$driver->dvr_abstract_exp_date      = $request->dvr_abstract_exp_date;
		$driver->dvr_tdg_exp_date           = $request->dvr_tdg_exp_date;
		if ($request->dvr_drug_alcohol_test == 'on') {
			$driver->dvr_drug_alcohol_test = 1;
		} else {
			$driver->dvr_drug_alcohol_test = 0;
		}
		if ($request->dvr_road_test == 'on') {
			$driver->dvr_road_test = 1;
		} else {
			$driver->dvr_road_test = 0;
		}
		if ($request->dvr_port_pass == 'on') {
			$driver->dvr_port_pass = 1;
		} else {
			$driver->dvr_port_pass = 0;
		}
		$driver->dvr_port_pass_no           = $request->dvr_port_pass_no;
		$driver->dvr_port_pass_exp_date     = $request->dvr_port_pass_exp_date;
		if ($request->dvr_twic_card == 'on') {
			$driver->dvr_twic_card = 1;
		} else {
			$driver->dvr_twic_card = 0;
		}
		$driver->dvr_twic_card_no           = $request->dvr_twic_card_no;
		$driver->dvr_twic_card_exp_date     = $request->dvr_twic_card_exp_date;
		if ($request->dvr_fast_pass == 'on') {
			$driver->dvr_fast_pass = 1;
		} else {
			$driver->dvr_fast_pass = 0;
		}
		$driver->dvr_fast_pass_no           = $request->dvr_fast_pass_no;
		$driver->dvr_fast_pass_exp_date     = $request->dvr_fast_pass_exp_date;
		if ($request->dvr_tls_license == 'on') {
			$driver->dvr_tls_license = 1;
		} else {
			$driver->dvr_tls_license = 0;
		}
		$driver->dvr_tls_license_no         = $request->dvr_tls_license_no;
		$driver->dvr_tls_license_exp_date   = $request->dvr_tls_license_exp_date;
		if ($request->dvr_security == 'on') {
			$driver->dvr_security = 1;
		} else {
			$driver->dvr_security = 0;
		}
		$driver->dvr_sin                    = $request->dvr_sin;
		if ($request->dvr_exclude_from_pay_run == 'on') {
			$driver->dvr_exclude_from_pay_run = 1;
		} else {
			$driver->dvr_exclude_from_pay_run = 0;
		}
		$driver->dvr_pay_set_amount         = $request->dvr_pay_set_amount;
		if ($request->dvr_email_invoices == 'on') {
			$driver->dvr_email_invoices = 1;
		} else {
			$driver->dvr_email_invoices = 0;
		}
		if ($request->dvr_include_in_print_run == 'on') {
			$driver->dvr_include_in_print_run = 1;
		} else {
			$driver->dvr_include_in_print_run = 0;
		}
		$driver->dvr_paye_type                  = $request->dvr_paye_type;
		$driver->dvr_hourly_rate                = $request->dvr_hourly_rate;
		$driver->dvr_safe_driving_premium       = $request->dvr_safe_driving_premium;
		$driver->dvr_clean_nsc_premium          = $request->dvr_clean_nsc_premium;
		$driver->dvr_ot_rate                    = $request->dvr_ot_rate;
		$driver->dvr_stat_holiday_rate          = $request->dvr_stat_holiday_rate;
		$driver->dvr_max_standard_hous_perweek  = $request->dvr_max_standard_hous_perweek;
		$driver->dvr_milage_rate                = $request->dvr_milage_rate;
		$driver->dvr_safe_driving_premium2      = $request->dvr_safe_driving_premium2;
		$driver->dvr_clean_nsc_premium2         = $request->dvr_clean_nsc_premium2;
		$driver->dvr_vendor_code                = $request->dvr_vendor_code;
		$driver->dvr_wcb_no                     = $request->dvr_wcb_no;
        $ledgerResults                          = explode("/", $request->dvr_ledger_code);
		$driver->dvr_ledger_code                = $ledgerResults[0];
		$driver->dvr_subhauler_address          = $request->dvr_subhauler_address;
		if ($request->dvr_add_tax_to_pay_sheet == 'on') {
			$driver->dvr_add_tax_to_pay_sheet = 1;
		} else {
			$driver->dvr_add_tax_to_pay_sheet = 0;
		}
		$driver->dvr_notes          = $request->dvr_notes;
		$driver->dvr_change_log     = $request->dvr_change_log;
		$driver->dvr_history        = $request->dvr_history;
		$driver->dvr_deleted        = $request->dvr_deleted;

		$saved = $driver->save();
		
		if(!$saved) {
			return redirect()->route('op_result.driver')->with('status', ' <span style="color:red">Data has NOT been updated!</span>');
		} else {
			return redirect()->route('op_result.driver')->with('status', 'The driver,  <span style="font-weight:bold;font-style:italic;color:blue">'.$driver->dvr_name.'</span>, has been updated successfully.');
		}
    }
}
