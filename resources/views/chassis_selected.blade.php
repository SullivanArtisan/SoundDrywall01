<?php
	use App\Models\Chassis;
?>

@extends('layouts.home_page_base')
<style>
.my-text-height {height:75%;}
</style>

@section('goback')
	<a class="text-primary" href="{{route('chassis_main')}}" style="margin-right: 10px;">Back</a>
@show

<?php
	$id = $_GET['id'];
	if ($id) {
		$chassis = Chassis::where('id', $id)->first();
	}
?>

@if (!$id or !$chassis) {
	@section('function_page')
		<div>
			<div class="row">
				<div class="col col-sm-auto">
					<h2 class="text-muted pl-2">Result of the Chassis Operation</h2>
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
		<div>
			<div class="row m-4">
				<div>
					<h2 class="text-muted pl-2">Chassis: {{$chassis->code}}</h2>
				</div>
				<div class="col my-auto ml-5">
					<button class="btn btn-danger me-2" type="button"><a href="{{route('chassis_delete', ['id'=>$id])}}" onclick="return myConfirmation();">Delete</a></button>
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
					<form method="post" action="{{route('op_result.chassis_update', ['id'=>$id])}}">
						@csrf
						<div class="row mx-2">
							<div class="col"><label class="col-form-label">Chassis Number:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="code" value="{{$chassis->code}}"></div>
							<div class="col"><label class="col-form-label">VIN:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="vin" value="{{$chassis->vin}}"></div>
						</div>
						<div class="row mx-2">
							<div class="col"><label class="col-form-label">Year:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="year" value="{{$chassis->year}}"></div>
							<div class="col"><label class="col-form-label">Type:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="type" value="{{$chassis->type}}"></div>
						</div>
						<div class="row mx-2">
							<div class="col"><label class="col-form-label">Owner:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="owner" value="{{$chassis->owner}}"></div>
							<div class="col"><label class="col-form-label">License:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="licence" value="{{$chassis->licence}}"></div>
						</div>
						<div class="row mx-2">
							<div class="col"><label class="col-form-label">Driver:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="driver" value="{{$chassis->driver}}"></div>
							<div class="col"><label class="col-form-label">Last Driver:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="lastdriver" value="{{$chassis->lastdriver}}"></div>
						</div>
						<div class="row mx-2">
							<div class="col"><label class="col-form-label">Container:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="container" value="{{$chassis->container}}"></div>
							<div class="col"><label class="col-form-label">Genset No.:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="genset" value="{{$chassis->genset}}"></div>
						</div>
						<div class="row mx-2">
							<div class="col"><label class="col-form-label">Current Location:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="currentlocation" value="{{$chassis->currentlocation}}"></div>
							<div class="col"><label class="col-form-label">Last Updated:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="dateupdated" value="{{$chassis->dateupdated}}"></div>
						</div>
						<div class="row mx-2">
							<div class="col"><label class="col-form-label">PM Inspection:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="pminspection" value="{{$chassis->pminspection}}"></div>
							<div class="col"><label class="col-form-label">CVI Inspection:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="cviinspection" value="{{$chassis->cviinspection}}"></div>
						</div>
						<div class="row mx-2">
							<div class="col"><label class="col-form-label">Leased:&nbsp;</label></div>
							@if ($chassis->leased == 'T')
								<div class="col"><input type="checkbox" style="margin-top:3%" id="leased" name="leased" checked></div>
							@else
								<div class="col"><input type="checkbox" style="margin-top:3%" id="leased" name="leased"></div>
							@endif
							<div class="col"><label class="col-form-label">Unconfirmed:&nbsp;</label></div>
							@if ($chassis->unconfirmed == 'T')
								<div class="col"><input type="checkbox" style="margin-top:3%" id="unconfirmed" name="unconfirmed" checked></div>
							@else
								<div class="col"><input type="checkbox" style="margin-top:3%" id="unconfirmed" name="unconfirmed"></div>
							@endif
						</div>
						<div class="row mx-2">
							<div class="col"><label class="col-form-label">Alias1:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="alias1" value="{{$chassis->alias1}}"></div>
							<div class="col"><label class="col-form-label">Alias2:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="alias2" value="{{$chassis->alias2}}"></div>
						</div>
						<div class="row mx-2">
							<div class="col"><label class="col-form-label">Alias3:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="alias3" value="{{$chassis->alias3}}"></div>
							<div class="col"><label class="col-form-label">Alias4:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="alias4" value="{{$chassis->alias4}}"></div>
						</div>
						<div class="row my-3">
							<div class="w-25"></div>
							<div class="col">
								<div class="row">
									<button class="btn btn-warning mx-4" type="submit">Update</button>
									<button class="btn btn-secondary mx-3" type="button"><a href="{{route('chassis_main')}}">Cancel</a></button>
								</div>
							</div>
							<div class="col"></div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<script>
		</script>
		
		<script>
			function myConfirmation() {
				if(!confirm("Are you sure to delete this chassis?"))
				event.preventDefault();
			}
		</script>
	@endsection
}
@endif

	<?php
	?>

