<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Helper\MyHelper;
use App\Models\Booking;
use App\Models\User;

class BookingController extends Controller
{
    public function add_finished(Request $request)
    {
		$saved = false;
		
		if(!$saved) {
			return redirect()->route('booking_add', ['bookingResult'=>' <span style="color:red">(Failed to add the booking!)</span>']);
		} else {
			return redirect()->route('booking_add', ['bookingTab'=>'containerinfo-tab', 'id'=>$booking->id]);
		}
    }

    public function add(Request $request)
    {
            $validated = $request->validate([
			'bk_cstm_account_no'        => 'required',
			'bk_job_type'               => 'required',
			'bk_pickup_cmpny_name'      => 'required',
			'bk_pickup_cmpny_city'      => 'required',
			'bk_pickup_cmpny_zone'      => 'required',
			'bk_delivery_cmpny_name'    => 'required',
			'bk_delivery_cmpny_city'    => 'required',
			'bk_delivery_cmpny_zone'    => 'required',
		]);
		
		$booking = new Booking;
        $booking->bk_job_no                     = Auth::user()->docket_prefix;
        $booking->bk_job_no                     .= Auth::user()->last_booking_job_no;
		$booking->bk_cstm_account_no            = $request->bk_cstm_account_no;
		$booking->bk_cstm_account_name          = $request->bk_cstm_account_name;
		$booking->bk_job_type                   = $request->bk_job_type;
		$booking->bk_ops_code                   = $request->bk_ops_code;
		$booking->bk_ssl_name                   = $request->bk_ssl_name;
		$booking->bk_total_containers           = $request->bk_total_containers;
		$booking->bk_terminal_name              = $request->bk_terminal_name;
		$booking->bk_gate                       = $request->bk_gate;
		$booking->bk_vessel                     = $request->bk_vessel;
		$booking->bk_voyage                     = $request->bk_voyage;
		$booking->bk_imo_no                     = $request->bk_imo_no;
		$booking->bk_pickup_cmpny_name          = $request->bk_pickup_cmpny_name;
		$booking->bk_pickup_cmpny_addr_1        = $request->bk_pickup_cmpny_addr_1;
		$booking->bk_pickup_cmpny_addr_2        = $request->bk_pickup_cmpny_addr_2;
		$booking->bk_pickup_cmpny_addr_3        = $request->bk_pickup_cmpny_addr_3;
		$booking->bk_pickup_cmpny_city          = $request->bk_pickup_cmpny_city;
		$booking->bk_pickup_cmpny_province      = $request->bk_pickup_cmpny_province;
		$booking->bk_pickup_cmpny_postcode      = $request->bk_pickup_cmpny_postcode;
		$booking->bk_pickup_cmpny_country       = $request->bk_pickup_cmpny_country;
		$booking->bk_pickup_movement_type       = $request->bk_pickup_movement_type;
		$booking->bk_pickup_cmpny_contact       = $request->bk_pickup_cmpny_contact;
		$booking->bk_pickup_cmpny_tel           = $request->bk_pickup_cmpny_tel;
		$booking->bk_pickup_cmpny_email         = $request->bk_pickup_cmpny_email;
		$booking->bk_pickup_remarks             = $request->bk_pickup_remarks;
		$booking->bk_pickup_cmpny_zone          = $request->bk_pickup_cmpny_zone;
		$booking->bk_delivery_cmpny_name        = $request->bk_delivery_cmpny_name;
		$booking->bk_delivery_cmpny_addr_1      = $request->bk_delivery_cmpny_addr_1;
		$booking->bk_delivery_cmpny_addr_2      = $request->bk_delivery_cmpny_addr_2;
		$booking->bk_delivery_cmpny_addr_3      = $request->bk_delivery_cmpny_addr_3;
		$booking->bk_delivery_cmpny_city        = $request->bk_delivery_cmpny_city;
		$booking->bk_delivery_cmpny_province    = $request->bk_delivery_cmpny_province;
		$booking->bk_delivery_cmpny_postcode    = $request->bk_delivery_cmpny_postcode;
		$booking->bk_delivery_cmpny_country     = $request->bk_delivery_cmpny_country;
		$booking->bk_delivery_movement_type     = $request->bk_delivery_movement_type;
		$booking->bk_delivery_cmpny_contact     = $request->bk_delivery_cmpny_contact;
		$booking->bk_delivery_cmpny_tel         = $request->bk_delivery_cmpny_tel;
		$booking->bk_delivery_cmpny_email       = $request->bk_delivery_cmpny_email;
		$booking->bk_delivery_remarks           = $request->bk_delivery_remarks;
		$booking->bk_delivery_cmpny_zone        = $request->bk_delivery_cmpny_zone;

		$booking->bk_status                     = MyHelper::BkCreatedStaus();
		$saved = $booking->save();
		
		if(!$saved) {
			return redirect()->route('booking_add', ['bookingResult'=>' <span style="color:red">(Failed to add the new booking!)</span>']);
		} else {
			$user = User::where('id', Auth::user()->id)->first();
            $user->last_booking_job_no = Auth::user()->last_booking_job_no + 1;
			$userUpdateResult = $user->save();
			if(!$userUpdateResult) {
				Log::Info('Failed to increase booking_job_no for: '.$user->email);
			}
			return redirect()->route('booking_add', ['bookingTab'=>'containerinfo-tab', 'id'=>$booking->id]);
		}
    }
	
