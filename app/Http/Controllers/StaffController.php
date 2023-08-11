<?php

namespace App\Http\Controllers;

use App\Helper\MyHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Staff;
use Illuminate\Support\Facades\Log;
use Mail;

class StaffController extends Controller
{
    public function store(Request $request)
    {
		$validated = $request->validate([
			'f_name' => 'required',
			'l_name' => 'required',
			'email'  => 'required',
			'role'   => 'required',
			'password'  => 'required',
            'password2' => 'required',
		]);
		
		$emailExists = Staff::where('email', $request->email)->first();
		if ($emailExists) {
			Log::Info('Staff '.Auth::user()->id.' tried to add a new staff, but the input email address '.$request->email.' already existed!');
			return redirect()->route('op_result.staff')->with('status', ' <span style="color:red">Data cannot NOT be inserted as the email address exists already!</span>');
		} else {
            MyHelper::LogStaffAction(Auth::user()->id, 'Added staff '.$request->f_name.' '.$request->l_name.' (email= '.$request->email.').', '');

			$staff = new Staff;

			if ($staff) {
				$staff->f_name 		= $request->f_name;
				$staff->l_name 		= $request->l_name;
				$staff->status 		= 'CREATED';
				$staff->password 	= password_hash($request->password, PASSWORD_DEFAULT);
				$staff->address 	= $request->address;
				$staff->city 		= $request->city;
				$staff->province 	= $request->province;
				$staff->postcode 	= $request->postcode;
				$staff->country 	= $request->country;
				$staff->email 		= $request->email;
				$staff->role 		= $request->role;
				$staff->work_phone 		= $request->work_phone;
				$staff->home_phone 		= $request->home_phone;
				$staff->mobile_phone	= $request->mobile_phone;
				$saved = $staff->save();
				
				if(!$saved) {
					Log::Info('Staff '.Auth::user()->id.' failed to add the new staff'.$request->f_name.' '.$request->l_name);
					return redirect()->route('op_result.staff')->with('status', ' <span style="color:red">Data Has NOT Been inserted!</span>');
				} else {
					MyHelper::LogStaffActionResult(Auth::user()->id, 'Added staff OK.', '');
					return redirect()->route('op_result.staff')->with('status', 'The new staff,  <span style="font-weight:bold;font-style:italic;color:blue">'.$staff->f_name.' '.$staff->l_name.'</span>, has been inserted successfully.');
				}
			} else {
				Log::Info('Staff '.Auth::user()->id.' tried to add a new staff, but the staff object cannot be created');
				return redirect()->route('op_result.staff')->with('status', ' <span style="color:red">The staff object cannot be created!</span>');
			}
		}
    }
	
    public function update(Request $request)
    {
		$validated = $request->validate([
			'f_name' => 'required',
			'l_name' => 'required',
			'email'  => 'required',
			'role'   => 'required',
		]);

		MyHelper::LogStaffAction(Auth::user()->id, 'Updated staff '.$request->f_name.' '.$request->l_name.' (email= '.$request->email.').', '');
		
		$staff = Staff::where('id', $request->id)->first();
		if ($staff) {
			$staff->f_name 		= $request->f_name;
			$staff->l_name 		= $request->l_name;
			$staff->password 	= password_hash($request->password, PASSWORD_DEFAULT);
			$staff->address 	= $request->address;
			$staff->city 		= $request->city;
			$staff->province 	= $request->province;
			$staff->postcode 	= $request->postcode;
			$staff->country 	= $request->country;
			$staff->email 		= $request->email;
			$staff->role 		= $request->role;
			$staff->work_phone 		= $request->work_phone;
			$staff->home_phone 		= $request->home_phone;
			$staff->mobile_phone	= $request->mobile_phone;

			$saved = $staff->save();
			
			if(!$saved) {
				Log::Info('Staff '.Auth::user()->id.' failed to update the staff'.$request->f_name.' '.$request->l_name);
				return redirect()->route('op_result.staff')->with('status', ' <span style="color:red">Data Has NOT Been updated!</span>');
			} else {
                MyHelper::LogStaffActionResult(Auth::user()->id, 'Updated staff '.$staff->id.' OK.', '');
				return redirect()->route('op_result.staff')->with('status', 'The staff,  <span style="font-weight:bold;font-style:italic;color:blue">'.$staff->f_name.' '.$staff->l_name.'</span>, has been updated successfully.');
			}
		} else {
			Log::Info('Staff '.Auth::user()->id.' tried to update a staff, but the staff object cannot be accessed');
			return redirect()->route('op_result.staff')->with('status', ' <span style="color:red">The staff object cannot be accessed!</span>');
		}
    }

    public function delete(Request $request)
    {
        try {
            $id = $_GET['id'];

            MyHelper::LogStaffAction(Auth::user()->id, 'Deleted staff of ID '.$id, '');

			$staff = Staff::where('id', $id)->first();
            if ($staff) {
				$staffName = $staff->f_name." ".$staff->l_name;
				$staff->status = 'DELETED';
				$res = $staff->save();
				if (!$res) {
                    $err_msg = "Staff ".$id." cannot be deleted.";
                    Log::Info($err_msg);
					return redirect()->route('op_result.staff')->with('status', 'The staff, <span style="font-weight:bold;font-style:italic;color:red">'.$staffName.'</span>, cannot be deleted for some reason.');	
                } else {
                    MyHelper::LogStaffActionResult(Auth::user()->id, 'Deleted staff '.$id.' OK.', '');
					return redirect()->route('op_result.staff')->with('status', 'The staff, <span style="font-weight:bold;font-style:italic;color:blue">'.$staffName.'</span>, has been deleted successfully.');	
                }
            } else {
                Log::Info('Staff '.Auth::user()->id.' tried to delete a staff, but the staff '.$id.' object cannot be accessed');
                return redirect()->route('op_result.staff')->with('status', ' <span style="color:red">The staff object cannot be accessed!</span>');
            }
        } catch (Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }
    }
}
