<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PowerUnit;

class PowerUnitController extends Controller
{
    public function store(Request $request)
    {
		$validated = $request->validate([
			'unit_id' => 'required',
			'make' => 'required',
			'plate_number' => 'required',
			'vin' => 'required',
		]);
		
		$unitIdExists = PowerUnit::where('unit_id', $request->unit_id)->first();
		$pltNoExists = PowerUnit::where('plate_number', $request->plate_number)->first();
		$vinExists = PowerUnit::where('vin', $request->vin)->first();
		if ($unitIdExists || $pltNoExists || $vinExists) {
			return redirect('power_unit_result')->with('status', ' <span style="color:red">Data cannot NOT be inserted as some unique value exists already!</span>');
		} else {
			$unit = new PowerUnit;
			$unit->unit_id = $request->unit_id;
			$unit->year = $request->year;
			$unit->make = $request->make;
			$unit->color = $request->color;
			$unit->plate_number = $request->plate_number;
			$unit->seniority = $request->seniority;
			$unit->vin = $request->vin;
			$unit->max_licensed_weight = $request->max_licensed_weight;
			$unit->ops_code = $request->ops_code;
			$unit->cargo_weight = $request->cargo_weight;
			$unit->current_driver = $request->current_driver;
			$unit->last_driver = $request->last_driver;
			$unit->current_location = $request->current_location;
			$unit->mvi_expiry_date = $request->mvi_expiry_date;
			$unit->insurance_expiry_date = $request->insurance_expiry_date;
			$saved = $unit->save();
			
			if(!$saved) {
				return redirect()->route('op_result.unit')->with('status', ' <span style="color:red">Data Has NOT Been inserted!</span>');
			} else {
				return redirect()->route('op_result.unit')->with('status', 'The new power unit,  <span style="font-weight:bold;font-style:italic;color:blue">'.$request->unit_id.'</span>, has been inserted successfully.');
			}
		}
    }
	
    public function update(Request $request)
    {
		$validated = $request->validate([
			'unit_id' => 'required',
			'make' => 'required',
			'plate_number' => 'required',
			'vin' => 'required',
		]);
		
		
		$unit = PowerUnit::where('unit_id', $request->unit_id)->first();
		$unit->unit_id = $request->unit_id;
		$unit->make = $request->make;
		$unit->plate_number = $request->plate_number;
		$unit->vin = $request->vin;
		$unit->ops_code = $request->ops_code;
		$unit->current_driver = $request->current_driver;
		$unit->current_location = $request->current_location;
		$unit->insurance_expiry_date = $request->insurance_expiry_date;
		$saved = $unit->save();
		
		if(!$saved) {
			return redirect()->route('op_result.unit')->with('status', ' <span style="color:red">Data has NOT been updated!</span>');
		} else {
			return redirect()->route('op_result.unit')->with('status', 'The power unit,  <span style="font-weight:bold;font-style:italic;color:blue">'.$unit->plate_number.'</span>, has been updated successfully.');
		}
    }
}
