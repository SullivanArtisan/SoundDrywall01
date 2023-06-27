<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\Customer;
use App\Models\CstmDispatch;
use App\Models\CstmInvoice;
use App\Models\CstmAccountPrice;
use App\Models\CstmAllOther;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$validated = $request->validate([
			'cstm_account_no' => 'required',
			'cstm_account_name' => 'required',
			'cstm_address' => 'required',
			'cstm_city' => 'required',
			'cstm_province' => 'required',
			'cstm_postcode' => 'required',
		]);
		
		// Prepare the data in customer's Contact tab
		$customer = new Customer;
		$customer->cstm_account_no 	= $request->cstm_account_no;
		$customer->cstm_account_name = $request->cstm_account_name;
		$customer->cstm_address 	= $request->cstm_address;
		$customer->cstm_city 		= $request->cstm_city;
		$customer->cstm_province 	= $request->cstm_province;
		$customer->cstm_postcode	= $request->cstm_postcode;
		$customer->cstm_country 	= $request->cstm_country;
		$customer->cstm_zone 		= $request->cstm_zone;
		$customer->cstm_fax 		= $request->cstm_fax;
		$customer->cstm_account_contact = $request->cstm_account_contact;
		$customer->cstm_account_tel 	= $request->cstm_account_tel;
		$customer->cstm_account_email 	= $request->cstm_account_email;
		$customer->cstm_hst_no			= $request->cstm_hst_no;
		$customer->cstm_contact_name1 	= $request->cstm_contact_name1;
		$customer->cstm_contact_tel1 	= $request->cstm_contact_tel1;
		$customer->cstm_contact_email1 	= $request->cstm_contact_email1;
		$customer->cstm_contact_name2 	= $request->cstm_contact_name2;
		$customer->cstm_contact_tel2 	= $request->cstm_contact_tel2;
		$customer->cstm_contact_email2 	= $request->cstm_contact_email2;
		$customer->cstm_contact_name3 	= $request->cstm_contact_name3;
		$customer->cstm_contact_tel3 	= $request->cstm_contact_tel3;
		$customer->cstm_contact_email3	= $request->cstm_contact_email3;
		$customer->cstm_contact_invoice_name 	= $request->cstm_contact_invoice_name;
		$customer->cstm_contact_invoice_addr 	= $request->cstm_contact_invoice_addr;
		$customer->cstm_contact_invoice_city	= $request->cstm_contact_invoice_city;
		$customer->cstm_contact_invoice_province 	= $request->cstm_contact_invoice_province;
		$customer->cstm_contact_invoice_postcode	= $request->cstm_contact_invoice_postcode;
		$customer->cstm_contact_invoice_country 	= $request->cstm_contact_invoice_country;
		$saved = $customer->save();
			
		if(!$saved) {
			return redirect()->route('op_result.customer')->with('status', ' <span style="color:red">Data Has NOT Been inserted -- customers table insertion failed!</span>');
		} else {
			$targetCustomer = Customer::where('cstm_account_no', $request->cstm_account_no)->get();
			
			$cstmDispatch = new CstmDispatch;
			$cstmInvoice = new CstmInvoice;
			$cstmAccountPrice = new CstmAccountPrice;
			$cstmAllOther = new CstmAllOther;
			
			// Prepare the data in customer's Dispatch tab
			$cstmDispatch->cstm_account_no = $targetCustomer[0]->cstm_account_no;
			$cstmDispatch->cstm_dspch_pod_email1 = $request->cstm_dspch_pod_email1;
			if ($request->cstm_dspch_force_ref == 'on') {
				$cstmDispatch->cstm_dspch_force_ref = 1;
			} else {
				$cstmDispatch->cstm_dspch_force_ref = 0;
			}
			$saved = $cstmDispatch->save();

			if(!$saved) {
				return redirect()->route('op_result.customer')->with('status', ' <span style="color:red">Data has NOT been inserted -- cstm_dispatches table insertion failed!</span>');
			} else {
				
				// Prepare the data in customer's Notes and Control2 tab 
				$cstmAllOther->cstm_account_no 			= $targetCustomer[0]->cstm_account_no;
				$cstmAllOther->cstm_other_notes 		= $request->cstm_other_notes;
				$cstmAllOther->cstm_other_docket_msgs 	= $request->cstm_other_docket_msgs;
				$cstmAllOther->cstm_other_control_msgs	= $request->cstm_other_control_msgs;
				$cstmAllOther->cstm_other_additional_info 		= $request->cstm_other_additional_info;
				$cstmAllOther->cstm_other_special_instructions	= $request->cstm_other_special_instructions;
				$saved = $cstmAllOther->save();
				if(!$saved) {
					return redirect()->route('op_result.customer')->with('status', ' <span style="color:red">Data has NOT been inserted -- cstm_all_others table insertion failed!</span>');
				} else {
				
					// Prepare the data in customer's Invoice tab 
					$cstmInvoice->cstm_account_no = $targetCustomer[0]->cstm_account_no;
					$cstmInvoice->cstm_invoice_period 		= $request->cstm_invoice_period;
					$cstmInvoice->cstm_invoice_layout 		= $request->cstm_invoice_layout;
					$cstmInvoice->cstm_invoice_style 		= $request->cstm_invoice_style;
					$cstmInvoice->cstm_invoice_pdf_style	= $request->cstm_invoice_pdf_style;
					if ($request->cstm_invoice_requires_pod == 'on') {
						$cstmInvoice->cstm_invoice_requires_pod = 1;
					} else {
						$cstmInvoice->cstm_invoice_requires_pod = 0;
					}
					if ($request->cstm_invoice_by_group_only == 'on') {
						$cstmInvoice->cstm_invoice_by_group_only = 1;
					} else {
						$cstmInvoice->cstm_invoice_by_group_only = 0;
					}
					if ($request->cstm_invoice_tax == 'on') {
						$cstmInvoice->cstm_invoice_tax = 1;
					} else {
						$cstmInvoice->cstm_invoice_tax = 0;
					}
					if ($request->cstm_invoice_no_bridge_toll == 'on') {
						$cstmInvoice->cstm_invoice_no_bridge_toll = 1;
					} else {
						$cstmInvoice->cstm_invoice_no_bridge_toll = 0;
					}
					if ($request->cstm_invoice_email_in_pdf_fmt == 'on') {
						$cstmInvoice->cstm_invoice_email_in_pdf_fmt = 1;
					} else {
						$cstmInvoice->cstm_invoice_email_in_pdf_fmt = 0;
					}
					if ($request->cstm_invoice_include_in_print_run == 'on') {
						$cstmInvoice->cstm_invoice_include_in_print_run = 1;
					} else {
						$cstmInvoice->cstm_invoice_include_in_print_run = 0;
					}
					if ($request->cstm_invoice_deleted == 'on') {
						$cstmInvoice->cstm_invoice_deleted = 1;
					} else {
						$cstmInvoice->cstm_invoice_deleted = 0;
					}
					if ($request->cstm_invoice_local_fuel_if_surcharged == 'on') {
						$cstmInvoice->cstm_invoice_local_fuel_if_surcharged = 1;
					} else {
						$cstmInvoice->cstm_invoice_local_fuel_if_surcharged = 0;
					}
					if ($request->cstm_invoice_hwy_fuel_if_surcharged == 'on') {
						$cstmInvoice->cstm_invoice_hwy_fuel_if_surcharged = 1;
					} else {
						$cstmInvoice->cstm_invoice_hwy_fuel_if_surcharged = 0;
					}
					$cstmInvoice->cstm_invoice_attachments_needed		= $request->cstm_invoice_attachments_needed;
					$cstmInvoice->cstm_invoice_local_office 			= $request->cstm_invoice_local_office;
					$cstmInvoice->cstm_invoice_payment_terms 			= $request->cstm_invoice_payment_terms;
					$cstmInvoice->cstm_invoice_account_status 			= $request->cstm_invoice_account_status;
					$cstmInvoice->cstm_invoice_export_job_fmt 			= $request->cstm_invoice_export_job_fmt;
					$cstmInvoice->cstm_invoice_email_addr1				= $request->cstm_invoice_email_addr1;
					$cstmInvoice->cstm_invoice_email_addr2 				= $request->cstm_invoice_email_addr2;
					$cstmInvoice->cstm_invoice_email_addr3 				= $request->cstm_invoice_email_addr3;
					$cstmInvoice->cstm_invoice_email_addr4 				= $request->cstm_invoice_email_addr4;
					$cstmInvoice->cstm_invoice_email_addr5 				= $request->cstm_invoice_email_addr5;
					$cstmInvoice->cstm_invoice_email_addr6 				= $request->cstm_invoice_email_addr6;
					$cstmInvoice->cstm_invoice_account_opened 			= $request->cstm_invoice_account_opened;
					$cstmInvoice->cstm_invoice_currency 			 	= $request->cstm_invoice_currency;
					$cstmInvoice->cstm_invoice_credit_limit 			= $request->cstm_invoice_credit_limit;
					$cstmInvoice->cstm_invoice_local_fuel_surcharged 	= $request->cstm_invoice_local_fuel_surcharged;
					$cstmInvoice->cstm_invoice_hwy_fuel_surcharged 		= $request->cstm_invoice_hwy_fuel_surcharged;
					$cstmInvoice->cstm_invoice_additional_email_addr = $request->cstm_invoice_additional_email_addr;
					$cstmInvoice->cstm_invoice_fsc_email_addr		= $request->cstm_invoice_fsc_email_addr;
					$saved = $cstmInvoice->save();
					if(!$saved) {
						return redirect()->route('op_result.customer')->with('status', ' <span style="color:red">Data has NOT been inserted -- cstm_invoices table insertion failed!</span>');
					} else {
				
						// Prepare the data in customer's AccountPrices tab 
						$cstmAccountPrice->cstm_account_no = $targetCustomer[0]->cstm_account_no;
						// $cstmAccountPrice->cstm_account_chassis = $request->cstm_account_chassis;
						$saved = $cstmAccountPrice->save();
						if(!$saved) {
							return redirect()->route('op_result.customer')->with('status', ' <span style="color:red">Data has NOT been inserted -- cstm_account_prices table insertion failed!</span>');
						} else {

							return redirect()->route('op_result.customer')->with('status', 'The new customer,  <span style="font-weight:bold;font-style:italic;color:blue">'.$targetCustomer[0]->cstm_account_name.'</span>, has been inserted successfully.');
						}
					}
				}
			}
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
		$validated = $request->validate([
			'cstm_account_no' => 'required',
			'cstm_account_name' => 'required',
			'cstm_address' => 'required',
			'cstm_city' => 'required',
			'cstm_province' => 'required',
			'cstm_postcode' => 'required',
		]);
		
		// Prepare the data in customer's Contact tab
		$customer = Customer::where('cstm_account_no', $request->cstm_account_no)->first();
		$customer->cstm_account_name = $request->cstm_account_name;
		$customer->cstm_address = $request->cstm_address;
		$customer->cstm_city = $request->cstm_city;
		$customer->cstm_province = $request->cstm_province;
		$customer->cstm_postcode = $request->cstm_postcode;
		$customer->cstm_country = $request->cstm_country;
		$customer->cstm_zone = $request->cstm_zone;
		$customer->cstm_fax = $request->cstm_fax;
		$customer->cstm_account_contact = $request->cstm_account_contact;
		$customer->cstm_account_tel = $request->cstm_account_tel;
		$customer->cstm_account_email = $request->cstm_account_email;
		$customer->cstm_hst_no = $request->cstm_hst_no;
		$customer->cstm_contact_name1 = $request->cstm_contact_name1;
		$customer->cstm_contact_tel1 = $request->cstm_contact_tel1;
		$customer->cstm_contact_email1 = $request->cstm_contact_email1;
		$customer->cstm_contact_name2 = $request->cstm_contact_name2;
		$customer->cstm_contact_tel2 = $request->cstm_contact_tel2;
		$customer->cstm_contact_email2 = $request->cstm_contact_email2;
		$customer->cstm_contact_name3 = $request->cstm_contact_name3;
		$customer->cstm_contact_tel3 = $request->cstm_contact_tel3;
		$customer->cstm_contact_email3 = $request->cstm_contact_email3;
		$customer->cstm_contact_invoice_name = $request->cstm_contact_invoice_name;
		$customer->cstm_contact_invoice_addr = $request->cstm_contact_invoice_addr;
		$customer->cstm_contact_invoice_city = $request->cstm_contact_invoice_city;
		$customer->cstm_contact_invoice_province = $request->cstm_contact_invoice_province;
		$customer->cstm_contact_invoice_postcode = $request->cstm_contact_invoice_postcode;
		$customer->cstm_contact_invoice_country = $request->cstm_contact_invoice_country;
		$saved = $customer->save();
		
		if(!$saved) {
			return redirect()->route('op_result.customer')->with('status', ' <span style="color:red">Customer Contact Data Has NOT Been updated!</span>');
		} else {
			// Prepare the data in customer's Dispatch tab
			$cstmDispatch = CstmDispatch::where('cstm_account_no', $customer->cstm_account_no)->first();
			if ($request->cstm_dspch_force_ref == 'on') {
				$cstmDispatch->cstm_dspch_force_ref = 1;
			} else {
				$cstmDispatch->cstm_dspch_force_ref = 0;
			}
			if ($request->cstm_dspch_email_pod == 'on') {
				$cstmDispatch->cstm_dspch_email_pod = 1;
			} else {
				$cstmDispatch->cstm_dspch_email_pod = 0;
			}
			if ($request->cstm_dspch_email_pickup == 'on') {
				$cstmDispatch->cstm_dspch_email_pickup = 1;
			} else {
				$cstmDispatch->cstm_dspch_email_pickup = 0;
			}
			$cstmDispatch->cstm_dspch_pod_email1 = $request->cstm_dspch_pod_email1;
			$cstmDispatch->cstm_dspch_pod_email2 = $request->cstm_dspch_pod_email2;
			$cstmDispatch->cstm_dspch_pod_email3 = $request->cstm_dspch_pod_email3;
			if ($request->cstm_dspch_priority == 'on') {
				$cstmDispatch->cstm_dspch_priority = 1;
			} else {
				$cstmDispatch->cstm_dspch_priority = 0;
			}
			$cstmDispatch->cstm_dspch_group1 = $request->cstm_dspch_group1;
			$cstmDispatch->cstm_dspch_group2 = $request->cstm_dspch_group2;
			$cstmDispatch->cstm_dspch_group3 = $request->cstm_dspch_group3;
			$cstmDispatch->cstm_dspch_group4 = $request->cstm_dspch_group4;
			$cstmDispatch->cstm_dspch_group5 = $request->cstm_dspch_group5;
			if ($request->cstm_dspch_one_container_per_job == 'on') {
				$cstmDispatch->cstm_dspch_one_container_per_job = 1;
			} else {
				$cstmDispatch->cstm_dspch_one_container_per_job = 0;
			}
			$cstmDispatch->cstm_dspch_import_driver_notes = $request->cstm_dspch_import_driver_notes;
			$cstmDispatch->cstm_dspch_export_driver_notes = $request->cstm_dspch_export_driver_notes;
			$saved = $cstmDispatch->save();
			
			if(!$saved) {
				return redirect()->route('op_result.customer')->with('status', ' <span style="color:red">Customer Dispatch Data Has NOT Been updated!</span>');
			} else {
				// Prepare the data in customer's Notes and Control2 tab
				$cstmAllOther = CstmAllOther::where('cstm_account_no', $customer->cstm_account_no)->first();
				$cstmAllOther->cstm_other_notes = $request->cstm_other_notes;
				// $cstmAllOther->cstm_other_changes = $request->cstm_other_changes;			// read only in GUI
				$cstmAllOther->cstm_other_docket_msgs = $request->cstm_other_docket_msgs;
				$cstmAllOther->cstm_other_control_msgs = $request->cstm_other_control_msgs;
				$cstmAllOther->cstm_other_additional_info = $request->cstm_other_additional_info;
				$cstmAllOther->cstm_other_special_instructions = $request->cstm_other_special_instructions;
				// $cstmAllOther->cstm_other_histories = $request->cstm_other_histories;		// read only in GUI
				$saved = $cstmAllOther->save();
				
				if(!$saved) {
					return redirect()->route('op_result.customer')->with('status', ' <span style="color:red">Customer Other Data Has NOT Been updated!</span>');
				} else {
					// Prepare the data in customer's Invoice tab 
					$cstmInvoice = CstmInvoice::where('cstm_account_no', $customer->cstm_account_no)->first();
					$cstmInvoice->cstm_invoice_period 		= $request->cstm_invoice_period;
					$cstmInvoice->cstm_invoice_layout 		= $request->cstm_invoice_layout;
					$cstmInvoice->cstm_invoice_style 		= $request->cstm_invoice_style;
					$cstmInvoice->cstm_invoice_pdf_style 		= $request->cstm_invoice_pdf_style;
					if ($request->cstm_invoice_requires_pod == 'on') {
						$cstmDispatch->cstm_invoice_requires_pod = 1;
					} else {
						$cstmDispatch->cstm_invoice_requires_pod = 0;
					}
					if ($request->cstm_invoice_by_group_only == 'on') {
						$cstmDispatch->cstm_invoice_by_group_only = 1;
					} else {
						$cstmDispatch->cstm_invoice_by_group_only = 0;
					}
					if ($request->cstm_invoice_tax == 'on') {
						$cstmDispatch->cstm_invoice_tax = 1;
					} else {
						$cstmDispatch->cstm_invoice_tax = 0;
					}
					if ($request->cstm_invoice_no_bridge_toll == 'on') {
						$cstmDispatch->cstm_invoice_no_bridge_toll = 1;
					} else {
						$cstmDispatch->cstm_invoice_no_bridge_toll = 0;
					}
					$cstmInvoice->cstm_invoice_attachments_needed 		= $request->cstm_invoice_attachments_needed;
					$cstmInvoice->cstm_invoice_local_office 		= $request->cstm_invoice_local_office;
					$cstmInvoice->cstm_invoice_payment_terms 		= $request->cstm_invoice_payment_terms;
					$cstmInvoice->cstm_invoice_account_status 		= $request->cstm_invoice_account_status;
					if ($request->cstm_invoice_email_in_pdf_fmt == 'on') {
						$cstmDispatch->cstm_invoice_email_in_pdf_fmt = 1;
					} else {
						$cstmDispatch->cstm_invoice_email_in_pdf_fmt = 0;
					}
					if ($request->cstm_invoice_include_in_print_run == 'on') {
						$cstmDispatch->cstm_invoice_include_in_print_run = 1;
					} else {
						$cstmDispatch->cstm_invoice_include_in_print_run = 0;
					}
					$cstmInvoice->cstm_invoice_export_job_fmt 		= $request->cstm_invoice_export_job_fmt;
					$cstmInvoice->cstm_invoice_email_addr1 			= $request->cstm_invoice_email_addr1;
					$cstmInvoice->cstm_invoice_email_addr2 			= $request->cstm_invoice_email_addr2;
					$cstmInvoice->cstm_invoice_email_addr3 			= $request->cstm_invoice_email_addr3;
					$cstmInvoice->cstm_invoice_email_addr4 			= $request->cstm_invoice_email_addr4;
					$cstmInvoice->cstm_invoice_email_addr5 			= $request->cstm_invoice_email_addr5;
					$cstmInvoice->cstm_invoice_email_addr6 			= $request->cstm_invoice_email_addr6;
					$cstmInvoice->cstm_invoice_account_opened 		= $request->cstm_invoice_account_opened;
					if ($request->cstm_invoice_deleted == 'on') {
						$cstmDispatch->cstm_invoice_deleted = 1;
					} else {
						$cstmDispatch->cstm_invoice_deleted = 0;
					}
					$cstmInvoice->cstm_invoice_currency 			= $request->cstm_invoice_currency;
					$cstmInvoice->cstm_invoice_credit_limit 		= $request->cstm_invoice_credit_limit;
					if ($request->cstm_invoice_local_fuel_if_surcharged == 'on') {
						$cstmDispatch->cstm_invoice_local_fuel_if_surcharged = 1;
					} else {
						$cstmDispatch->cstm_invoice_local_fuel_if_surcharged = 0;
					}
					$cstmInvoice->cstm_invoice_local_fuel_surcharged 		= $request->cstm_invoice_local_fuel_surcharged;
					if ($request->cstm_invoice_hwy_fuel_if_surcharged == 'on') {
						$cstmDispatch->cstm_invoice_hwy_fuel_if_surcharged = 1;
					} else {
						$cstmDispatch->cstm_invoice_hwy_fuel_if_surcharged = 0;
					}
					$cstmInvoice->cstm_invoice_hwy_fuel_surcharged	= $request->cstm_invoice_hwy_fuel_surcharged;
					$cstmInvoice->cstm_invoice_additional_email_addr= $request->cstm_invoice_additional_email_addr;
					$cstmInvoice->cstm_invoice_fsc_email_addr 		= $request->cstm_invoice_fsc_email_addr;
					
					$saved = $cstmInvoice->save();
					
					if(!$saved) {
						return redirect()->route('op_result.customer')->with('status', ' <span style="color:red">Customer Invoice Data Has NOT Been updated!</span>');
					} else {
						return redirect()->route('op_result.customer')->with('status', 'The customer,  <span style="font-weight:bold;font-style:italic;color:blue">'.$customer->cstm_account_name.'</span>, has been updated successfully.');
					}
				}
			}
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
