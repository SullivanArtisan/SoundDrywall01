<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Helper\MyHelper;
use Illuminate\Support\Facades\Auth;
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

        MyHelper::LogStaffAction(Auth::user()->id, 'Added client '.$request->clnt_name.' (city= '.$request->clnt_city.').', '');
		
        $client = new Client;
        if ($client) {
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
                Log::Info('Staff '.Auth::user()->id.' failed to add the new client'.$request->clnt_name);
                return redirect()->route('op_result.client')->with('status', ' <span style="color:red">Data Has NOT Been inserted!</span>');
            } else {
                MyHelper::LogStaffActionResult(Auth::user()->id, 'Added client OK.', '');
                return redirect()->route('op_result.client')->with('status', 'The new client,  <span style="font-weight:bold;font-style:italic;color:blue">'.$client->clnt_name.'</span>, has been inserted successfully.');
            }
        } else {
            Log::Info('Staff '.Auth::user()->id.' tried to add a new client, but the client object cannot be created');
            return redirect()->route('op_result.client')->with('status', ' <span style="color:red">The client object cannot be created!</span>');
        }
    }
	
    public function update(Request $request)
    {
		$validated = $request->validate([
			'clnt_name' => 'required',
			'clnt_address' => 'required',
			'clnt_city' => 'required',
		]);

		MyHelper::LogStaffAction(Auth::user()->id, 'Updated client '.$request->clnt_name.' (city= '.$request->clnt_city.').', '');
		
		$client = Client::where('id', $request->id)->first();
		if ($client) {
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
				Log::Info('Staff '.Auth::user()->id.' failed to update the client'.$request->clnt_name);
				return redirect()->route('op_result.client')->with('status', ' <span style="color:red">Data Has NOT Been updated!</span>');
			} else {
                MyHelper::LogStaffActionResult(Auth::user()->id, 'Updated client '.$client->id.' OK.', '');
				return redirect()->route('op_result.client')->with('status', 'The client,  <span style="font-weight:bold;font-style:italic;color:blue">'.$client->clnt_name.'</span>, has been updated successfully.');
			}
		} else {
			Log::Info('Staff '.Auth::user()->id.' tried to update a client, but the client object cannot be accessed');
			return redirect()->route('op_result.client')->with('status', ' <span style="color:red">The client object cannot be accessed!</span>');
		}
    }

    public function delete(Request $request)
    {
        try {
            $id = $_GET['id'];

            MyHelper::LogStaffAction(Auth::user()->id, 'Deleted client of ID '.$id, '');

            $client = Client::where('id', $id)->first();
            if ($client) {
                $clientName = $client->clnt_name;
                $client->clnt_deleted    = "Y";
                $res = $client->save();
                if (!$res) {
                    $err_msg = "Client ".$id." cannot be deleted.";
                    Log::Info($err_msg);
                    return redirect()->route('op_result.client')->with('status', 'The client, <span style="font-weight:bold;font-style:italic;color:red">'.$clientName.'</span>, cannot be deleted for some reason.');	
                } else {
                    MyHelper::LogStaffActionResult(Auth::user()->id, 'Deleted client '.$id.' OK.', '');
                    return redirect()->route('op_result.client')->with('status', 'The client, <span style="font-weight:bold;font-style:italic;color:blue">'.$clientName.'</span>, has been deleted successfully.');	
                }
            } else {
                Log::Info('Staff '.Auth::user()->id.' tried to delete a client, but the client '.$id.' object cannot be accessed');
                return redirect()->route('op_result.client')->with('status', ' <span style="color:red">The client object cannot be accessed!</span>');
            }
        } catch (Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }
    }
}
