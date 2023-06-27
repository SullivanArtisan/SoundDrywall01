<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Terminal;

class TerminalController extends Controller
{
    public function store(Request $request)
    {
		$validated = $request->validate([
			'trmnl_name' => 'required',
			'trmnl_address' => 'required',
			'trmnl_city' => 'required',
		]);
		
		$gf_facility = \App\Models\GeofenceFacility::where('facility_name', $request->trmnl_geofence_facility)->first();
		
		$trmnl = new Terminal;
		$trmnl->trmnl_name = $request->trmnl_name;
		$trmnl->trmnl_address = $request->trmnl_address;
		$trmnl->trmnl_city = $request->trmnl_city;
		$trmnl->trmnl_province = $request->trmnl_province;
		$trmnl->trmnl_postcode = $request->trmnl_postcode;
		$trmnl->trmnl_area = $request->trmnl_area;
		$trmnl->trmnl_contact = $request->trmnl_contact;
		$trmnl->trmnl_tel = $request->trmnl_tel;
		$trmnl->trmnl_fax = $request->trmnl_fax;
		$trmnl->trmnl_email = $request->trmnl_email;
		$trmnl->trmnl_cutoff_time = $request->trmnl_cutoff_time;
		if ($request->trmnl_no_sig_required == 'on') {
			$trmnl->trmnl_no_sig_required = 1;
		} else {
			$trmnl->trmnl_no_sig_required = 0;
		}
		if ($gf_facility) {
			$trmnl->trmnl_geofence_facility = $gf_facility->id;
		}
		$trmnl->trmnl_latitude = $request->trmnl_latitude;
		$trmnl->trmnl_longitude = $request->trmnl_longitude;
		$trmnl->trmnl_arrived_latitude = $request->trmnl_arrived_latitude;
		$trmnl->trmnl_arrived_longitude = $request->trmnl_arrived_longitude;
		$trmnl->trmnl_arrived_radius = $request->trmnl_arrived_radius;
		$trmnl->trmnl_halo_center_latitude = $request->trmnl_halo_center_latitude;
		$trmnl->trmnl_halo_center_longitude = $request->trmnl_halo_center_longitude;
		$trmnl->trmnl_halo_center_radius = $request->trmnl_halo_center_radius;
		$trmnl->trmnl_ingate_latitude = $request->trmnl_ingate_latitude;
		$trmnl->trmnl_ingate_longitude = $request->trmnl_ingate_longitude;
		$trmnl->trmnl_ingate_radius = $request->trmnl_ingate_radius;
		$trmnl->trmnl_outgate1_latitude = $request->trmnl_outgate1_latitude;
		$trmnl->trmnl_outgate1_longitude = $request->trmnl_outgate1_longitude;
		$trmnl->trmnl_outgate1_radius = $request->trmnl_outgate1_radius;
		$trmnl->trmnl_outgate2_latitude = $request->trmnl_outgate2_latitude;
		$trmnl->trmnl_outgate2_longitude = $request->trmnl_outgate2_longitude;
		$trmnl->trmnl_outgate2_radius = $request->trmnl_outgate2_radius;
		$saved = $trmnl->save();
		
		if(!$saved) {
			return redirect()->route('op_result.terminal')->with('status', ' <span style="color:red">Data Has NOT Been inserted!</span>');
		} else {
			return redirect()->route('op_result.terminal')->with('status', 'The new terminal,  <span style="font-weight:bold;font-style:italic;color:blue">'.$request->trmnl_name.'</span>, has been inserted successfully.');
		}
    }
	
    public function update(Request $request)
    {
		$validated = $request->validate([
			'trmnl_name' => 'required',
			'trmnl_address' => 'required',
			'trmnl_city' => 'required',
		]);
		
		$gf_facility = \App\Models\GeofenceFacility::where('facility_name', $request->trmnl_geofence_facility)->first();
		
		$trmnl = Terminal::where('id', $request->id)->first();
		$trmnl->trmnl_name = $request->trmnl_name;
		$trmnl->trmnl_address = $request->trmnl_address;
		$trmnl->trmnl_city = $request->trmnl_city;
		$trmnl->trmnl_province = $request->trmnl_province;
		$trmnl->trmnl_postcode = $request->trmnl_postcode;
		$trmnl->trmnl_country = $request->trmnl_country;
		$trmnl->trmnl_area = $request->trmnl_area;
		$trmnl->trmnl_contact = $request->trmnl_contact;
		$trmnl->trmnl_tel = $request->trmnl_tel;
		$trmnl->trmnl_fax = $request->trmnl_fax;
		$trmnl->trmnl_email = $request->trmnl_email;
		$trmnl->trmnl_cutoff_time = $request->trmnl_cutoff_time;
		if ($request->trmnl_no_sig_required == 'on') {
			$trmnl->trmnl_no_sig_required = 1;
		} else {
			$trmnl->trmnl_no_sig_required = 0;
		}
		if ($gf_facility) {
			$trmnl->trmnl_geofence_facility = $gf_facility->id;
		}
		$trmnl->trmnl_latitude = $request->trmnl_latitude;
		$trmnl->trmnl_longitude = $request->trmnl_longitude;
		$trmnl->trmnl_arrived_latitude = $request->trmnl_arrived_latitude;
		$trmnl->trmnl_arrived_longitude = $request->trmnl_arrived_longitude;
		$trmnl->trmnl_arrived_radius = $request->trmnl_arrived_radius;
		$trmnl->trmnl_halo_center_latitude = $request->trmnl_halo_center_latitude;
		$trmnl->trmnl_halo_center_longitude = $request->trmnl_halo_center_longitude;
		$trmnl->trmnl_halo_center_radius = $request->trmnl_halo_center_radius;
		$trmnl->trmnl_ingate_latitude = $request->trmnl_ingate_latitude;
		$trmnl->trmnl_ingate_longitude = $request->trmnl_ingate_longitude;
		$trmnl->trmnl_ingate_radius = $request->trmnl_ingate_radius;
		$trmnl->trmnl_outgate1_latitude = $request->trmnl_outgate1_latitude;
		$trmnl->trmnl_outgate1_longitude = $request->trmnl_outgate1_longitude;
		$trmnl->trmnl_outgate1_radius = $request->trmnl_outgate1_radius;
		$trmnl->trmnl_outgate2_latitude = $request->trmnl_outgate2_latitude;
		$trmnl->trmnl_outgate2_longitude = $request->trmnl_outgate2_longitude;
		$trmnl->trmnl_outgate2_radius = $request->trmnl_outgate2_radius;
		$saved = $trmnl->save();
		
		if(!$saved) {
			return redirect()->route('op_result.terminal')->with('status', ' <span style="color:red">Data has NOT been updated!</span>');
		} else {
			return redirect()->route('op_result.terminal')->with('status', 'The terminal,  <span style="font-weight:bold;font-style:italic;color:blue">'.$trmnl->trmnl_name.'</span>, has been updated successfully.');
		}
    }
}
