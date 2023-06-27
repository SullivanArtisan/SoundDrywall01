<?php

namespace App\Http\Controllers;

use App\Models\Chassis;
use Illuminate\Http\Request;

class ChassisController extends Controller
{
    public function store(Request $request)
    {
		$validated = $request->validate([
			'code'              => 'required',
			'currentlocation'   => 'required',
		]);
		
		$chassis = new Chassis;
		$chassis->code              = $request->code;
		$chassis->vin               = $request->vin;
		$chassis->year              = $request->year;
		$chassis->type              = $request->type;
		$chassis->owner             = $request->owner;
		$chassis->licence           = $request->licence;
		$chassis->driver            = $request->driver;
		$chassis->lastdriver        = $request->lastdriver;
		$chassis->container         = $request->container;
		$chassis->genset            = $request->genset;
		$chassis->currentlocation   = $request->currentlocation;
		$chassis->dateupdated       = $request->dateupdated;
		$chassis->pminspection      = $request->pminspection;
		$chassis->cviinspection     = $request->cviinspection;
		if ($request->leased == 'on') {
			$chassis->leased = "T";
		} else {
			$chassis->leased = "F";
		}
		if ($request->unconfirmed == 'on') {
			$chassis->unconfirmed = "T";
		} else {
			$chassis->unconfirmed = "F";
		}
		$chassis->alias1    = $request->alias1;
		$chassis->alias2    = $request->alias2;
		$chassis->alias3    = $request->alias3;
		$chassis->alias4    = $request->alias4;
		$saved = $chassis->save();
		
		if(!$saved) {
			return redirect()->route('op_result.chassis')->with('status', ' <span style="color:red">Data Has NOT Been inserted!</span>');
		} else {
			return redirect()->route('op_result.chassis')->with('status', 'The chassis <span style="font-weight:bold;font-style:italic;color:blue">'.$chassis->code.'</span>, has been inserted successfully.');
		}
    }

    public function update(Request $request)
    {
		$validated = $request->validate([
			'code'              => 'required',
			'currentlocation'   => 'required',
		]);
		
		$chassis = Chassis::where('id', $request->id)->first();
		$chassis->code              = $request->code;
		$chassis->vin               = $request->vin;
		$chassis->year              = $request->year;
		$chassis->type              = $request->type;
		$chassis->owner             = $request->owner;
		$chassis->licence           = $request->licence;
		$chassis->driver            = $request->driver;
		$chassis->lastdriver        = $request->lastdriver;
		$chassis->container         = $request->container;
		$chassis->genset            = $request->genset;
		$chassis->currentlocation   = $request->currentlocation;
		$chassis->dateupdated       = $request->dateupdated;
		$chassis->pminspection      = $request->pminspection;
		$chassis->cviinspection     = $request->cviinspection;
		if ($request->leased == 'on') {
			$chassis->leased = "T";
		} else {
			$chassis->leased = "F";
		}
		if ($request->unconfirmed == 'on') {
			$chassis->unconfirmed = "T";
		} else {
			$chassis->unconfirmed = "F";
		}
		$chassis->alias1    = $request->alias1;
		$chassis->alias2    = $request->alias2;
		$chassis->alias3    = $request->alias3;
		$chassis->alias4    = $request->alias4;
		// if ($request->dvr_tls_license == 'on') {
		// 	$chassis->dvr_tls_license = 1;
		// } else {
		// 	$chassis->dvr_tls_license = 0;
		// }

		$saved = $chassis->save();
		
		if(!$saved) {
			return redirect()->route('op_result.chassis')->with('status', ' <span style="color:red">Data has NOT been updated!</span>');
		} else {
			return redirect()->route('op_result.chassis')->with('status', 'The chassis,  <span style="font-weight:bold;font-style:italic;color:blue">'.$chassis->code.'</span>, has been updated successfully.');
		}
    }
}
