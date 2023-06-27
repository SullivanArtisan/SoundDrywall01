<?php
	use App\Models\Customer;
	use App\Models\CstmAccountPrice;
	use App\Models\Zone;
	
	$zones = Zone::all()->sortBy('zone_name');
	$id = $_GET['id'];
	if ($id) {
		$customer = Customer::where('id', $id)->first();
	}
?>

@extends('layouts.home_page_base')
<style>
.my-text-height {height:75%;}
</style>

@section('goback')
	<a class="text-primary" href="{{route('customer_main')}}" style="margin-right: 10px;">Back</a>
@show

@section('function_page')
	<div>
		<h2 class="text-muted pl-2 mb-2">Add a New Price for customer {{$customer->cstm_account_name}}</h2>
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
				<form method="post" action="{{route('op_result.customer_accprice_add', ['id' => $id])}}">
					@csrf
					<div class="row">
						<div class="col"><label class="col-form-label">Zone From:&nbsp;</label></div>
						<div class="col">
							<input list="cstm_account_from" name="cstm_account_from" id="cstm_account_from_li" class="form-control mt-1 my-text-height">
							<datalist id="cstm_account_from">
							<?php
								foreach ($zones as $zone) {
									echo "<option value=\"".$zone->zone_name."\">";
								}
							?>
							</datalist></input></div>
						<div class="col"><label class="col-form-label">Zone To:&nbsp;</label></div>
						<div class="col">
							<input list="cstm_account_to" name="cstm_account_to" id="cstm_account_to_li" class="form-control mt-1 my-text-height">
							<datalist id="cstm_account_to">
							<?php
								foreach ($zones as $zone) {
									echo "<option value=\"".$zone->zone_name."\">";
								}
							?>
							</datalist></input></div>
					</div>
					<div class="row">
						<div class="col"><label class="col-form-label">Chassis (or Blank):&nbsp;</label></div>
						<div class="col">
							<input list="cstm_account_chassis" name="cstm_account_chassis" id="cstm_account_chassis_li" class="form-control mt-1 my-text-height">
								<datalist id="cstm_account_chassis">
									<option value="12PT">
									<option value="AIRRIDE">
									<option value="BTRAIN">
									<option value="DOUBLE DROP DECK">
									<option value="STEP DECK">
									<option value="SUPER">
									<option value="TANDEM">
									<option value="TRAILER">
									<option value="TRIAXLE">
									<option value="TTRAIN">
								</datalist></div>
						<div class="col"><label class="col-form-label">Job Type:&nbsp;</label></div>
						<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="cstm_account_job_type" name="cstm_account_job_type"></div>
					</div>
					<div class="row">
						<div class="col"><label class="col-form-label">Empty Location:&nbsp;</label></div>
						<div class="col">
							<input list="cstm_account_mt_return" name="cstm_account_mt_return" id="cstm_account_mt_return_li" class="form-control mt-1 my-text-height">
								<datalist id="cstm_account_mt_return">
									<option value="Empty Location 1">
									<option value="Empty Location 2">
									<option value="Empty Location 3">
									<option value="Empty Location 4">
									<option value="Empty Location 5">
									<option value="Empty Location 6">
									<option value="Empty Location 7">
									<option value="Empty Location 8">
									<option value="Empty Location 9">
									<option value="Empty Location 10">
								</datalist></div>
						<div class="col"><label class="col-form-label">Account Charge:&nbsp;</label></div>
						<div class="col"><input class="form-control mt-1 my-text-height" type="number" id="cstm_account_charge" name="cstm_account_charge" step="any"></div>
					</div>
					<div class="row">
						<div class="col"><label class="col-form-label">Fuel Surcharge:&nbsp;<span class="text-danger">(Eg: 10% shall be 0.10)</span></label></div>
						<div class="col"><input class="form-control mt-1 my-text-height" type="number" id="cstm_account_fuel_surcharge" name="cstm_account_fuel_surcharge" step="any"></div>
						<div class="col"><label class="col-form-label">Override:&nbsp;</label></div>
						<div class="col"><input type="checkbox" style="margin-top:3%" id="cstm_account_surcharge_override" name="cstm_account_surcharge_override"></div>
					</div>
					<div class="row">
						<div class="col"><label class="col-form-label">One Way:&nbsp;</label></div>
						<div class="col"><input type="checkbox" style="margin-top:3%" id="cstm_account_one_way" name="cstm_account_one_waycstm_account_one_way"></div>
						<div class="col"><label class="col-form-label"></label></div>
						<div class="col"><input class="form-control mt-1 my-text-height" type="hidden"></div>
					</div>
					<div class="row my-3">
						<div class="w-25"></div>
						<div class="col">
							<div class="row">
								<button class="btn btn-success mx-4" type="submit">Add</button>
								<button class="btn btn-secondary mx-4" id="btn_accprice_cancel"><a href="{{url()->previous()}}">Cancel</a></button>
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
