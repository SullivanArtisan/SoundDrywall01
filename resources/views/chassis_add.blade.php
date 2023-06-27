<?php
	use App\Models\Chassis;
	use Illuminate\Support\Facades\Session;
?>

@extends('layouts.home_page_base')
<style>
.my-text-height {height:75%;}
</style>

@section('goback')
	<a class="text-primary" href="{{route('chassis_main')}}" style="margin-right: 10px;">Back</a>
@show

@section('function_page')
	<div>
		<h2 class="text-muted pl-2 mb-2">Add a New Chassis</h2>
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
                <form method="post" action="{{route('op_result.chassis_add')}}">
					@csrf
						<div class="row mx-2">
							<div class="col"><label class="col-form-label">Chassis Number:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="code"></div>
							<div class="col"><label class="col-form-label">VIN:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="vin"></div>
						</div>
						<div class="row mx-2">
							<div class="col"><label class="col-form-label">Year:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="year"></div>
							<div class="col"><label class="col-form-label">Type:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="type"></div>
						</div>
						<div class="row mx-2">
							<div class="col"><label class="col-form-label">Owner:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="owner"></div>
							<div class="col"><label class="col-form-label">License:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="licence"></div>
						</div>
						<div class="row mx-2">
							<div class="col"><label class="col-form-label">Driver:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="driver"></div>
							<div class="col"><label class="col-form-label">Last Driver:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="lastdriver"></div>
						</div>
						<div class="row mx-2">
							<div class="col"><label class="col-form-label">Container:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="container"></div>
							<div class="col"><label class="col-form-label">Genset No.:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="genset"></div>
						</div>
						<div class="row mx-2">
							<div class="col"><label class="col-form-label">Current Location:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="currentlocation"></div>
							<div class="col"><label class="col-form-label">Last Updated:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="dateupdated"></div>
						</div>
						<div class="row mx-2">
							<div class="col"><label class="col-form-label">PM Inspection:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="pminspection"></div>
							<div class="col"><label class="col-form-label">CVI Inspection:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="cviinspection"></div>
						</div>
						<div class="row mx-2">
							<div class="col"><label class="col-form-label">Leased:&nbsp;</label></div>
						    <div class="col"><input type="checkbox" style="margin-top:3%" id="leased" name="leased"></div>
							<div class="col"><label class="col-form-label">Unconfirmed:&nbsp;</label></div>
						    <div class="col"><input type="checkbox" style="margin-top:3%" id="unconfirmed" name="unconfirmed"></div>
						</div>
						<div class="row mx-2">
							<div class="col"><label class="col-form-label">Alias1:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="alias1"></div>
							<div class="col"><label class="col-form-label">Alias2:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="alias2"></div>
						</div>
						<div class="row mx-2">
							<div class="col"><label class="col-form-label">Alias3:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="alias3"></div>
							<div class="col"><label class="col-form-label">Alias4:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="alias4"></div>
						</div>
                    <div class="row my-3">
                        <div class="w-25"></div>
                        <div class="col">
							<div class="row">
								<button class="btn btn-success mx-4" type="submit">Save</button>
								<button class="btn btn-secondary mx-3" type="button"><a href="{{route('chassis_main')}}">Cancel</a></button>
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
