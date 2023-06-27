<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserSysDetail;
use Illuminate\Support\Facades\Log;
use Mail;

class UserController extends Controller
{
    public function store(Request $request)
    {
		$validated = $request->validate([
			'name' => 'required',
			'email' => 'required',
			'password' => 'required|confirmed',
			'security_level' => 'required',
			'docket_prefix' => 'required',
			'next_docket_number' => 'required|numeric',
			'current_office' => 'required',
			'default_office' => 'required',
		]);
		
		$emailExists = User::where('email', $request->email)->first();
		if ($emailExists) {
			return redirect()->route('op_result.user')->with('status', ' <span style="color:red">Data cannot NOT be inserted as the email address exists already!</span>');
		} else {
			$user = new User;
			$user->name = $request->name;
			$user->email = $request->email;
			$user->password = password_hash($request->password, PASSWORD_DEFAULT);
			$user->security_level = $request->security_level;
			$user->docket_prefix = $request->docket_prefix;
			$user->next_docket_number = $request->next_docket_number;
			$user->address = $request->address;
			$user->town = $request->town;
			$user->county = $request->county;
			$user->postcode = $request->postcode;
			$user->country = $request->country;
			$user->work_phone = $request->work_phone;
			$user->home_phone = $request->home_phone;
			$user->mobile_phone = $request->mobile_phone;
			$user->email2 = $request->email2;
			$saved = $user->save();
			
			if(!$saved) {
				return redirect()->route('op_result.user')->with('status', ' <span style="color:red">Data Has NOT Been inserted!</span>');
			} else {
				$targetUser = User::where('email', $request->email)->get();
				
				$userDetails = new UserSysDetail;
				$userDetails->user_id = $targetUser[0]->id;
				$userDetails->current_office = $request->current_office;
				$userDetails->default_office = $request->default_office;
				if ($request->can_change_office == 'on') {
					$userDetails->can_change_office = 1;
				} else {
					$userDetails->can_change_office = 0;
				}
				//$userDetails->currently_logged_in = $request->currently_logged_in;
				if ($request->startup_caps_lock_on == 'on') {
					$userDetails->startup_caps_lock_on = 1;
				} else {
					$userDetails->startup_caps_lock_on = 0;
				}
				if ($request->startup_num_lock_on == 'on') {
					$userDetails->startup_num_lock_on = 1;
				} else {
					$userDetails->startup_num_lock_on = 0;
				}
				if ($request->startup_insert_on == 'on') {
					$userDetails->startup_insert_on = 1;
				} else {
					$userDetails->startup_insert_on = 0;
				}
				$userDetails->ops_code = $request->ops_code;
				if ($request->show_mobile_data_messages == 'on') {
					$userDetails->show_mobile_data_messages = 1;
				} else {
					$userDetails->show_mobile_data_messages = 0;
				}
				if ($request->show_internet_bookings == 'on') {
					$userDetails->show_internet_bookings = 1;
				} else {
					$userDetails->show_internet_bookings = 0;
				}
				if ($request->show_incoming_control_emails == 'on') {
					$userDetails->show_incoming_control_emails = 1;
				} else {
					$userDetails->show_incoming_control_emails = 0;
				}
				$userDetails->picture_file = $request->picture_file;
				$saved = $userDetails->save();

				if(!$saved) {
					return redirect()->route('op_result.user')->with('status', ' <span style="color:red">Data has NOT been inserted!</span>');
				} else {
					if ($request->email_password == 'on') {
						$emailBody = array('name'=>$request->name, 'status'=>'Your account has been created successfully with temporart password: '.$request->password.'. Please change it ASAP!');
						$toAddr = $request->email;
						Mail::send(['text'=>'mail_ok_notice'], $emailBody, function($message) use($toAddr) {
							$message->to($toAddr, 'HarbourLink Administration')->subject('Congratulations!!');
						});
					}
					return redirect()->route('op_result.user')->with('status', 'The new user,  <span style="font-weight:bold;font-style:italic;color:blue">'.$targetUser[0]->name.'</span>, has been inserted successfully.');
				}
			}
		}
    }
	
    public function update(Request $request)
    {
		$validated = $request->validate([
			'name' => 'required',
			'email' => 'required',
			'security_level' => 'required',
			'docket_prefix' => 'required',
			'next_docket_number' => 'required|numeric',
			'current_office' => 'required',
			'default_office' => 'required',
		]);
		
		//$emailExists = User::where('email', $request->email)->first();
		//if ($emailExists) {
		//	return redirect()->route('op_result.user')->with('status', ' <span style="color:red">Data cannot NOT be updated as the email address exists already!</span>'.$request->ops_code);
		//} else {
			$user = User::where('email', $request->email)->first();
			$user->name = $request->name;
			//$user->email = $request->email;
			$user->password = password_hash($request->password, PASSWORD_DEFAULT);
			$user->security_level = $request->security_level;
			$user->docket_prefix = $request->docket_prefix;
			$user->next_docket_number = $request->next_docket_number;
			$user->address = $request->address;
			$user->town = $request->town;
			$user->county = $request->county;
			$user->postcode = $request->postcode;
			$user->country = $request->country;
			$user->work_phone = $request->work_phone;
			$user->home_phone = $request->home_phone;
			$user->mobile_phone = $request->mobile_phone;
			$user->email2 = $request->email2;
			$saved = $user->save();
			
			if(!$saved) {
				return redirect()->route('op_result.user')->with('status', ' <span style="color:red">Data Has NOT Been updated!</span>');
			} else {
				$userDetails = UserSysDetail::where('user_id', $user->id)->first();
				//$userDetails->user_id = $targetUser[0]->id;
				$userDetails->current_office = $request->current_office;
				$userDetails->default_office = $request->default_office;
				if ($request->can_change_office == 'on') {
					$userDetails->can_change_office = 1;
				} else {
					$userDetails->can_change_office = 0;
				}
				//$userDetails->currently_logged_in = $request->currently_logged_in;
				if ($request->startup_caps_lock_on == 'on') {
					$userDetails->startup_caps_lock_on = 1;
				} else {
					$userDetails->startup_caps_lock_on = 0;
				}
				if ($request->startup_num_lock_on == 'on') {
					$userDetails->startup_num_lock_on = 1;
				} else {
					$userDetails->startup_num_lock_on = 0;
				}
				if ($request->startup_insert_on == 'on') {
					$userDetails->startup_insert_on = 1;
				} else {
					$userDetails->startup_insert_on = 0;
				}
				$userDetails->ops_code = $request->ops_code;
				if ($request->show_mobile_data_messages == 'on') {
					$userDetails->show_mobile_data_messages = 1;
				} else {
					$userDetails->show_mobile_data_messages = 0;
				}
				if ($request->show_internet_bookings == 'on') {
					$userDetails->show_internet_bookings = 1;
				} else {
					$userDetails->show_internet_bookings = 0;
				}
				$userDetails->show_incoming_control_emails = $request->show_incoming_control_emails;
				if ($request->show_incoming_control_emails == 'on') {
					$userDetails->show_incoming_control_emails = 1;
				} else {
					$userDetails->show_incoming_control_emails = 0;
				}
				$userDetails->picture_file = $request->picture_file;
				$saved = $userDetails->save();

				if(!$saved) {
					return redirect()->route('op_result.user')->with('status', ' <span style="color:red">Data has NOT been updated!</span>');
				} else {
					return redirect()->route('op_result.user')->with('status', 'The user,  <span style="font-weight:bold;font-style:italic;color:blue">'.$user->name.'</span>, has been updated successfully.');
				}
			}
		//}
    }
}
