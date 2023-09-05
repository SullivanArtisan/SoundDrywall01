<?php
	use App\Models\Client;
	
	if (Session::get('--userId')) {
		Session::forget('--userId');
	}
?>

@extends('layouts.home_page_base')
<style>
.my-text-height {height:75%;}
</style>

@section('goback')
	<a class="text-primary" href="{{route('client_main')}}" style="margin-right: 10px;">Back</a>
@show

<?php
	$id = $_GET['id'];
	if ($id) {
		$client = Client::where('id', $id)->first();
	}
?>

@if (!$id or !$client) {
	@section('function_page')
		<div>
			<div class="row">
				<div class="col col-sm-auto">
					<h2 class="text-muted pl-2">Result of the Client Operation (by Client Id)</h2>
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
				// $picPath = $userDetails->picture_file;
			}
		?>
		<div>
			<div class="row m-4">
				<div>
					<h2 class="text-muted pl-2">Client: {{$client->clnt_name}}</h2>
				</div>
				<div class="col my-auto ml-5">
					@if (Auth::user()->role == 'ADMINISTRATOR')
					<button class="btn btn-danger me-2" type="button"><a href="client_delete?id={{$client->id}}" onclick="return myConfirmation();">Delete</a></button>
					@endif
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
					<form method="post" action="{{url('client_update')}}">
						@csrf
						<div class="row">
							<div class="col"><label class="col-form-label">Client Name:&nbsp;</label><span class="text-danger">*</span></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="clnt_name" name="clnt_name" value="{{$client->clnt_name}}"></div>
							<div class="col"><label class="col-form-label">Address:&nbsp;</label><span class="text-danger">*</span></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="clnt_address" value="{{$client->clnt_address}}"></div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">City:&nbsp;</label><span class="text-danger">*</span></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="clnt_city" value="{{$client->clnt_city}}"></div>
                            <div class="col"><label class="col-form-label">Province:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="clnt_province" value="{{$client->clnt_province}}"></div>
						</div>
						<div class="row">
                        <div class="col"><label class="col-form-label">Post Code:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="clnt_postcode" value="{{$client->clnt_postcode}}"></div>
							<div class="col"><label class="col-form-label">Country:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="clnt_country" value="{{$client->clnt_country}}"></div>
						</div>
						<div class="row">
                            <div class="col"><label class="col-form-label">Contact:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="clnt_contact" value="{{$client->clnt_contact}}"></div>
                            <div class="col"><label class="col-form-label">Phone:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="clnt_phone" value="{{$client->clnt_phone}}"></div>
						</div>
						<div class="row">
                            <div class="col"><label class="col-form-label">Email:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="clnt_email" value="{{$client->clnt_email}}"></div>
							<div class="col"><label class="col-form-label">&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="hidden" name="id" value="{{$client->id}}"></div>
						</div>
						<div class="row my-3">
							<div class="w-25"></div>
							<div class="col">
								<div class="row">
									@if (Auth::user()->role == 'ADMINISTRATOR')
									<button class="btn btn-warning mx-4" type="submit">Update</button>
									@endif
									<button class="btn btn-secondary mx-3" type="button"><a href="{{route('client_main')}}">Cancel</a></button>
								</div>
							</div>
							<div class="col"></div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<script>
			// var opsCodeInput = document.getElementById('opsCodeInput'); 			// give an id to your input and set it as variable
			//opsCodeInput.value ='Local'; 											// set default value instead of html attribute
			// opsCodeInput.onfocus = function() { opsCodeInput.value ='';} 			// on focus - clear input
			//opsCodeInput.onblur = function() { opsCodeInput.value ='Local';} 		// on leave restore it.
			// var secLevelInput = document.getElementById('secLevelInput'); 			// give an id to your input and set it as variable
			//secLevelInput.value ='Chassis'; 										// set default value instead of html attribute
			// secLevelInput.onfocus = function() { secLevelInput.value ='';}			// on focus - clear input
			//secLevelInput.onblur = function() { secLevelInput.value ='Chassis';	// on leave restore it.
		</script>
		
		<script>
			function myConfirmation() {
				if(!confirm("Continue to delete this client?"))
				event.preventDefault();
			}
			
			// function showImage(elemId, imgSrc) {
			//   const elem = document.getElementById(elemId);
			//   if (elem.value) {	
			// 	  var picPath = {!! 0;//json_encode($picPath) !!};
			// 	  const popImage = new Image();
			// 	  //alert(picPath);
			// 	  popImage.src = "./pic/1671825252_1670285560_image2.jpeg";				// this hard coded picture path can work
			// 	  // popImage.src = "https://test.nueco.ca/NuEco/1670434551_1670285560_image2.jpeg";	// need to be tested if it's stored under domain_root/storage/app/public
			// 	  popImage.style.position = "absolute";
			// 	  popImage.style.zIndex = "1";
			// 	  popImage.style.width = "200px";
			// 	  popImage.style.height = "250px";
			// 	  elem.appendChild(popImage);										// for future optimization
			// 	  document.getElementById("pic_holder").appendChild(popImage);		// for now
			//   }
			// }	
			
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
			// var picPath = {!! 0; //json_encode($picPath) !!};
			// document.getElementById('picture_file').value = picPath;
		</script>
	@endsection
}
@endif

