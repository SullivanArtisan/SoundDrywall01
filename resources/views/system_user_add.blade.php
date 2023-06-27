<?php
	use App\Models\User;
	use App\Models\UserSysDetail;
	use Illuminate\Support\Facades\Session;
?>

@extends('layouts.home_page_base')
<style>
.my-text-height {height:75%;}
</style>

@section('goback')
	<a class="text-primary" href="{{route('system_user_main')}}" style="margin-right: 10px;">Back</a>
@show

@section('function_page')
	<?php
		$picPath = Session::get('uploadPath');
		Session::forget(['uploadPath']);
	?>
	<div>
		<h2 class="text-muted pl-2 mb-2">Add a New System User</h2>
	</div>
    <div>
		@if ($errors->any())
			<div class="alert alert-danger">
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif
        <div class="row">
            <div class="col">
                <form method="post" action="{{route('op_result.system_user_add')}}">
					@csrf
                    <div class="row">
                        <div class="col"><label class="col-form-label">Name:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="name" name="name"></div>
                        <div class="col"><label class="col-form-label">Current Office:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="current_office" name="current_office"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Email:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1v" type="email" id="email" name="email"></div>
                        <div class="col"><label class="col-form-label">Default Office:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="default_office" name="default_office"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Password:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="password" id="password" name="password"></div>
                        <div class="col"><label class="col-form-label">Can Change Office:&nbsp;</label></div>
                        <div class="col"><input type="checkbox" style="margin-top:3%" id="can_change_office" name="can_change_office"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Confirm Password:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="password" id="password_confirmation" name="password_confirmation"></div>
                        <div class="col"><label class="col-form-label">Startup Caps Lock On:&nbsp;</label></div>
                        <div class="col"><input type="checkbox" style="margin-top:3%" id="startup_caps_lock_on" name="startup_caps_lock_on"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Security Level:</label></div>
						<!--
                        <div class="col"><input class="form-range form-control" type="range" name="security_level_id"></div>
						-->
						<div class="col">
							<input list="security_level" name="security_level" id="secLevelInput" class="form-control mt-1 my-text-height">
							<datalist id="security_level">
							<option value="Full Security">
							<option value="Admin">
							<option value="Operations Supervisor">
							<option value="Dispatch-Coordinator">
							<option value="Chassis">
							<option value="TIDEWATER-USERS">
							<option value="Accounting">
							<option value="Safety">
							<option value="Gatehouse">
							</datalist>
						</div>
                        <div class="col"><label class="col-form-label">Startup Num Lock On:&nbsp;</label></div>
                        <div class="col"><input type="checkbox" style="margin-top:3%" id="startup_num_lock_on" name="startup_num_lock_on"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Docket Prefix:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="docket_prefix" name="docket_prefix"></div>
                        <div class="col"><label class="col-form-label">Startup Insert On:&nbsp;</label></div>
                        <div class="col"><input type="checkbox" style="margin-top:3%" id="startup_insert_on" name="startup_insert_on"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Next Docket Number:&nbsp;&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="next_docket_number" name="next_docket_number"></div>
                        <div class="col"><label class="col-form-label">Ops Code:&nbsp;</label></div>
						<!--
                        <div class="col"><input class="form-range form-control" type="range" name="ops_code"></div>
						-->
						<?php
						$tagHead = "<div class=\"col\"><input list=\"ops_code\" name=\"ops_code\" id=\"opscodeinput\" class=\"form-control mt-1 my-text-height\"";
						$tagTail = "><datalist id=\"ops_code\">";

						$allTypes = MyHelper::GetAllOpsCodes();
						foreach($allTypes as $eachType) {
							$tagTail.= "<option value=".str_replace(' ', '&nbsp;', $eachType).">";
						}
						$tagTail.= "</datalist></div>";
						echo $tagHead."placeholder=\"\" value=\"\"".$tagTail;
						?>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Address:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="address" name="address"></div>
                        <div class="col"><label class="col-form-label">Show Mobile Data Messages:&nbsp;</label></div>
                        <div class="col"><input type="checkbox" style="margin-top:3%" id="show_mobile_data_messages" name="show_mobile_data_messages"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Town:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="town" name="town"></div>
                        <div class="col"><label class="col-form-label">Show Internet Bookings:&nbsp;</label></div>
                        <div class="col"><input type="checkbox" style="margin-top:3%" id="show_internet_bookings" name="show_internet_bookings"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">County:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="county" name="county"></div>
                        <div class="col"><label class="col-form-label">Show Incoming Control Emails:&nbsp;</label></div>
                        <div class="col"><input type="checkbox" style="margin-top:3%" id="show_incoming_control_emails" name="show_incoming_control_emails"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Postcode:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="postcode" name="postcode"></div>
                        <div class="col"><label class="col-form-label">Picture File:&nbsp;</label></div>
						<div class="col">
							<div class="row">
								<div class="col-9 pr-0"><input class="form-control mt-1 my-text-height" type="text" id="picture_file" name="picture_file"></div>
								<div class="col-3 pl-2"><button class="btn btn-secondary btn-sm mt-1" type="button" onclick="KeepInput()"><a href="{{route('system_user_pic_upload', 'noId=1')}}">Upload</a></button></div>
							</div>
						</div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Country:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="country" name="country"></div>
                        <div class="col"><label class="col-form-label">Email this User for the New Password:&nbsp</label></div>
                        <div class="col"><input type="checkbox" checked="true" style="margin-top:3%" id="email_password" name="email_password"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Work Tel Number:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="work_phone" name="work_phone"></div>
                        <div class="col"><label class="col-form-label"></label></div>
                        <div class="col"><input class="form-control mt-1" type="hidden"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Home Tel Number:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="home_phone" name="home_phone"></div>
                        <div class="col"><label class="col-form-label"></label></div>
                        <div class="col"><input class="form-control mt-1" type="hidden"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Mobile Tel Number:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="mobile_phone" name="mobile_phone"></div>
                        <div class="col"><label class="col-form-label"></label></div>
                        <div class="col"><input class="form-control mt-1" type="hidden"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Email2:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="email" id="email2" name="email2"></div>
                        <div class="col"><label class="col-form-label"></label></div>
                        <div class="col"><input class="form-control mt-1" type="hidden"></div>
                    </div>
                    <div class="row my-3">
                        <div class="w-25"></div>
                        <div class="col">
							<div class="row">
								<button class="btn btn-success mx-4" type="submit">Save</button>
								<button class="btn btn-secondary mx-3" type="button"><a href="{{route('system_user_main')}}">Cancel</a></button>
							</div>
						</div>
                        <div class="col"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
	<?php
		/*
		$user = \App\Models\User::where('id', Request::get('id'))->first();
		
		{{echo $user->email;}}

        $usrDtails = new UserSysDetail;
 
        $usrDtails->user_id = $user->id;
 
        $usrDtails->save();
		*/
	?>
	
	<script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.0/dist/js.cookie.min.js"></script>
	<script>
		var opsCodeInput = document.getElementById('opsCodeInput'); 			// give an id to your input and set it as variable
		opsCodeInput.value ='Local'; 											// set default value instead of html attribute
		opsCodeInput.onfocus = function() { opsCodeInput.value ='';} 			// on focus - clear input
		//opsCodeInput.onblur = function() { opsCodeInput.value ='Local';} 		// on leave restore it.
		var secLevelInput = document.getElementById('secLevelInput'); 			// give an id to your input and set it as variable
		secLevelInput.value ='Chassis'; 										// set default value instead of html attribute
		secLevelInput.onfocus = function() { secLevelInput.value ='';}			// on focus - clear input
		//secLevelInput.onblur = function() { secLevelInput.value ='Chassis';	// on leave restore it.
		
		var picPath = {!! json_encode($picPath) !!};
		document.getElementById('picture_file').value = picPath;
		
		var nu_name = Cookies.get('nu_name');
		if (nu_name)
			document.getElementById("name").value = nu_name;  
		var nu_current_office = Cookies.get('nu_current_office');
		if (nu_current_office)
			document.getElementById("current_office").value = Cookies.get('nu_current_office');  
		var nu_email = Cookies.get('nu_email');
		if (nu_email)
			document.getElementById("email").value = Cookies.get('nu_email');  
		var nu_default_office = Cookies.get('nu_default_office');
		if (nu_default_office)
			document.getElementById("default_office").value = Cookies.get('nu_default_office');  
		var nu_password = Cookies.get('nu_password');
		if (nu_password)
			document.getElementById("password").value = Cookies.get('nu_password');  
		if (1 == Cookies.get('nu_can_change_office')) {
			document.getElementById("can_change_office").checked = true;  
		} else {
			document.getElementById("can_change_office").checked = false;  
		}
		var nu_password_confirmation = Cookies.get('nu_password_confirmation');
		if (nu_password_confirmation)
			document.getElementById("password_confirmation").value = Cookies.get('nu_password_confirmation');  
		if (1 == Cookies.get('nu_startup_caps_lock_on')) {
			document.getElementById("startup_caps_lock_on").checked = true;  
		} else {
			document.getElementById("startup_caps_lock_on").checked = false;  
		}
		var nu_secLevelInput = Cookies.get('nu_secLevelInput');
		if (nu_secLevelInput)
			document.getElementById("secLevelInput").value = Cookies.get('nu_secLevelInput');  
		if (1 == Cookies.get('nu_startup_num_lock_on')) {
			document.getElementById("startup_num_lock_on").checked = true;  
		} else {
			document.getElementById("startup_num_lock_on").checked = false;  
		}
		var nu_docket_prefix = Cookies.get('nu_docket_prefix');
		if (nu_docket_prefix)
			document.getElementById("docket_prefix").value = Cookies.get('nu_docket_prefix');  
		if (1 == Cookies.get('nu_startup_insert_on')) {
			document.getElementById("startup_insert_on").checked = true;  
		} else {
			document.getElementById("startup_insert_on").checked = false;  
		}
		var nu_next_docket_number = Cookies.get('nu_next_docket_number');
		if (nu_next_docket_number)
			document.getElementById("next_docket_number").value = Cookies.get('nu_next_docket_number');  
		var nu_opsCodeInput = Cookies.get('nu_opsCodeInput');
		if (nu_opsCodeInput)
			document.getElementById("opsCodeInput").value = Cookies.get('nu_opsCodeInput');  
		var nu_address = Cookies.get('nu_address');
		if (nu_address)
			document.getElementById("address").value = Cookies.get('nu_address');  
		if (1 == Cookies.get('nu_show_mobile_data_messages')) {
			document.getElementById("show_mobile_data_messages").checked = true;  
		} else {
			document.getElementById("show_mobile_data_messages").checked = false;  
		}
		var nu_town = Cookies.get('nu_town');
		if (nu_town)
			document.getElementById("town").value = Cookies.get('nu_town');
		if (1 == Cookies.get('nu_show_internet_bookings')) {
			document.getElementById("show_internet_bookings").checked = true;  
		} else {
			document.getElementById("show_internet_bookings").checked = false;  
		}
		var nu_county = Cookies.get('nu_county');
		if (nu_county)
			document.getElementById("county").value = Cookies.get('nu_county');  
		if (1 == Cookies.get('nu_show_incoming_control_emails')) {
			document.getElementById("show_incoming_control_emails").checked = true;  
		} else {
			document.getElementById("show_incoming_control_emails").checked = false;  
		}
		var nu_postcode = Cookies.get('nu_postcode');
		if (nu_postcode)
			document.getElementById("postcode").value = Cookies.get('nu_postcode');  
		var nu_country = Cookies.get('nu_country');
		if (nu_country)
			document.getElementById("country").value = Cookies.get('nu_country');  
		if (null == Cookies.get('nu_email_password'))
			document.getElementById("email_password").checked = true;  	// default is checked
		else if (1 == Cookies.get('nu_email_password')) {
			document.getElementById("email_password").checked = true;  
		} else {
			document.getElementById("email_password").checked = false;  
		}
		var nu_work_phone = Cookies.get('nu_work_phone');
		if (nu_work_phone)
			document.getElementById("work_phone").value = Cookies.get('nu_work_phone');  
		var nu_home_phone = Cookies.get('nu_home_phone');
		if (nu_home_phone)
			document.getElementById("home_phone").value = Cookies.get('nu_home_phone');  
		var nu_mobile_phone = Cookies.get('nu_mobile_phone');
		if (nu_mobile_phone)
			document.getElementById("mobile_phone").value = Cookies.get('nu_mobile_phone');  
		var nu_email2 = Cookies.get('nu_email2');
		if (nu_email2)
			document.getElementById("email2").value = Cookies.get('nu_email2');  
		Cookies.remove('nu_name');
		Cookies.remove('nu_current_office');
		Cookies.remove('nu_email');
		Cookies.remove('nu_default_office');
		Cookies.remove('nu_password');
		Cookies.remove('nu_can_change_office');
		Cookies.remove('nu_password_confirmation');
		Cookies.remove('nu_startup_caps_lock_on');
		Cookies.remove('nu_secLevelInput');
		Cookies.remove('nu_startup_num_lock_on');
		Cookies.remove('nu_docket_prefix');
		Cookies.remove('nu_startup_insert_on');
		Cookies.remove('nu_next_docket_number');
		Cookies.remove('nu_opsCodeInput');
		Cookies.remove('nu_address');
		Cookies.remove('nu_show_mobile_data_messages');
		Cookies.remove('nu_town');
		Cookies.remove('nu_show_internet_bookings');
		Cookies.remove('nu_county');
		Cookies.remove('nu_show_incoming_control_emails');
		Cookies.remove('nu_postcode');
		Cookies.remove('nu_country');
		Cookies.remove('nu_email_password');
		Cookies.remove('nu_work_phone');
		Cookies.remove('nu_home_phone');
		Cookies.remove('nu_mobile_phone');
		Cookies.remove('nu_email2');
	</script>
	
	<script>
		function KeepInput() {
			Cookies.set('nu_name', document.getElementById("name").value);	
			Cookies.set('nu_current_office', document.getElementById("current_office").value);	
			Cookies.set('nu_email', document.getElementById("email").value);	
			Cookies.set('nu_default_office', document.getElementById("default_office").value);	
			Cookies.set('nu_password', document.getElementById("password").value);	
			if (document.getElementById("can_change_office").checked) 	{
				Cookies.set('nu_can_change_office', 1)
			} else {
				Cookies.set('nu_can_change_office', 0)
			}
			Cookies.set('nu_password_confirmation', document.getElementById("password_confirmation").value);	
			if (document.getElementById("startup_caps_lock_on").checked) 	{
				Cookies.set('nu_startup_caps_lock_on', 1)
			} else {
				Cookies.set('nu_startup_caps_lock_on', 0)
			}
			Cookies.set('nu_secLevelInput', document.getElementById("secLevelInput").value);	
			if (document.getElementById("startup_num_lock_on").checked) 	{
				Cookies.set('nu_startup_num_lock_on', 1)
			} else {
				Cookies.set('nu_startup_num_lock_on', 0)
			}
			Cookies.set('nu_docket_prefix', document.getElementById("docket_prefix").value);	
			if (document.getElementById("startup_insert_on").checked) 	{
				Cookies.set('nu_startup_insert_on', 1)
			} else {
				Cookies.set('nu_startup_insert_on', 0)
			}
			Cookies.set('nu_next_docket_number', document.getElementById("next_docket_number").value);	
			Cookies.set('nu_opsCodeInput', document.getElementById("opsCodeInput").value);	
			Cookies.set('nu_address', document.getElementById("address").value);	
			if (document.getElementById("show_mobile_data_messages").checked) 	{
				Cookies.set('nu_show_mobile_data_messages', 1)
			} else {
				Cookies.set('nu_show_mobile_data_messages', 0)
			}
			Cookies.set('nu_town', document.getElementById("town").value);	
			if (document.getElementById("show_internet_bookings").checked) 	{
				Cookies.set('nu_show_internet_bookings', 1)
			} else {
				Cookies.set('nu_show_internet_bookings', 0)
			}
			Cookies.set('nu_county', document.getElementById("county").value);	
			if (document.getElementById("show_incoming_control_emails").checked) 	{
				Cookies.set('nu_show_incoming_control_emails', 1)
			} else {
				Cookies.set('nu_show_incoming_control_emails', 0)
			}
			Cookies.set('nu_postcode', document.getElementById("postcode").value);	
			Cookies.set('nu_country', document.getElementById("country").value);	
			if (document.getElementById("email_password").checked) 	{
				Cookies.set('nu_email_password', 1)
			} else {
				Cookies.set('nu_email_password', 0)
			}
			Cookies.set('nu_work_phone', document.getElementById("work_phone").value);	
			Cookies.set('nu_home_phone', document.getElementById("home_phone").value);	
			Cookies.set('nu_mobile_phone', document.getElementById("mobile_phone").value);	
			Cookies.set('nu_email2', document.getElementById("email2").value);	
		}
	</script>
@endsection
