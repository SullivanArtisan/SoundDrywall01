<?php
	use App\Models\PowerUnit;
	use Illuminate\Support\Facades\Session;
?>

@extends('layouts.home_page_base')
<style>
.my-text-height {height:75%;}
</style>

@section('goback')
	<a class="text-primary" href="{{route('power_unit_main')}}" style="margin-right: 10px;">Back</a>
@show

@section('function_page')
	<div>
		<h2 class="text-muted pl-2 mb-2">Add a New Power Unit</h2>
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
                <form method="post" action="{{route('op_result.power_unit_add')}}">
					@csrf
                    <div class="row">
                        <div class="col"><label class="col-form-label">Unit ID:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="unit_id" name="unit_id"></div>
                        <div class="col"><label class="col-form-label">Year:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="number" id="year" name="year"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Make:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1v" type="text" id="make" name="make"></div>
                        <div class="col"><label class="col-form-label">Color:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="color" name="color"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Plate Number:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="plate_number" name="plate_number"></div>
                        <div class="col"><label class="col-form-label">Seniority:&nbsp;</label></div>
                        <div class="col"><input type="text" style="margin-top:3%" id="seniority" name="seniority"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">VIN:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="vin" name="vin"></div>
                        <div class="col"><label class="col-form-label">Max Licensed Weight:&nbsp;</label></div>
                        <div class="col"><input type="number" style="margin-top:3%" id="max_licensed_weight" name="max_licensed_weight"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Ops Code:&nbsp;</label></div>
						<div class="col">
                            <?php
                            $tagHead = "<input list=\"ops_code\" name=\"ops_code\" id=\"opscodeinput\" class=\"form-control mt-1 my-text-height\" ";
                            $tagTail = "><datalist id=\"ops_code\">";

                            $allTypes = MyHelper::GetAllOpsCodes();
                            foreach($allTypes as $eachType) {
                                $tagTail.= "<option value=".str_replace(' ', '&nbsp;', $eachType).">";
                            }
                            $tagTail.= "</datalist>";
                            echo $tagHead."placeholder=\"\" value=\"\"".$tagTail;
                            ?>
						</div>
                        <div class="col"><label class="col-form-label">Cargo Weight:&nbsp;</label></div>
                        <div class="col"><input type="number" style="margin-top:3%" id="cargo_weight" name="cargo_weight"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Current Driver:&nbsp;&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="current_driver" name="current_driver"></div>
                        <div class="col"><label class="col-form-label">Last Driver:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="last_driver" name="last_driver"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Current Location:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="current_location" name="current_location"></div>
                        <div class="col"><label class="col-form-label">MVI Expiry Date:&nbsp;</label></div>
                        <div class="col"><input type="datetime-local" style="margin-top:3%" id="mvi_expiry_date" name="mvi_expiry_date"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Insurance Expiry Date:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="datetime-local" id="insurance_expiry_date" name="insurance_expiry_date"></div>
                        <div class="col"><label class="col-form-label"></label></div>
                        <div class="col"><input type="hidden" style="margin-top:3%" id="show_internet_bookings" name="show_internet_bookings"></div>
                    </div>
                    <div class="row my-3">
                        <div class="w-25"></div>
                        <div class="col">
							<div class="row">
								<button class="btn btn-success mx-4" type="submit">Save</button>
								<button class="btn btn-secondary mx-3" type="button"><a href="{{route('power_unit_main')}}">Cancel</a></button>
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
