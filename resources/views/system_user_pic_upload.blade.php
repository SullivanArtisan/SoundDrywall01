@extends('layouts.home_page_base')

<?php
	if (isset($_GET['id'])) {						// for a specific system user selected
		Session::put('--userId', $_GET['id']);
	} else if (isset($_GET['driverId'])) {			// for a specific driver selected
		Session::put('--driverId', $_GET['driverId']);
	}
?>

@section('goback')
	@if (Session::get('--userId'))
		<a class="text-primary" href="{{route('system_user_selected', ['id'=>Session::get('--userId')])}}" style="margin-right: 10px;">Back</a>
	@elseif (Session::get('--driverId'))
		<a class="text-primary" href="{{route('driver_selected', ['driverId'=>Session::get('--driverId')])}}" style="margin-right: 10px;">Back</a>
	@elseif (isset($_GET['noId']))
		<a class="text-primary" href="{{route('system_user_add')}}" style="margin-right: 10px;">Back</a>
	@elseif (isset($_GET['noDriverId']))
		<a class="text-primary" href="{{route('driver_selected')}}" style="margin-right: 10px;">Back</a>
	@else
		<a class="text-primary" href="{{route('home_page')}}" style="margin-right: 10px;">Back</a>
	@endif
@show


@section('function_page')
    <div>
        <div class="row">
            <div class="col col-sm-auto">
				<h2 class="text-muted pl-2">Upload a Picture File</h2>
            </div>
            <div class="col"></div>
        </div>
    </div>
	
    <div class="container mt-5">
		<?php
		 // echo Form::open(array('url' => '/uploadfile','files'=>'true'));
		 // echo 'Select the file to upload.';
		 // echo Form::file('image');
		 // echo Form::submit('Upload File');
		 // echo Form::close();
		?>
        <form action="{{route('uploadfile')}}" method="post" enctype="multipart/form-data">
            @csrf
            @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <strong>{{ $message }}</strong>
            </div>
			@endif
			@if (count($errors) > 0)
			<div class="alert alert-danger">
				<ul>
					@foreach ($errors->all() as $error)
					  <li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
			@endif
            <div class="custom-file">
                <input type="file" name="file" id="chooseFile">
				<input id="uploadFile" placeholder="No File" disabled="disabled" />
                <label class="custom-file-label" for="chooseFile" id="uploadPath">Select file</label>
            </div>
            <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">
                Upload File
            </button>
        </form>
    </div>
	<!--
    <div class="container mt-5">
		<div class="row">
			<div class="col-4 bg-info">
			</div>
			<div class="col-4 bg-warning" id="pic_holder">
				@if ($message = Session::get('success'))
					<script>
						const elem = document.getElementById('pic_holder');
						const popImage = new Image();
						// popImage.src = "https://static5.cargurus.com/images/site/2009/10/24/14/42/2004_suzuki_vitara_4_dr_lx_4wd_suv-pic-8731393806365188898-640x480.jpeg";
						popImage.src = "https://test.nueco.ca/NuEco/1670434551_1670285560_image2.jpeg";	// need to be tested if it's stored under domain_root/storage/app/public
						popImage.style.position = "absolute";
						popImage.style.zIndex = "1";
						popImage.style.width = "200px";
						popImage.style.height = "250px";
						elem.appendChild(popImage);										// for future optimization
						document.getElementById("pic_holder").appendChild(popImage);		// for now
					</script>
					{{Session::forget(['success']);}}
				@endif
			</div>
			<div class="col-4 bg-info">
			</div>
		</div>
    </div>
	-->
<!--
@if ($message = Session::get('success'))
	<script>
		const queryString = window.location.search;
		const urlParams = new URLSearchParams(queryString);
		const inPath = urlParams.get('uploadPath');
		var uploadPath = document.getElementById('uploadPath');
		uploadPath.innerHTML = inPath;
	</script>
@endif
-->
<script>
	document.getElementById("chooseFile").onchange = function() {
		var pathInArray = this.value.split("\\");
	    document.getElementById("uploadPath").innerHTML = pathInArray[pathInArray.length - 1];
	};
</script>
@endsection
