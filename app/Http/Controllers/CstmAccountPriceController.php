<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\Customer;
use App\Models\CstmAccountPrice;
use Illuminate\Http\Request;

class CstmAccountPriceController extends Controller
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
			'cstm_account_from' => 'required',
			'cstm_account_to' => 'required',
			// 'cstm_account_charge' => 'required',
		]);
		$id = $_GET['id'];
		$customer = Customer::where('id', $id)->first();
		$accPrice = new CstmAccountPrice;
		$accPrice->cstm_account_no = $customer->cstm_account_no;
		$accPrice->cstm_account_chassis = $request->cstm_account_chassis;
		$accPrice->cstm_account_from = $request->cstm_account_from;
		$accPrice->cstm_account_to = $request->cstm_account_to;
		$accPrice->cstm_account_charge = $request->cstm_account_charge;
		$accPrice->cstm_account_fuel_surcharge = $request->cstm_account_fuel_surcharge;
		if ($request->cstm_account_surcharge_override == 'on') {
			$accPrice->cstm_account_surcharge_override = 1;
		} else {
			$accPrice->cstm_account_surcharge_override = 0;
		}
		$accPrice->cstm_account_job_type = $request->cstm_account_job_type;
		if ($request->cstm_account_one_way == 'on') {
			$accPrice->cstm_account_one_way = 1;
		} else {
			$accPrice->cstm_account_one_way = 0;
		}
		$accPrice->cstm_account_mt_return = $request->cstm_account_mt_return;
		$saved = $accPrice->save();
		
		if(!$saved) {
			return redirect()->route('op_result.accprice')->with('status', ' <span style="color:red">Data Has NOT Been inserted!</span>');
		} else {
			return redirect()->route('op_result.accprice')->with('status', 'The account price from zone <span style="font-weight:bold;font-style:italic;color:blue">'.$accPrice->cstm_account_from.' -> '.$accPrice->cstm_account_to.'</span>, has been inserted successfully.');
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CstmAccountPrice  $cstmAccountPrice
     * @return \Illuminate\Http\Response
     */
    public function show(CstmAccountPrice $cstmAccountPrice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CstmAccountPrice  $cstmAccountPrice
     * @return \Illuminate\Http\Response
     */
    public function edit(CstmAccountPrice $cstmAccountPrice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CstmAccountPrice  $cstmAccountPrice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
		$validated = $request->validate([
			'cstm_account_from' => 'required',
			'cstm_account_to' => 'required',
			'cstm_account_charge' => 'required',
		]);
		
		// Prepare the data in customer's Contact tab
		$accPrice = CstmAccountPrice::where('id', $request->account_price_id)->first();
		$accPrice->cstm_account_chassis = $request->cstm_account_chassis;
		$accPrice->cstm_account_from = $request->cstm_account_from;
		$accPrice->cstm_account_to = $request->cstm_account_to;
		$accPrice->cstm_account_charge = $request->cstm_account_charge;
		$accPrice->cstm_account_fuel_surcharge = $request->cstm_account_fuel_surcharge;
		if ($request->cstm_account_surcharge_override == 'on') {
			$accPrice->cstm_account_surcharge_override = 1;
		} else {
			$accPrice->cstm_account_surcharge_override = 0;
		}
		$accPrice->cstm_account_job_type = $request->cstm_account_job_type;
		if ($request->cstm_account_one_way == 'on') {
			$accPrice->cstm_account_one_way = 1;
		} else {
			$accPrice->cstm_account_one_way = 0;
		}
		$accPrice->cstm_account_mt_return = $request->cstm_account_mt_return;
		$saved = $accPrice->save();
		
		if(!$saved) {
			return redirect()->route('op_result.accprice')->with('status', ' <span style="color:red">Data Has NOT Been updated!</span>');
		} else {
			return redirect()->route('op_result.accprice')->with('status', 'The account price from zone <span style="font-weight:bold;font-style:italic;color:blue">'.$accPrice->cstm_account_from.' -> '.$accPrice->cstm_account_to.'</span>, has been updated successfully.');
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CstmAccountPrice  $cstmAccountPrice
     * @return \Illuminate\Http\Response
     */
    public function destroy(CstmAccountPrice $cstmAccountPrice)
    {
        //
    }
}
