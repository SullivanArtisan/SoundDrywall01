<?php
	use App\Models\Provider;
	
	if (Session::get('--userId')) {
		Session::forget('--userId');
	}
?>

@extends('layouts.home_page_base')
<style>
.my-text-height {height:75%;}
</style>

@section('goback')
	<a class="text-primary" href="{{route('provider_main')}}" style="margin-right: 10px;">Back</a>
@show

<?php
	$id = $_GET['id'];
	if ($id) {
		$provider = Provider::where('id', $id)->first();
	}
?>

@if (!$id or !$provider) {
	@section('function_page')
		<div>
			<div class="row">
				<div class="col col-sm-auto">
					<h2 class="text-muted pl-2">Result of the Provider Operation (by Provider Id)</h2>
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
					<h2 class="text-muted pl-2">Provider: {{$provider->pvdr_name}}</h2>
				</div>
				<div class="col my-auto ml-5">
					<button class="btn btn-danger me-2" type="button"><a href="provider_delete?id={{$provider->id}}" onclick="return myConfirmation();">Delete</a></button>
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
					<form method="post" action="{{url('provider_update')}}">
						@csrf
						<div class="row">
							<div class="col"><label class="col-form-label">Provider Name:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="pvdr_name" name="pvdr_name" value="{{$provider->pvdr_name}}"></div>
							<div class="col"><label class="col-form-label">Address:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="pvdr_address" value="{{$provider->pvdr_address}}"></div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">City:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="pvdr_city" value="{{$provider->pvdr_city}}"></div>
                            <div class="col"><label class="col-form-label">Province:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="pvdr_province" value="{{$provider->pvdr_province}}"></div>
						</div>
						<div class="row">
                        <div class="col"><label class="col-form-label">Post Code:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="pvdr_postcode" value="{{$provider->pvdr_postcode}}"></div>
							<div class="col"><label class="col-form-label">Country:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="pvdr_country" value="{{$provider->pvdr_country}}"></div>
						</div>
						<div class="row">
                            <div class="col"><label class="col-form-label">Contact:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="pvdr_contact" value="{{$provider->pvdr_contact}}"></div>
                            <div class="col"><label class="col-form-label">Phone:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="pvdr_phone" value="{{$provider->pvdr_phone}}"></div>
						</div>
						<div class="row">
                            <div class="col"><label class="col-form-label">Email:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="pvdr_email" value="{{$provider->pvdr_email}}"></div>
							<div class="col"><label class="col-form-label">&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="hidden" name="id" value="{{$provider->id}}"></div>
						</div>
						<div class="row my-3">
							<div class="w-25"></div>
							<div class="col">
								<div class="row">
									<button class="btn btn-warning mx-4" type="submit">Update</button>
									<button class="btn btn-secondary mx-3" type="button"><a href="{{route('provider_main')}}">Cancel</a></button>
								</div>
							</div>
							<div class="col"></div>
						</div>
					</form>
				</div>
			</div>
		</div>
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
				if(!confirm("Are you sure to delete this provider?"))
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

