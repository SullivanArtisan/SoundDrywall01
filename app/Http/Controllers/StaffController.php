<?php

namespace App\Http\Controllers;

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
			'roll'   => 'required',
			'password'  => 'required',
            'password2' => 'required',
			'assigned_job_id'   => 'required',
		]);
		
		$emailExists = Staff::where('email', $request->email)->first();
		if ($emailExists) {
			return redirect()->route('op_result.staff')->with('status', ' <span style="color:red">Data cannot NOT be inserted as the email address exists already!</span>');
		} else {
			$staff = new Staff;
			$staff->f_name 		= $request->f_name;
			$staff->l_name 		= $request->l_name;
			$staff->password 	= password_hash($request->password, PASSWORD_DEFAULT);
			$staff->address 	= $request->address;
			$staff->city 		= $request->city;
			$staff->province 	= $request->province;
			$staff->postcode 	= $request->postcode;
			$staff->country 	= $request->country;
			$staff->email 		= $request->email;
			$staff->roll 		= $request->roll;
			$staff->work_phone 		= $request->work_phone;
			$staff->home_phone 		= $request->home_phone;
			$staff->mobile_phone	= $request->mobile_phone;
			$staff->assigned_job_id	= $request->assigned_job_id;
			$saved = $staff->save();
			
			if(!$saved) {
				return redirect()->route('op_result.staff')->with('status', ' <span style="color:red">Data Has NOT Been inserted!</span>');
			} else {
				return redirect()->route('op_result.staff')->with('status', 'The new staff,  <span style="font-weight:bold;font-style:italic;color:blue">'.$staff->f_name.' '.$staff->l_name.'</span>, has been inserted successfully.');
			}
		}
    }
	
    public function update(Request $request)
    {
		$validated = $request->validate([
			'f_name' => 'required',
			'l_name' => 'required',
			'email'  => 'required',
			'roll'   => 'required',
		]);
		
			$staff = Staff::where('id', $request->id)->first();
			$staff->f_name 		= $request->f_name;
			$staff->l_name 		= $request->l_name;
			$staff->password 	= password_hash($request->password, PASSWORD_DEFAULT);
			$staff->address 	= $request->address;
			$staff->city 		= $request->city;
			$staff->province 	= $request->province;
			$staff->postcode 	= $request->postcode;
			$staff->country 	= $request->country;
			$staff->email 		= $request->email;
			$staff->roll 		= $request->roll;
			$staff->work_phone 		= $request->work_phone;
			$staff->home_phone 		= $request->home_phone;
			$staff->mobile_phone	= $request->mobile_phone;

			$jobName = $request->assigned_job_id;
			if (strlen($jobName) == 0) {
				$staff->assigned_job_id	= 0;
			} else {
				$selJob = Job::where('job_name', $jobName)->first();
				if ($selJob) {
					$staff->assigned_job_id	= $selJob->id;
				} else {
					return redirect()->route('op_result.staff')->with('status', ' <span style="color:red">Staff\'s assigned job cannot NOT Been found!</span>');
				}
			}

			$saved = $staff->save();
			
			if(!$saved) {
				return redirect()->route('op_result.staff')->with('status', ' <span style="color:red">Data Has NOT Been updated!</span>');
			} else {
				return redirect()->route('op_result.staff')->with('status', 'The staff,  <span style="font-weight:bold;font-style:italic;color:blue">'.$staff->f_name.' '.$staff->l_name.'</span>, has been updated successfully.');
			}
		//}
    }
}
