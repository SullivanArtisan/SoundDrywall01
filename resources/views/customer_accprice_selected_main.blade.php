@extends('layouts.home_page_base')

@section('goback')
	<a class="text-primary" href="{{route('home_page')}}" style="margin-right: 10px;">Back</a>
@show

@section('function_page')
	<!--
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
	-->
	
	<style>
		.nav-tabs .nav-item .nav-link {
		  background-color: #A9DFBF;
		  color: #FFF;
		  -webkit-border-top-left-radius: 10px;
		  -webkit-border-top-right-radius: 10px;
		  -moz-border-radius-topleft: 10px;
		  -moz-border-radius-topright: 10px;
		  border-top-left-radius: 10px;
		  border-top-right-radius: 10px; 
		}

		.nav-tabs .nav-item .nav-link.active {
		  background-color: #FFF;
		  color: #117A65;
		  font-weight: bold;
		  -webkit-border-top-left-radius: 10px;
		  -webkit-border-top-right-radius: 10px;
		  -moz-border-radius-topleft: 10px;
		  -moz-border-radius-topright: 10px;
		  border-top-left-radius: 10px;
		  border-top-right-radius: 10px; 
		}

		.tab-content {
		  border: 1px solid #dee2e6;
		  border-top: transparent;
		  padding: 1px;
		}

		.tab-content .tab-pane {
		  background-color: #FFF;
		  color: #A9DFBF;
		  min-height: 200px;
		  height: auto;
		  padding: 10px 14px;
		}	
	</style>

<?php
	use App\Models\Customer;
	use App\Models\CstmAccountPrice;
	use App\Models\Zone;
	
	$zones = Zone::all()->sortBy('zone_name');
	$id = $_GET['id'];
	if ($id) {
		$customer_accprice = CstmAccountPrice::where('id', $id)->first();
		$customerId = Customer::where('cstm_account_no', $customer_accprice->cstm_account_no)->first()->id;
	}
?>

    <div>
        <div class="row m-4">
            <div>
				<h2 class="text-muted pl-2">Customer {{$customer_accprice->cstm_account_no}}'s Price (from zone {{$customer_accprice->cstm_account_from}} &#x27A1; {{$customer_accprice->cstm_account_to}})</h2>
            </div>
			<div class="col-1 my-auto ml-5">
				<button class="btn btn-danger me-2" type="button"><a href="{{route('customer_accprice_delete', ['id'=>$id])}}" onclick="return myConfirmation();">Delete</a></button>
			</div>
        </div>
    </div>
	
	@if ($errors->any())
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif
	<div class="col-md-11 mb-4">
		<form method="post" action="{{route('customer_accprice_update')}}">
			@csrf
			<div class="row">
				<div class="col"><label class="col-form-label">Zone From:&nbsp;</label></div>
				<div class="col">
					<input list="cstm_account_from" name="cstm_account_from" id="cstm_account_from_li" class="form-control mt-1 my-text-height" value="{{$customer_accprice->cstm_account_from}}">
					<datalist id="cstm_account_from">
					<?php
						foreach ($zones as $zone) {
							echo "<option value=\"".$zone->zone_name."\">";
						}
					?>
					</datalist></input></div>
				<div class="col"><label class="col-form-label">Zone To:&nbsp;</label></div>
				<div class="col">
					<input list="cstm_account_to" name="cstm_account_to" id="cstm_account_to_li" class="form-control mt-1 my-text-height" value="{{$customer_accprice->cstm_account_to}}">
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
					<input list="cstm_account_chassis" name="cstm_account_chassis" id="cstm_account_chassis_li" class="form-control mt-1 my-text-height" value="{{$customer_accprice->cstm_account_chassis}}">
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
				<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="cstm_account_job_type" name="cstm_account_job_type" value="{{$customer_accprice->cstm_account_job_type}}"></div>
			</div>
			<div class="row">
				<div class="col"><label class="col-form-label">Empty Location:&nbsp;</label></div>
				<div class="col">
					<input list="cstm_account_mt_return" name="cstm_account_mt_return" id="cstm_account_mt_return_li" class="form-control mt-1 my-text-height" value="{{$customer_accprice->cstm_account_mt_return}}">
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
				<div class="col"><input class="form-control mt-1 my-text-height" type="number" id="cstm_account_charge" name="cstm_account_charge" value="{{$customer_accprice->cstm_account_charge}}" step="any"></div>
			</div>
			<div class="row">
				<div class="col"><label class="col-form-label">Fuel Surcharge:&nbsp;</label></div>
				<div class="col"><input class="form-control mt-1 my-text-height" type="number" id="cstm_account_fuel_surcharge" name="cstm_account_fuel_surcharge" value="{{$customer_accprice->cstm_account_fuel_surcharge}}" step="any"></div>
				<div class="col"><label class="col-form-label">Override:&nbsp;</label></div>
				@if ($customer_accprice->cstm_account_surcharge_override === 1)
					<div class="col"><input type="checkbox" style="margin-top:3%" id="cstm_account_surcharge_override" name="cstm_account_surcharge_override" checked></div>
				@else
					<div class="col"><input type="checkbox" style="margin-top:3%" id="cstm_account_surcharge_override" name="cstm_account_surcharge_override"></div>
				@endif
			</div>
			<div class="row">
				<div class="col"><label class="col-form-label">One Way:&nbsp;</label></div>
				@if ($customer_accprice->cstm_account_one_way === 1)
					<div class="col"><input type="checkbox" style="margin-top:3%" id="cstm_account_one_way" name="cstm_account_one_way" checked></div>
				@else
					<div class="col"><input type="checkbox" style="margin-top:3%" id="cstm_account_one_way" name="cstm_account_one_way"></div>
				@endif
				<div class="col"><label class="col-form-label"></label></div>
				<div class="col"><input class="form-control mt-1 my-text-height" id="account_price_id" name="account_price_id" value="{{$id}}" type="hidden"></div>
			</div>
			<div class="row my-3">
				<div class="w-25"></div>
				<div class="col">
					<div class="row">
						<button class="btn btn-warning mx-4" type="submit">Update</button>
						<button class="btn btn-secondary mx-3" type="button"><a href="customer_selected?id={{$customerId}}">Cancel</a></button>
					</div>
				</div>
				<div class="col"></div>
			</div>
		</form>
	</div>
		
	<script>
		function myConfirmation() {
			if(!confirm("Are you sure to delete this account price?"))
			event.preventDefault();
		}
	</script>
@endsection

<script>
	function GetSearchResult(search_by) {
		unit_search_value = document.getElementById('customer_search_input').value;
		if (unit_search_value) {
			param = search_by + '=' + unit_search_value;
			url = "{{ route('customer_condition_selected', '::') }}";
			url = url.replace('::', param);
			document.location.href=url;
		}
	}
</script>