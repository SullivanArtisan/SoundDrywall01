<?php
	use App\Models\Zone;
?>

@extends('layouts.home_page_base')
<style>
.my-text-height {height:75%;}
</style>

@section('goback')
	<a class="text-primary" href="{{route('zone_main')}}" style="margin-right: 10px;">Back</a>
@show

<?php
	$id = $_GET['id'];
	if ($id) {
		$zone = Zone::where('id', $id)->first();
	}
?>

@if (!$id or !$zone) {
	@section('function_page')
		<div>
			<div class="row">
				<div class="col col-sm-auto">
					<h2 class="text-muted pl-2">Result of the Zone Operation</h2>
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
					<h2 class="text-muted pl-2">Zone: {{$zone->zone_name}}</h2>
				</div>
				<div class="col my-auto ml-5">
					<button class="btn btn-danger me-2" type="button"><a href="{{route('zone_delete', ['id'=>$id])}}" onclick="return myConfirmation();">Delete</a></button>
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
					<form method="post" action="{{route('op_result.zone_update', ['id'=>$id])}}">
						@csrf
						<div class="row mx-2">
							<div class="col-2"><label class="col-form-label">Zone:&nbsp;</label></div>
							<div class="col-10"><input class="form-control mt-1 my-text-height" type="text" name="zone_name" value="{{$zone->zone_name}}"></div>
						</div>
						<div class="row mx-2">
							<div class="col-2"><label class="col-form-label">Group:&nbsp;</label></div>
							<div class="col-10"><input class="form-control mt-1 my-text-height" type="text" name="zone_group" value="{{$zone->zone_group}}"></div>
						</div>
						<div class="row mx-2">
							<div class="col-2"><label class="col-form-label">Description:&nbsp;</label></div>
							<div class="col-10"><input class="form-control mt-1 my-text-height" type="text" name="zone_description" value="{{$zone->zone_description}}"></div>
						</div>
						<div class="row mx-2">
							<div class="col-2"><label class="col-form-label">FSC Deduction %:&nbsp;</label></div>
							<div class="col-10"><input class="form-control mt-1 my-text-height" type="text" name="zone_fsc_deduction" value="{{$zone->zone_fsc_deduction}}"></div>
						</div>
						<div class="row my-3">
							<div class="w-25"></div>
							<div class="col">
								<div class="row">
									<button class="btn btn-warning mx-4" type="submit">Update</button>
									<button class="btn btn-secondary mx-3" type="button"><a href="{{route('zone_main')}}">Cancel</a></button>
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
				if(!confirm("Are you sure to delete this zone?"))
				event.preventDefault();
			}
		</script>
	@endsection
}
@endif

	<?php
	?>

