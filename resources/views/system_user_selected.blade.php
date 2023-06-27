<?php
	use App\Models\User;
	use App\Models\UserSysDetail;
	
	if (Session::get('--userId')) {
		Session::forget('--userId');
	}
?>

@extends('layouts.home_page_base')
<style>
.my-text-height {height:75%;}
</style>

@section('goback')
	<a class="text-primary" href="{{route('system_user_main')}}" style="margin-right: 10px;">Back</a>
@show

<?php
	$id = $_GET['id'];
	if ($id) {
		$user = User::where('id', $id)->first();
		$userDetails = UserSysDetail::where('user_id', $id)->first();
	}
?>

@if (!$id or !$user) {
	@section('function_page')
		<div>
			<div class="row">
				<div class="col col-sm-auto">
					<h2 class="text-muted pl-2">Result of the System User Operation (by User Id)</h2>
				</div>
				<div class="col"></div>
			</div>
		</div>
		
		<div class="alert alert-success m-4">
			<?php
				echo "<span style=\"color:red\">Data cannot NOT be found!</span>";
			?>
		</div>
	@endsection
}
@else {
	@section('function_page')
		<?php
			if (Session::get('uploadPath')) {
				$picPath = Session::get('uploadPath');
				Session::forget(['uploadPath']);
			} else {
				$picPath = $userDetails->picture_file;
			}
		?>
		<div>
			<div class="row m-4">
				<div>
					<h2 class="text-muted pl-2">System User: {{$user->name}}</h2>
				</div>
				<div class="col my-auto ml-5">
					<button class="btn btn-danger me-2" type="button"><a href="system_user_delete?id={{$user->id}}" onclick="return myConfirmation();">Delete</a></button>
				</div>
				<div class="col"></div>
			</div>
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
					<form method="post" action="{{url('system_user_update')}}">
						@csrf
						<div class="row">
							<div class="col"><label class="col-form-label">Name:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="name" value="{{$user->name}}"></div>
							<div class="col"><label class="col-form-label">Current Office:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="current_office" value="{{$userDetails->current_office}}"></div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">Email:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1v" type="email" name="email" value="{{$user->email}}"></div>
							<div class="col"><label class="col-form-label">Default Office:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="default_office" value="{{$userDetails->default_office}}"></div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">Security Level:</label></div>
							<!--
							<div class="col"><input class="form-range form-control" type="range" name="security_level_id"></div>
							-->
							<div class="col">
								<input list="security_level" name="security_level" id="secLevelInput" class="form-control mt-1 my-text-height" value="{{$user->security_level}}">
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
							<div class="col"><label class="col-form-label">Can Change Office:&nbsp;</label></div>
							<div class="col"><input type="checkbox" style="margin-top:3%" name="can_change_office" <?php if($userDetails->can_change_office) {echo "checked";}?>></div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">Docket Prefix:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="docket_prefix" value="{{$user->docket_prefix}}"></div>
							<div class="col"><label class="col-form-label">Startup Caps Lock On:&nbsp;</label></div>
							<div class="col"><input type="checkbox" style="margin-top:3%" name="startup_caps_lock_on" <?php if($userDetails->startup_caps_lock_on) {echo "checked";}?>></div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">Next Docket Number:&nbsp;&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="next_docket_number" value="{{$user->next_docket_number}}"></div>
							<div class="col"><label class="col-form-label">Startup Num Lock On:&nbsp;</label></div>
							<div class="col"><input type="checkbox" style="margin-top:3%" name="startup_num_lock_on" <?php if($userDetails->startup_num_lock_on) {echo "checked";}?>></div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">Address:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="address" value="{{$user->address}}"></div>
							<div class="col"><label class="col-form-label">Startup Insert On:&nbsp;</label></div>
							<div class="col"><input type="checkbox" style="margin-top:3%" name="startup_insert_on" <?php if($userDetails->startup_insert_on) {echo "checked";}?>></div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">Town:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="town" value="{{$user->town}}"></div>
							<div class="col"><label class="col-form-label">Ops Code:&nbsp;</label></div>
							<!--
							<div class="col"><input class="form-range form-control" type="range" name="ops_code"></div>
							-->
							<div class="col">
								<?php
								$tagHead = "<input list=\"ops_code\" name=\"ops_code\" id=\"opscodeinput\" class=\"form-control mt-1 my-text-height\" value=\"{{".$userDetails->ops_code."}}\"";
								$tagTail = "><datalist id=\"ops_code\">";

								$allTypes = MyHelper::GetAllOpsCodes();
								foreach($allTypes as $eachType) {
									$tagTail.= "<option value=".str_replace(' ', '&nbsp;', $eachType).">";
								}
								$tagTail.= "</datalist>";
								echo $tagHead."placeholder=\"\" value=\"\"".$tagTail;
								?>
							</div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">County:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="county" value="{{$user->county}}"></div>
							<div class="col"><label class="col-form-label">Show Mobile Data Messages:&nbsp;</label></div>
							<div class="col"><input type="checkbox" style="margin-top:3%" name="show_mobile_data_messages" <?php if($userDetails->show_mobile_data_messages) {echo "checked";}?>></div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">Postcode:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="postcode" value="{{$user->postcode}}"></div>
							<div class="col"><label class="col-form-label">Show Internet Bookings:&nbsp;</label></div>
							<div class="col"><input type="checkbox" style="margin-top:3%" name="show_internet_bookings" <?php if($userDetails->show_internet_bookings) {echo "checked";}?>></div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">Country:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="country" value="{{$user->country}}"></div>
							<div class="col"><label class="col-form-label">Show Incoming Control Emails:&nbsp;</label></div>
							<div class="col"><input type="checkbox" style="margin-top:3%" name="show_incoming_control_emails" <?php if($userDetails->show_incoming_control_emails) {echo "checked";}?>></div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">Work Tel Number:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="work_phone" value="{{$user->work_phone}}"></div>
							<div class="col" id="pic_holder"><label class="col-form-label">Picture File:&nbsp;</label></div>
							<?php
								$origin_pic_path_array = explode("/", $userDetails->picture_file);
								$wanted_pic_path = url('')."/";
								for ($i=1; $i<sizeof($origin_pic_path_array); $i++) {
									$wanted_pic_path .= $origin_pic_path_array[$i];
									if($i != sizeof($origin_pic_path_array)-1) {
										$wanted_pic_path .= "/";
									}
								}
							?>
							<!--
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="picture_file" name="picture_file" value="{{$userDetails->picture_file}}" onmouseover="showImage('picture_file', '{{$wanted_pic_path}}')" onmouseout="hideImage('picture_file')"></div>
							-->
							<div class="col">
								<div class="row">
									<div class="col-9 pr-0"><input class="form-control mt-1 my-text-height" type="text" id="picture_file" name="picture_file" value="{{$userDetails->picture_file}}" onmouseover="showImage('picture_file', '{{$wanted_pic_path}}')" onmouseout="hideImage('picture_file')"></div>
									<div class="col-3 pl-2"><button class="btn btn-info btn-sm mt-1" type="button" onclick="KeepInput()"><a href="{{route('system_user_pic_upload', 'id='.$id)}}">Browse</a></button></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">Home Tel Number:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="home_phone" value="{{$user->home_phone}}"></div>
							<div class="col"><label class="col-form-label"></label></div>
							<div class="col"><input class="form-control mt-1" type="hidden"></div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">Mobile Tel Number:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="mobile_phone" value="{{$user->mobile_phone}}"></div>
							<div class="col"><label class="col-form-label"></label></div>
							<div class="col"><input class="form-control mt-1" type="hidden"></div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">Email2:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="email" name="email2" value="{{$user->email2}}"></div>
							<div class="col"><label class="col-form-label"></label></div>
							<div class="col"><input class="form-control mt-1" type="hidden"></div>
						</div>
						<!--
						<div class="row">
							<div class="col"><label class="col-form-label"></label></div>
							<div class="col"><input class="form-control mt-1" type="hidden"></div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label"></label></div>
							<div class="col"><input class="form-control mt-1" type="hidden"></div>
						</div>
						-->
						<div class="row my-3">
							<div class="w-25"></div>
							<div class="col">
								<div class="row">
									<button class="btn btn-warning mx-4" type="submit">Update</button>
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
		<script>
			var opsCodeInput = document.getElementById('opsCodeInput'); 			// give an id to your input and set it as variable
			//opsCodeInput.value ='Local'; 											// set default value instead of html attribute
			opsCodeInput.onfocus = function() { opsCodeInput.value ='';} 			// on focus - clear input
			//opsCodeInput.onblur = function() { opsCodeInput.value ='Local';} 		// on leave restore it.
			var secLevelInput = document.getElementById('secLevelInput'); 			// give an id to your input and set it as variable
			//secLevelInput.value ='Chassis'; 										// set default value instead of html attribute
			secLevelInput.onfocus = function() { secLevelInput.value ='';}			// on focus - clear input
			//secLevelInput.onblur = function() { secLevelInput.value ='Chassis';	// on leave restore it.
		</script>
		
		<script>
			function myConfirmation() {
				if(!confirm("Are you sure to delete this user?"))
				event.preventDefault();
			}
			
			function showImage(elemId, imgSrc) {
			  const elem = document.getElementById(elemId);
			  if (elem.value) {	
				  var picPath = {!! json_encode($picPath) !!};
				  const popImage = new Image();
				  //alert(picPath);
				  popImage.src = "./pic/1671825252_1670285560_image2.jpeg";				// this hard coded picture path can work
				  // popImage.src = "https://test.nueco.ca/NuEco/1670434551_1670285560_image2.jpeg";	// need to be tested if it's stored under domain_root/storage/app/public
				  popImage.style.position = "absolute";
				  popImage.style.zIndex = "1";
				  popImage.style.width = "200px";
				  popImage.style.height = "250px";
				  elem.appendChild(popImage);										// for future optimization
				  document.getElementById("pic_holder").appendChild(popImage);		// for now
			  }
			}	
			
			function hideImage(elemId) {
			  const elem = document.getElementById(elemId);
			  if (elem.value) {	
				  // console.log("elemId is: " + elemId);
				  while (elem.childElementCount > 0) {
					elem.removeChild(elem.lastChild);
				  }
				  while (document.getElementById("pic_holder").childElementCount > 0) {
					document.getElementById("pic_holder").removeChild(document.getElementById("pic_holder").lastChild);
					break;
				  }
			  }
			}			
		</script>

		<script>
			var picPath = {!! json_encode($picPath) !!};
			document.getElementById('picture_file').value = picPath;
		</script>
	@endsection
}
@endif