    public function update(Request $request)
    {
        $validated = $request->validate([
			'bk_cstm_account_no'        => 'required',
			'bk_job_type'               => 'required',
			'bk_pickup_cmpny_name'      => 'required',
			'bk_pickup_cmpny_city'      => 'required',
			'bk_pickup_cmpny_zone'      => 'required',
			'bk_delivery_cmpny_name'    => 'required',
			'bk_delivery_cmpny_city'    => 'required',
			'bk_delivery_cmpny_zone'    => 'required',
        ]);
        
        $booking = Booking::where('id', $request->id)->first();
		$booking->bk_cstm_account_no            = $request->bk_cstm_account_no;
		$booking->bk_cstm_account_name          = $request->bk_cstm_account_name;
		$booking->bk_job_type                   = $request->bk_job_type;
		$booking->bk_ops_code                   = $request->bk_ops_code;
		$booking->bk_ssl_name                   = $request->bk_ssl_name;
		$booking->bk_total_containers           = $request->bk_total_containers;
		$booking->bk_terminal_name              = $request->bk_terminal_name;
		$booking->bk_gate                       = $request->bk_gate;
		$booking->bk_vessel                     = $request->bk_vessel;
		$booking->bk_voyage                     = $request->bk_voyage;
		$booking->bk_imo_no                     = $request->bk_imo_no;
		$booking->bk_pickup_cmpny_name          = $request->bk_pickup_cmpny_name;
		$booking->bk_pickup_cmpny_addr_1        = $request->bk_pickup_cmpny_addr_1;
		$booking->bk_pickup_cmpny_addr_2        = $request->bk_pickup_cmpny_addr_2;
		$booking->bk_pickup_cmpny_addr_3        = $request->bk_pickup_cmpny_addr_3;
		$booking->bk_pickup_cmpny_city          = $request->bk_pickup_cmpny_city;
		$booking->bk_pickup_cmpny_province      = $request->bk_pickup_cmpny_province;
		$booking->bk_pickup_cmpny_postcode      = $request->bk_pickup_cmpny_postcode;
		$booking->bk_pickup_cmpny_country       = $request->bk_pickup_cmpny_country;
		$booking->bk_pickup_movement_type       = $request->bk_pickup_movement_type;
		$booking->bk_pickup_cmpny_contact       = $request->bk_pickup_cmpny_contact;
		$booking->bk_pickup_cmpny_tel           = $request->bk_pickup_cmpny_tel;
		$booking->bk_pickup_cmpny_email         = $request->bk_pickup_cmpny_email;
		$booking->bk_pickup_remarks             = $request->bk_pickup_remarks;
		$booking->bk_pickup_cmpny_zone          = $request->bk_pickup_cmpny_zone;
		$booking->bk_delivery_cmpny_name        = $request->bk_delivery_cmpny_name;
		$booking->bk_delivery_cmpny_addr_1      = $request->bk_delivery_cmpny_addr_1;
		$booking->bk_delivery_cmpny_addr_2      = $request->bk_delivery_cmpny_addr_2;
		$booking->bk_delivery_cmpny_addr_3      = $request->bk_delivery_cmpny_addr_3;
		$booking->bk_delivery_cmpny_city        = $request->bk_delivery_cmpny_city;
		$booking->bk_delivery_cmpny_province    = $request->bk_delivery_cmpny_province;
		$booking->bk_delivery_cmpny_postcode    = $request->bk_delivery_cmpny_postcode;
		$booking->bk_delivery_cmpny_country     = $request->bk_delivery_cmpny_country;
		$booking->bk_delivery_movement_type     = $request->bk_delivery_movement_type;
		$booking->bk_delivery_cmpny_contact     = $request->bk_delivery_cmpny_contact;
		$booking->bk_delivery_cmpny_tel         = $request->bk_delivery_cmpny_tel;
		$booking->bk_delivery_cmpny_email       = $request->bk_delivery_cmpny_email;
		$booking->bk_delivery_remarks           = $request->bk_delivery_remarks;
		$booking->bk_delivery_cmpny_zone        = $request->bk_delivery_cmpny_zone;
        $saved = $booking->save();
        
        if(!$saved) {
            return redirect()->route('op_result.booking')->with('status', ' <span style="color:red">Data has NOT been updated!</span>');
        } else {
            return redirect()->route('op_result.booking')->with('status', 'The booking job,  <span style="font-weight:bold;font-style:italic;color:blue">'.$booking->bk_job_no.'</span>, has been updated successfully.');
        }
    }
}
