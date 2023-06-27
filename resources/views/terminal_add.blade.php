<?php
	use App\Models\GeofenceFacility;
	use Illuminate\Support\Facades\Session;
?>

@extends('layouts.home_page_base')
<style>
.my-text-height {height:75%;}
</style>

@section('goback')
	<a class="text-primary" href="{{route('terminal_main')}}" style="margin-right: 10px;">Back</a>
@show

@section('function_page')
	<div>
		<h2 class="text-muted pl-2 mb-2">Add a New Terminal</h2>
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
                <form method="post" action="{{route('op_result.terminal_add')}}">
					@csrf
                    <div class="row">
                        <div class="col"><label class="col-form-label">Terminal Name:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="trmnl_name" name="trmnl_name"></div>
                        <div class="col"><label class="col-form-label">Address:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="trmnl_address" name="trmnl_address"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">City:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1v" type="text" id="trmnl_city" name="trmnl_city"></div>
                        <div class="col"><label class="col-form-label">Province:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="trmnl_province" name="trmnl_province"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Postcode:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1v" type="text" id="trmnl_postcode" name="trmnl_postcode"></div>
                        <div class="col"><label class="col-form-label">Country:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="trmnl_country" name="trmnl_country"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Area:&nbsp;</label></div>
						<div class="col">
							<input list="trmnl_area" name="trmnl_area" class="form-control mt-1 my-text-height">
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
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="trmnl_contact" name="trmnl_contact"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Tel:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1v" type="text" id="trmnl_tel" name="trmnl_tel"></div>
                        <div class="col"><label class="col-form-label">Fax:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="trmnl_fax" name="trmnl_fax"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Email:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1v" type="text" id="trmnl_email" name="trmnl_email"></div>
                        <div class="col"><label class="col-form-label">Cutoff Time:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="time" id="trmnl_cutoff_time" name="trmnl_cutoff_time"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">No Signature Required:&nbsp;</label></div>
                        <div class="col"><input type="checkbox" style="margin-top:3%" id="trmnl_no_sig_required" name="trmnl_no_sig_required"></div>
                        <div class="col"><label class="col-form-label">Geofence Facility:&nbsp;</label></div>
						<div class="col">
							<input list="trmnl_geofence_facility" name="trmnl_geofence_facility" id="opsCodeInput" class="form-control mt-1 my-text-height">
							<datalist id="trmnl_geofence_facility">
							<?php
								$gf_facilities = \App\Models\GeofenceFacility::all();
								foreach ($gf_facilities as $gf_facility) {
									echo ("<option value=\"".$gf_facility->facility_name."\">");
								}
							?>
							</datalist>
						</div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Trmnl Latitude:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1" type="number" step="0.000001" id="trmnl_latitude" name="trmnl_latitude"></div>
                        <div class="col"><label class="col-form-label">Trmnl Longitude:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="number" step="0.000001" id="trmnl_longitude" name="trmnl_longitude"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Arrived Latitude:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1" type="number" step="0.000001" id="trmnl_arrived_latitude" name="trmnl_arrived_latitude"></div>
                        <div class="col"><label class="col-form-label">Arrived Longitude:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="number" step="0.000001" id="trmnl_arrived_longitude" name="trmnl_arrived_longitude"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Arrived Radius:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1" type="number" step="0.000001" id="trmnl_arrived_radius" name="trmnl_arrived_radius"></div>
                        <div class="col"><label class="col-form-label">&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" style="visibility: hidden"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Halo Center Latitude:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1" type="number" step="0.000001" id="trmnl_halo_center_latitude" name="trmnl_halo_center_latitude"></div>
                        <div class="col"><label class="col-form-label">Halo Center Longitude:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="number" step="0.000001" id="trmnl_halo_center_longitude" name="trmnl_halo_center_longitude"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Halo Center Radius:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1" type="number" step="0.000001" id="trmnl_halo_center_radius" name="trmnl_halo_center_radius"></div>
                        <div class="col"><label class="col-form-label">&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" style="visibility: hidden"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Ingate Latitude:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1" type="number" step="0.000001" id="trmnl_ingate_latitude" name="trmnl_ingate_latitude"></div>
                        <div class="col"><label class="col-form-label">Ingate Longitude:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="number" step="0.000001" id="trmnl_ingate_longitude" name="trmnl_ingate_longitude"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Ingate Radius:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1" type="number" step="0.000001" id="trmnl_ingate_radius" name="trmnl_ingate_radius"></div>
                        <div class="col"><label class="col-form-label">&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" style="visibility: hidden"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Outgate Latitude:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1" type="number" step="0.000001" id="trmnl_outgate1_latitude" name="trmnl_outgate1_latitude"></div>
                        <div class="col"><label class="col-form-label">Outgate Longitude:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="number" step="0.000001" id="trmnl_outgate1_longitude" name="trmnl_outgate1_longitude"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Outgate Radius:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1" type="number" step="0.000001" id="trmnl_outgate1_radius" name="trmnl_outgate1_radius"></div>
                        <div class="col"><label class="col-form-label">&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" style="visibility: hidden"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Outgate 2 Latitude:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1" type="number" step="0.000001" id="trmnl_outgate2_latitude" name="trmnl_outgate2_latitude"></div>
                        <div class="col"><label class="col-form-label">Outgate 2 Longitude:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="number" step="0.000001" id="trmnl_outgate2_longitude" name="trmnl_outgate2_longitude"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Outgate 2 Radius:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1" type="number" step="0.000001" id="trmnl_outgate2_radius" name="trmnl_outgate2_radius"></div>
                        <div class="col"><label class="col-form-label">&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" style="visibility: hidden"></div>
                    </div>
                    <div class="row my-3">
                        <div class="w-25"></div>
                        <div class="col">
							<div class="row">
								<button class="btn btn-success mx-4" type="submit">Save</button>
								<button class="btn btn-secondary mx-3" type="button"><a href="{{route('terminal_main')}}">Cancel</a></button>
							</div>
						</div>
                        <div class="col"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
	
	<script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.0/dist/js.cookie.min.js"></script>
@endsection
