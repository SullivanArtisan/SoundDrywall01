<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Zone;

class ZoneController extends Controller
{
    public function store(Request $request)
    {
		$validated = $request->validate([
			'zone_name' => 'required',
		]);
		
		$zone = new Zone;
		$zone->zone_name = $request->zone_name;
		$zone->zone_group = $request->zone_group;
		$zone->zone_description = $request->zone_description;
		$zone->zone_fsc_deduction = $request->zone_fsc_deduction;
		$saved = $zone->save();
		
		if(!$saved) {
			return redirect()->route('op_result.zone')->with('status', ' <span style="color:red">Data Has NOT Been inserted!</span>');
		} else {
			return redirect()->route('op_result.zone')->with('status', 'The new zone,  <span style="font-weight:bold;font-style:italic;color:blue">'.$request->zone_name.'</span>, has been inserted successfully.');
		}
    }
	
    public function update(Request $request)
    {
		$validated = $request->validate([
			'zone_name' => 'required',
		]);
		
		
		$zone = Zone::where('id', $request->id)->first();
		$zone->zone_name = $request->zone_name;
		$zone->zone_group = $request->zone_group;
		$zone->zone_description = $request->zone_description;
		$zone->zone_fsc_deduction = $request->zone_fsc_deduction;
		$saved = $zone->save();
		
		if(!$saved) {
			return redirect()->route('op_result.zone')->with('status', ' <span style="color:red">Data has NOT been updated!</span>');
		} else {
			return redirect()->route('op_result.zone')->with('status', 'The zone,  <span style="font-weight:bold;font-style:italic;color:blue">'.$zone->zone_name.'</span>, has been updated successfully.');
		}
    }
}
