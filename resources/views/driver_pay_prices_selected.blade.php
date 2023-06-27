<?php
	use App\Models\DriverPrices;
	use App\Models\Zone;
?>

@extends('layouts.home_page_base')
<style>
.my-text-height {height:75%;}
</style>

@section('goback')
	<a class="text-primary" href="{{route('driver_pay_prices_main')}}" style="margin-right: 10px;">Back</a>
@show

<?php
	$zones = Zone::all()->sortBy('zone_name');
	$id = $_GET['id'];
	if ($id) {
		$price = DriverPrices::where('id', $id)->first();
	}
?>

@if (!$id or !$price) {
	@section('function_page')
		<div>
			<div class="row">
				<div class="col col-sm-auto">
					<h2 class="text-muted pl-2">Result of the Driver Pay Price Operation</h2>
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
					<h2 class="text-muted pl-2">Price: {{$price->drvr_pay_price_zone_from}}&#x27A1;{{$price->drvr_pay_price_zone_to}}</h2>
				</div>
				<div class="col my-auto ml-5">
					<button class="btn btn-danger me-2" type="button"><a href="{{route('driver_pay_prices_delete', ['id'=>$id])}}" onclick="return myConfirmation();">Delete</a></button>
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
					<form method="post" action="{{route('op_result.driver_price_update', ['id'=>$id])}}">
						@csrf
						<div class="row">
							<div class="col"><label class="col-form-label">Zone From:&nbsp;</label></div>
							<div class="col">
								<input list="drvr_pay_price_zone_from" name="drvr_pay_price_zone_from" id="cstm_account_from_li" class="form-control mt-1 my-text-height" value="{{$price->drvr_pay_price_zone_from}}">
								<datalist id="drvr_pay_price_zone_from">
								<?php
									foreach ($zones as $zone) {
										echo "<option value=\"".$zone->zone_name."\">";
									}
								?>
								</datalist></input></div>
							<div class="col"><label class="col-form-label">Zone To:&nbsp;</label></div>
							<div class="col">
								<input list="drvr_pay_price_zone_to" name="drvr_pay_price_zone_to" id="cstm_account_to_li" class="form-control mt-1 my-text-height" value="{{$price->drvr_pay_price_zone_to}}">
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
								<input list="drvr_pay_price_chassis" name="drvr_pay_price_chassis" id="cstm_account_chassis_li" class="form-control mt-1 my-text-height" value="{{$price->drvr_pay_price_chassis}}">
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
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="drvr_pay_price_job_type" name="drvr_pay_price_job_type" value="{{$price->drvr_pay_price_job_type}}"></div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">Pay:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="number" id="drvr_pay_price_charge" name="drvr_pay_price_charge" step="any" value="{{$price->drvr_pay_price_charge}}"></div>
							<div class="col"><label class="col-form-label">One Way:&nbsp;</label></div>
							@if ($price->drvr_pay_price_one_way === 1)
								<div class="col"><input type="checkbox" style="margin-top:3%" id="drvr_pay_price_one_way" name="cstm_account_surcharge_override" checked></div>
							@else
								<div class="col"><input type="checkbox" style="margin-top:3%" id="drvr_pay_price_one_way" name="cstm_account_surcharge_override"></div>
							@endif
						</div>
						<div class="row">
							<div class="col-3"><label class="col-form-label">Notes:&nbsp;</label></div>
							<div class="col-9"><textarea class="form-control mt-1" rows="15" type="text" id="drvr_pay_price_notes" name="drvr_pay_price_notes" placeholder="{{$price->drvr_pay_price_notes}}">{{$price->drvr_pay_price_notes}}</textarea></div>
						</div>
						<div class="row my-3">
							<div class="w-25"></div>
							<div class="col">
								<div class="row">
									<button class="btn btn-warning mx-4" type="submit">Update</button>
									<button class="btn btn-secondary mx-3" type="button"><a href="{{route('driver_pay_prices_main')}}">Cancel</a></button>
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
				if(!confirm("Are you sure to delete this driver price?"))
				event.preventDefault();
			}
		</script>
	@endsection
}
@endif

	<?php
	?>

