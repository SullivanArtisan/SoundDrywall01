<?php
	use App\Models\Terminal;
?>

@extends('layouts.home_page_base')
<style>
.my-text-height {height:75%;}
</style>

@section('goback')
	<a class="text-primary" href="{{route('terminal_main')}}" style="margin-right: 10px;">Back</a>
@show

<?php
	$id = $_GET['id'];
	if ($id) {
		$trmnl = Terminal::where('id', $id)->first();
	}
?>

@if (!$id or !$trmnl) {
	@section('function_page')
		<div>
			<div class="row">
				<div class="col col-sm-auto">
					<h2 class="text-muted pl-2">Result of the Terminal Operation</h2>
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
					<h2 class="text-muted pl-2">Terminal: {{$trmnl->trmnl_name}}</h2>
				</div>
				<div class="col my-auto ml-5">
					<button class="btn btn-danger me-2" type="button"><a href="{{route('terminal_delete', ['id'=>$id])}}" onclick="return myConfirmation();">Delete</a></button>
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
					<form method="post" action="{{route('op_result.terminal_update', ['id'=>$id])}}">
						@csrf
						<div class="row">
							<div class="col"><label class="col-form-label">Terminal:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="trmnl_name" value="{{$trmnl->trmnl_name}}"></div>
							<div class="col"><label class="col-form-label">Address:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="trmnl_address" value="{{$trmnl->trmnl_address}}"></div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">City:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="trmnl_city" value="{{$trmnl->trmnl_city}}"></div>
							<div class="col"><label class="col-form-label">Province:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="trmnl_province" value="{{$trmnl->trmnl_province}}"></div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">Postcode:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="trmnl_postcode" value="{{$trmnl->trmnl_postcode}}"></div>
							<div class="col"><label class="col-form-label">Country:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="trmnl_country" value="{{$trmnl->trmnl_country}}"></div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">Area:&nbsp;</label></div>
							<div class="col">
								<input class="form-control mt-1 my-text-height" list="trmnl_area" name="trmnl_area" type="text" placeholder="{{$trmnl->trmnl_area}}">
								<datalist id="trmnl_area">
									<?php
										$zones = \App\Models\Zone::all();
										foreach ($zones as $zone) {
											echo ("<option value=\"".$zone->zone_name."\">");
										}
									?>
								</datalist>
							</div>
							<div class="col"><label class="col-form-label">Contact:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="trmnl_contact" value="{{$trmnl->trmnl_contact}}"></div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">Tel:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="trmnl_tel" value="{{$trmnl->trmnl_tel}}"></div>
							<div class="col"><label class="col-form-label">Fax:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="trmnl_fax" value="{{$trmnl->trmnl_fax}}"></div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">Email:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="trmnl_email" value="{{$trmnl->trmnl_email}}"></div>
							<div class="col"><label class="col-form-label">Cutoff Time:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="time" name="trmnl_cutoff_time" value="{{$trmnl->trmnl_cutoff_time}}"></div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">No Signature Required:&nbsp;</label></div>
							<div class="col"><input type="checkbox" style="margin-top:3%" name="trmnl_no_sig_required" <?php if($trmnl->trmnl_no_sig_required) {echo "checked";}?>></div>
							<div class="col"><label class="col-form-label">Geofence Facility:&nbsp;</label></div>
							<div class="col">
								<?php
									if ($trmnl->trmnl_geofence_facility) {
										$placeholder = \App\Models\GeofenceFacility::where('id', $trmnl->trmnl_geofence_facility)->first()->facility_name;
										$html_tag = '<input class="form-control mt-1 my-text-height" list="trmnl_geofence_facility" name="trmnl_geofence_facility" type="text" placeholder="'.$placeholder.'">';
									} else {
										$html_tag = '<input class="form-control mt-1 my-text-height" list="trmnl_geofence_facility" name="trmnl_geofence_facility" type="text">';
									}
									echo $html_tag;
								?>
								<datalist id="trmnl_geofence_facility">
									<?php
										$geo_fs = \App\Models\GeofenceFacility::all();
										foreach ($geo_fs as $geo_f) {
											echo ("<option value=\"".$geo_f->facility_name."\">");
										}
									?>
								</datalist>
							</div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">Trmnl Latitude:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="number" step="0.000001" name="trmnl_latitude" value="{{$trmnl->trmnl_latitude}}"></div>
							<div class="col"><label class="col-form-label">Trmnl Longitude:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="number" step="0.000001" name="trmnl_longitude" value="{{$trmnl->trmnl_longitude}}"></div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">Arrived Latitude:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="number" step="0.000001" name="trmnl_arrived_latitude" value="{{$trmnl->trmnl_arrived_latitude}}"></div>
							<div class="col"><label class="col-form-label">Arrived Longitude:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="number" step="0.000001" name="trmnl_arrived_longitude" value="{{$trmnl->trmnl_arrived_longitude}}"></div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">Arrived Radius:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="number" step="0.000001" name="trmnl_arrived_radius" value="{{$trmnl->trmnl_arrived_radius}}"></div>
							<div class="col"><label class="col-form-label">&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" style="visibility: hidden"></div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">Halo Center Latitude:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="number" step="0.000001" name="trmnl_halo_center_latitude" value="{{$trmnl->trmnl_halo_center_latitude}}"></div>
							<div class="col"><label class="col-form-label">Halo Center Longitude:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="number" step="0.000001" name="trmnl_halo_center_longitude" value="{{$trmnl->trmnl_halo_center_longitude}}"></div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">Halo Center Radius:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="number" step="0.000001" name="trmnl_halo_center_radius" value="{{$trmnl->trmnl_halo_center_radius}}"></div>
							<div class="col"><label class="col-form-label">&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" style="visibility: hidden"></div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">Ingate Latitude:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="number" step="0.000001" name="trmnl_ingate_latitude" value="{{$trmnl->trmnl_ingate_latitude}}"></div>
							<div class="col"><label class="col-form-label">Ingate Longitude:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="number" step="0.000001" name="trmnl_ingate_longitude" value="{{$trmnl->trmnl_ingate_longitude}}"></div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">Ingate Radius:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="number" step="0.000001" name="trmnl_ingate_radius" value="{{$trmnl->trmnl_ingate_radius}}"></div>
							<div class="col"><label class="col-form-label">&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" style="visibility: hidden"></div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">Outgate Latitude:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="number" step="0.000001" name="trmnl_outgate1_latitude" value="{{$trmnl->trmnl_outgate1_latitude}}"></div>
							<div class="col"><label class="col-form-label">Outgate Longitude:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="number" step="0.000001" name="trmnl_outgate1_longitude" value="{{$trmnl->trmnl_outgate1_longitude}}"></div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">Outgate Radius:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="number" step="0.000001" name="trmnl_outgate1_radius" value="{{$trmnl->trmnl_outgate1_radius}}"></div>
							<div class="col"><label class="col-form-label">&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" style="visibility: hidden"></div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">Outgate 2 Latitude:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="number" step="0.000001" name="trmnl_outgate2_latitude" value="{{$trmnl->trmnl_outgate2_latitude}}"></div>
							<div class="col"><label class="col-form-label">Outgate 2 Longitude:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="number" step="0.000001" name="trmnl_outgate2_longitude" value="{{$trmnl->trmnl_outgate2_longitude}}"></div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">Outgate 2 Radius:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="number" step="0.000001" name="trmnl_outgate2_radius" value="{{$trmnl->trmnl_outgate2_radius}}"></div>
							<div class="col"><label class="col-form-label">&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" style="visibility: hidden"></div>
						</div>
						<div class="row my-3">
							<div class="w-25"></div>
							<div class="col">
								<div class="row">
									<button class="btn btn-warning mx-4" type="submit">Update</button>
									<button class="btn btn-secondary mx-3" type="button"><a href="{{route('terminal_main')}}">Cancel</a></button>
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
				if(!confirm("Are you sure to delete this terminal?"))
				event.preventDefault();
			}
		</script>
	@endsection
}
@endif

	<?php
	?>

