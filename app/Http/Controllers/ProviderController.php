<?php

namespace App\Http\Controllers;

use App\Helper\MyHelper;
use Illuminate\Support\Facades\Auth;
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

		MyHelper::LogStaffAction(Auth::user()->id, 'Added supplier '.$request->pvdr_name.' '.$request->l_name.' (city= '.$request->pvdr_city.').', '');
		
        $provider = new Provider;
		if ($provider) {
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
				Log::Info('Staff '.Auth::user()->id.' failed to add the new supplier'.$request->pvdr_name);
				return redirect()->route('op_result.provider')->with('status', ' <span style="color:red">Data Has NOT Been inserted!</span>');
			} else {
				MyHelper::LogStaffActionResult(Auth::user()->id, 'Added supplier OK.', '');
				return redirect()->route('op_result.provider')->with('status', 'The new supplier,  <span style="font-weight:bold;font-style:italic;color:blue">'.$provider->pvdr_name.'</span>, has been inserted successfully.');
			}
		} else {
			Log::Info('Staff '.Auth::user()->id.' tried to add a new supplier, but the supplier object cannot be created');
			return redirect()->route('op_result.provider')->with('status', ' <span style="color:red">The supplier object cannot be created!</span>');
		}
	}
	
    public function update(Request $request)
    {
		$validated = $request->validate([
			'pvdr_name' => 'required',
			'pvdr_address' => 'required',
			'pvdr_city' => 'required',
		]);

		MyHelper::LogStaffAction(Auth::user()->id, 'Updated supplier '.$request->id.' (name= '.$request->pvdr_name.').', '');
		
		$provider = Provider::where('id', $request->id)->first();
		if ($provider) {
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
				Log::Info('Staff '.Auth::user()->id.' failed to update the supplier'.$request->id);
				return redirect()->route('op_result.provider')->with('status', ' <span style="color:red">Data Has NOT Been updated!</span>');
			} else {
                MyHelper::LogStaffActionResult(Auth::user()->id, 'Updated supplier '.$request->id.' OK.', '');
				return redirect()->route('op_result.provider')->with('status', 'The supplier,  <span style="font-weight:bold;font-style:italic;color:blue">'.$provider->pvdr_name.'</span>, has been updated successfully.');
			}
		} else {
			Log::Info('Staff '.Auth::user()->id.' tried to update a supplier, but the supplier object cannot be accessed');
			return redirect()->route('op_result.provider')->with('status', ' <span style="color:red">The supplier object cannot be accessed!</span>');
		}
    }

    public function delete(Request $request)
    {
        try {
            $id = $_GET['id'];

            MyHelper::LogStaffAction(Auth::user()->id, 'Deleted staff of ID '.$id, '');

			$provider = Provider::where('id', $id)->first();
            if ($provider) {
				$providerName 			= $provider->pvdr_name;
                $provider->pvdr_deleted = "Y";
				$res = $provider->save();
				if (!$res) {
                    $err_msg = "Supplier ".$id." cannot be deleted.";
                    Log::Info($err_msg);
					return redirect()->route('op_result.provider')->with('status', 'The supplier, <span style="font-weight:bold;font-style:italic;color:red">'.$providerName.'</span>, cannot be deleted for some reason.');	
                } else {
                    MyHelper::LogStaffActionResult(Auth::user()->id, 'Deleted supplier '.$id.' OK.', '');
					return redirect()->route('op_result.provider')->with('status', 'The supplier, <span style="font-weight:bold;font-style:italic;color:blue">'.$providerName.'</span>, has been deleted successfully.');	
                }
            } else {
                Log::Info('Staff '.Auth::user()->id.' tried to delete a supplier, but the supplier '.$id.' object cannot be accessed');
                return redirect()->route('op_result.provider')->with('status', ' <span style="color:red">The supplier object cannot be accessed!</span>');
            }
        } catch (Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }
    }
}
