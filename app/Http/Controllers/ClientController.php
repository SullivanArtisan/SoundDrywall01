<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function store(Request $request)
    {
		$validated = $request->validate([
			'clnt_name' => 'required',
			'clnt_address' => 'required',
			'clnt_city' => 'required',
		]);
		
        $client = new Client;
        $client->clnt_name        = $request->clnt_name;
        $client->clnt_address     = $request->clnt_address;
        $client->clnt_city        = $request->clnt_city;
        $client->clnt_province    = $request->clnt_province;
        $client->clnt_postcode    = $request->clnt_postcode;
        $client->clnt_country     = $request->clnt_country;
        $client->clnt_contact     = $request->clnt_contact;
        $client->clnt_phone       = $request->clnt_phone;
        $client->clnt_email       = $request->clnt_email;
        $client->clnt_email       = $request->clnt_email;
        $saved = $client->save();
        
        if(!$saved) {
            return redirect()->route('op_result.client')->with('status', ' <span style="color:red">Data Has NOT Been inserted!</span>');
        } else {
            return redirect()->route('op_result.client')->with('status', 'The new client,  <span style="font-weight:bold;font-style:italic;color:blue">'.$client->clnt_name.'</span>, has been inserted successfully.');
        }
    }
	
    public function update(Request $request)
    {
		$validated = $request->validate([
			'clnt_name' => 'required',
			'clnt_address' => 'required',
			'clnt_city' => 'required',
		]);
		
			$client = Client::where('id', $request->id)->first();
			$client->clnt_name        = $request->clnt_name;
			$client->clnt_address     = $request->clnt_address;
			$client->clnt_city        = $request->clnt_city;
			$client->clnt_province    = $request->clnt_province;
			$client->clnt_postcode    = $request->clnt_postcode;
			$client->clnt_country     = $request->clnt_country;
			$client->clnt_contact     = $request->clnt_contact;
			$client->clnt_phone       = $request->clnt_phone;
			$client->clnt_email       = $request->clnt_email;
			$client->clnt_email       = $request->clnt_email;
			$saved = $client->save();
			
			if(!$saved) {
				return redirect()->route('op_result.client')->with('status', ' <span style="color:red">Data Has NOT Been updated!</span>');
			} else {
				return redirect()->route('op_result.client')->with('status', 'The client,  <span style="font-weight:bold;font-style:italic;color:blue">'.$client->clnt_name.'</span>, has been updated successfully.');
			}
		//}
    }
}
