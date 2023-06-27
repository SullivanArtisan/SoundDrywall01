<?php
	use App\Models\PowerUnit;
?>

@extends('layouts.home_page_base')
<style>
.my-text-height {height:75%;}
</style>

@section('goback')
	<a class="text-primary" href="{{route('power_unit_main')}}" style="margin-right: 10px;">Back</a>
@show

<?php
	$id = $_GET['id'];
	if ($id) {
		$unit = PowerUnit::where('id', $id)->first();
	}
?>

@if (!$id or !$unit) {
	@section('function_page')
		<div>
			<div class="row">
				<div class="col col-sm-auto">
					<h2 class="text-muted pl-2">Result of the Power Unit Operation</h2>
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
					<h2 class="text-muted pl-2">Power Unit: {{$unit->plate_number}}</h2>
				</div>
				<div class="col my-auto ml-5">
					<button class="btn btn-danger me-2" type="button"><a href="power_unit_delete?id={{$unit->id}}" onclick="return myConfirmation();">Delete</a></button>
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
					<form method="post" action="{{url('power_unit_update')}}">
						@csrf
						<div class="row mx-2">
							<div class="col-2"><label class="col-form-label">Unit ID:&nbsp;</label></div>
							<div class="col-10"><input class="form-control mt-1 my-text-height" type="text" name="unit_id" value="{{$unit->unit_id}}"></div>
						</div>
						<div class="row mx-2">
							<div class="col-2"><label class="col-form-label">Make:&nbsp;</label></div>
							<div class="col-10"><input class="form-control mt-1 my-text-height" type="text" name="make" value="{{$unit->make}}"></div>
						</div>
						<div class="row mx-2">
							<div class="col-2"><label class="col-form-label">Plate Number:&nbsp;</label></div>
							<div class="col-10"><input class="form-control mt-1 my-text-height" type="text" name="plate_number" value="{{$unit->plate_number}}"></div>
						</div>
						<div class="row mx-2">
							<div class="col-2"><label class="col-form-label">VIN:&nbsp;</label></div>
							<div class="col-10"><input class="form-control mt-1 my-text-height" type="text" name="vin" value="{{$unit->vin}}"></div>
						</div>
						<div class="row mx-2">
							<div class="col-2"><label class="col-form-label">Current Driver:&nbsp;</label></div>
							<div class="col-10"><input class="form-control mt-1 my-text-height" type="text" name="current_driver" value="{{$unit->current_driver}}"></div>
						</div>
						<div class="row mx-2">
							<div class="col-2"><label class="col-form-label">Current Location:&nbsp;</label></div>
							<div class="col-10"><input class="form-control mt-1 my-text-height" type="text" name="current_location" value="{{$unit->current_location}}"></div>
						</div>
						<div class="row mx-2">
							<div class="col-2"><label class="col-form-label">OPS Code:&nbsp;</label></div>
							<div class="col-10"><input class="form-control mt-1 my-text-height" type="text" name="ops_code" value="{{$unit->ops_code}}"></div>
						</div>
						<div class="row mx-2">
							<div class="col-2"><label class="col-form-label">Insurance Expiry Date:&nbsp;</label></div>
							<div class="col-10"><input class="form-control mt-1 my-text-height" type="text" name="insurance_expiry_date" value="{{$unit->insurance_expiry_date}}"></div>
						</div>
						<div class="row my-3">
							<div class="w-25"></div>
							<div class="col">
								<div class="row">
									<button class="btn btn-warning mx-4" type="submit">Update</button>
									<button class="btn btn-secondary mx-3" type="button"><a href="{{route('power_unit_main')}}">Cancel</a></button>
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
				if(!confirm("Are you sure to delete this unit?"))
				event.preventDefault();
			}
		</script>
	@endsection
}
@endif

	<?php
	?>

