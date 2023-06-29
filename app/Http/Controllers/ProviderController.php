<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    public function store(Request $request)
    {
		$validated = $request->validate([
			'pvdr_name' => 'required',
			'pvdr_address' => 'required',
			'pvdr_city' => 'required',
		]);
		
        $provider = new Provider;
        $provider->pvdr_name        = $request->pvdr_name;
        $provider->pvdr_address     = $request->pvdr_address;
        $provider->pvdr_city        = $request->pvdr_city;
        $provider->pvdr_province    = $request->pvdr_province;
        $provider->pvdr_postcode    = $request->pvdr_postcode;
        $provider->pvdr_country     = $request->pvdr_country;
        $provider->pvdr_contact     = $request->pvdr_contact;
        $provider->pvdr_phone       = $request->pvdr_phone;
        $provider->pvdr_email       = $request->pvdr_email;
        $provider->pvdr_email       = $request->pvdr_email;
        $saved = $provider->save();
        
        if(!$saved) {
            return redirect()->route('op_result.provider')->with('status', ' <span style="color:red">Data Has NOT Been inserted!</span>');
        } else {
            return redirect()->route('op_result.provider')->with('status', 'The new provider,  <span style="font-weight:bold;font-style:italic;color:blue">'.$provider->pvdr_name.'</span>, has been inserted successfully.');
        }
    }
	
    public function update(Request $request)
    {
		$validated = $request->validate([
			'pvdr_name' => 'required',
			'pvdr_address' => 'required',
			'pvdr_city' => 'required',
		]);
		
			$provider = Provider::where('id', $request->id)->first();
			$provider->pvdr_name        = $request->pvdr_name;
			$provider->pvdr_address     = $request->pvdr_address;
			$provider->pvdr_city        = $request->pvdr_city;
			$provider->pvdr_province    = $request->pvdr_province;
			$provider->pvdr_postcode    = $request->pvdr_postcode;
			$provider->pvdr_country     = $request->pvdr_country;
			$provider->pvdr_contact     = $request->pvdr_contact;
			$provider->pvdr_phone       = $request->pvdr_phone;
			$provider->pvdr_email       = $request->pvdr_email;
			$provider->pvdr_email       = $request->pvdr_email;
			$saved = $provider->save();
			
			if(!$saved) {
				return redirect()->route('op_result.provider')->with('status', ' <span style="color:red">Data Has NOT Been updated!</span>');
			} else {
				return redirect()->route('op_result.provider')->with('status', 'The provider,  <span style="font-weight:bold;font-style:italic;color:blue">'.$provider->pvdr_name.'</span>, has been updated successfully.');
			}
		//}
    }
}
