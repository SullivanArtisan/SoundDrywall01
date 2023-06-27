<?php
	use App\Models\Company;
?>

@extends('layouts.home_page_base')
<style>
.my-text-height {height:75%;}
</style>

@section('goback')
	<a class="text-primary" href="{{route('company_main')}}" style="margin-right: 10px;">Back</a>
@show

<?php
	use App\Models\Zone;

	$zones = Zone::all()->sortBy('zone_name');
    $id = $_GET['id'];
	if ($id) {
		$company = Company::where('id', $id)->first();
	}
?>

@if (!$id or !$company) {
	@section('function_page')
		<div>
			<div class="row">
				<div class="col col-sm-auto">
					<h2 class="text-muted pl-2">Result of the Companies Addresses Operation</h2>
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
					<h2 class="text-muted pl-2">Company: {{$company->company_name}}</h2>
				</div>
				<div class="col my-auto ml-5">
					<button class="btn btn-danger me-2" type="button"><a href="{{route('company_delete', ['id'=>$id])}}" onclick="return myConfirmation();">Delete</a></button>
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
					<form method="post" action="{{route('op_result.company_update', ['id'=>$id])}}">
						@csrf
						<div class="row mx-2">
							<div class="col"><label class="col-form-label">Company Name:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="cmpny_name" value="{{$company->cmpny_name}}"></div>
                            <div class="col"><label class="col-form-label">Zone:&nbsp;</label></div>
                            <div class="col">
                                <input list="cmpny_zone" name="cmpny_zone" id="cmpny_zone_li" class="form-control mt-1 my-text-height" value="{{$company->cmpny_zone}}">
                                <datalist id="cmpny_zone">
                                <?php
                                    foreach ($zones as $zone) {
                                        echo "<option value=\"".$zone->zone_name."\">";
                                    }
                                ?>
                                </datalist></input>
                            </div>
						</div>
						<div class="row mx-2">
							<div class="col"><label class="col-form-label">Street Address:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="cmpny_address" value="{{$company->cmpny_address}}"></div>
							<div class="col"><label class="col-form-label">City:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="cmpny_city" value="{{$company->cmpny_city}}"></div>
						</div>
						<div class="row mx-2">
							<div class="col"><label class="col-form-label">Province:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="cmpny_province" value="{{$company->cmpny_province}}"></div>
							<div class="col"><label class="col-form-label">Post Code:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="cmpny_postcode" value="{{$company->cmpny_postcode}}"></div>
						</div>
						<div class="row mx-2">
							<div class="col"><label class="col-form-label">Tel:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="cmpny_tel" value="{{$company->cmpny_tel}}"></div>
							<div class="col"><label class="col-form-label">Email:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="cmpny_email" value="{{$company->cmpny_email}}"></div>
						</div>
						<div class="row mx-2">
							<div class="col"><label class="col-form-label">Contact:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" name="cmpny_contact" value="{{$company->cmpny_contact}}"></div>
                            <div class="col"><label class="col-form-label">Chassis Capability:&nbsp;</label></div>
                            <div class="col">
                                <input list="cmpny_chassis_capability" name="cmpny_chassis_capability" id="cmpny_chassis_capability_li" class="form-control mt-1 my-text-height" value="{{$company->cmpny_chassis_capability}}">
                                    <datalist id="cmpny_chassis_capability">
                                        <option value="DROP_ON_WHELLS">
                                        <option value="LIFT">
                                        <option value="BOTH">
                                    </datalist>
                                </input>
                            </div>
						</div>
						<div class="row my-3">
							<div class="w-25"></div>
							<div class="col">
								<div class="row">
									<button class="btn btn-warning mx-4" type="submit">Update</button>
									<button class="btn btn-secondary mx-3" type="button"><a href="{{route('company_main')}}">Cancel</a></button>
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
				if(!confirm("Are you sure to delete this company address?"))
				event.preventDefault();
			}
		</script>
	@endsection
}
@endif

	<?php
	?>

