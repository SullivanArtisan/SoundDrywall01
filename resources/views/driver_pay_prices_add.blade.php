<?php
	use Illuminate\Support\Facades\Session;
	use App\Models\Zone;
	
	$zones = Zone::all()->sortBy('zone_name');
?>

@extends('layouts.home_page_base')
<style>
.my-text-height {height:75%;}
</style>

@section('goback')
	<a class="text-primary" href="{{route('driver_pay_prices_main')}}" style="margin-right: 10px;">Back</a>
@show

@section('function_page')
	<div>
		<h2 class="text-muted pl-2 mb-2">Add New Price</h2>
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
				<form method="post" action="{{route('op_result.driver_price_add')}}">
					@csrf
					<div class="row">
						<div class="col"><label class="col-form-label">Zone From:&nbsp;</label></div>
						<div class="col">
							<input list="drvr_pay_price_zone_from" name="drvr_pay_price_zone_from" id="cstm_account_from_li" class="form-control mt-1 my-text-height">
							<datalist id="drvr_pay_price_zone_from">
							<?php
								foreach ($zones as $zone) {
									echo "<option value=\"".$zone->zone_name."\">";
								}
							?>
							</datalist></input></div>
						<div class="col"><label class="col-form-label">Zone To:&nbsp;</label></div>
						<div class="col">
							<input list="drvr_pay_price_zone_to" name="drvr_pay_price_zone_to" id="cstm_account_to_li" class="form-control mt-1 my-text-height">
							<datalist id="drvr_pay_price_zone_to">
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
							<input list="drvr_pay_price_chassis" name="drvr_pay_price_chassis" id="cstm_account_chassis_li" class="form-control mt-1 my-text-height">
								<datalist id="drvr_pay_price_chassis">
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
						<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="drvr_pay_price_job_type" name="drvr_pay_price_job_type"></div>
					</div>
					<div class="row">
						<div class="col"><label class="col-form-label">Charge:&nbsp;</label></div>
						<div class="col"><input class="form-control mt-1 my-text-height" type="number" id="drvr_pay_price_charge" name="drvr_pay_price_charge" step="any"></div>
						<div class="col"><label class="col-form-label">One Way:&nbsp;</label></div>
						<div class="col"><input type="checkbox" style="margin-top:3%" id="drvr_pay_price_one_way" name="drvr_pay_price_one_way"></div>
					</div>
					<div class="row">
						<div class="col-3"><label class="col-form-label">Notes:&nbsp;</label></div>
						<div class="col-9"><textarea class="form-control mt-1" rows="15" type="text" id="drvr_pay_price_notes" name="drvr_pay_price_notes"></textarea></div>
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
