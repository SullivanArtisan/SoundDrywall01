<?php

namespace App\Http\Controllers;

use App\Models\DriverPrices;
use Illuminate\Http\Request;

class DriverPricesController extends Controller
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
			'drvr_pay_price_zone_from' => 'required',
			'drvr_pay_price_zone_to' => 'required',
			'drvr_pay_price_charge' => 'required',
		]);
		
		$dvrPrice = new DriverPrices;
		$dvrPrice->drvr_pay_price_chassis = $request->drvr_pay_price_chassis;
		$dvrPrice->drvr_pay_price_zone_from = $request->drvr_pay_price_zone_from;
		$dvrPrice->drvr_pay_price_zone_to = $request->drvr_pay_price_zone_to;
		$dvrPrice->drvr_pay_price_charge = $request->drvr_pay_price_charge;
		$dvrPrice->drvr_pay_price_job_type = $request->drvr_pay_price_job_type;
		if ($request->drvr_pay_price_one_way == 'on') {
			$dvrPrice->drvr_pay_price_one_way = 1;
		} else {
			$dvrPrice->drvr_pay_price_one_way = 0;
		}
		$dvrPrice->drvr_pay_price_notes = $request->drvr_pay_price_notes;
		$saved = $dvrPrice->save();
		
		if(!$saved) {
			return redirect()->route('op_result.driver_price')->with('status', ' <span style="color:red">Data Has NOT Been inserted!</span>');
		} else {
			return redirect()->route('op_result.driver_price')->with('status', 'The driver price from zone <span style="font-weight:bold;font-style:italic;color:blue">'.$dvrPrice->drvr_pay_price_zone_from.' -> '.$dvrPrice->drvr_pay_price_zone_to.'</span>, has been inserted successfully.');
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DriverPrices  $driverPrices
     * @return \Illuminate\Http\Response
     */
    public function show(DriverPrices $driverPrices)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DriverPrices  $driverPrices
     * @return \Illuminate\Http\Response
     */
    public function edit(DriverPrices $driverPrices)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DriverPrices  $driverPrices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DriverPrices $driverPrices)
    {
		$validated = $request->validate([
			'drvr_pay_price_zone_from' => 'required',
			'drvr_pay_price_zone_to' => 'required',
			'drvr_pay_price_charge' => 'required',
		]);
		
		$price = DriverPrices::where('id', $request->id)->first();
		$price->drvr_pay_price_chassis = $request->drvr_pay_price_chassis;
		$price->drvr_pay_price_zone_from = $request->drvr_pay_price_zone_from;
		$price->drvr_pay_price_zone_to = $request->drvr_pay_price_zone_to;
		$price->drvr_pay_price_job_type = $request->drvr_pay_price_job_type;
		$price->drvr_pay_price_charge = $request->drvr_pay_price_charge;
		if ($request->drvr_pay_price_one_way == 'on') {
			$price->drvr_pay_price_one_way = 1;
		} else {
			$price->drvr_pay_price_one_way = 0;
		}
		$price->drvr_pay_price_notes = $request->drvr_pay_price_notes;
		$saved = $price->save();
		
		if(!$saved) {
			return redirect()->route('op_result.driver_price')->with('status', ' <span style="color:red">Data Has NOT Been updated!</span>');
		} else {
			return redirect()->route('op_result.driver_price')->with('status', 'The drive price from zone <span style="font-weight:bold;font-style:italic;color:blue">'.$price->drvr_pay_price_zone_from.' -> '.$price->drvr_pay_price_zone_to.'</span>, has been updated successfully.');
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DriverPrices  $driverPrices
     * @return \Illuminate\Http\Response
     */
    public function destroy(DriverPrices $driverPrices)
    {
        //
    }
}
