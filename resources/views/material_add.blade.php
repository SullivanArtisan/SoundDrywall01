<?php
	use App\Models\Job;
	use App\Models\SizeUnit;
	use App\Models\AmountUnit;
	use App\Models\Provider;
	use App\Models\Material;
	use App\Models\MaterialType;
	use App\Helper\MyHelper;
	use Illuminate\Support\Facades\Session;
?>

@extends('layouts.home_page_base')
<style>
.my-text-height {height:75%;}
</style>

@section('goback')
	<a class="text-primary" href="{{route('material_main', ['display_filter'=>'active'])}}" style="margin-right: 10px;">Back</a>
@show

@section('function_page')
	<?php
		$picPath = Session::get('uploadPath');
		Session::forget(['uploadPath']);

		$job_id = "";
		if (isset($_GET['jobId'])) {
			$job_id = $_GET['jobId'];
		}
	?>
	<div>
		<h2 class="text-muted pl-2 mb-2">Add New Material</h2>
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
        <div class="row mt-4 mx-1">
            <div class="col-12" id="col_screw" style="position: relative; top: 0px; left: 0px;">
				<form method="post" action="{{route('op_result.material_add')}}">
					@csrf
                    <div class="row">
						<div class="col"><label class="col-form-label">Name:&nbsp;</label><span class="text-danger">*</span></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="mtrl_name" name="mtrl_name"></div>
                        <div class="col"><label class="col-form-label">Type:&nbsp;</label><span class="text-danger">*</span></div>
						<div class="col">
							<?php
								$types = MaterialType::all()->sortBy('mtrl_type');
								$tagHead = "<input list=\"mtrl_type\" name=\"mtrl_type\" id=\"mtrltypeinput\" class=\"form-control mt-1 my-text-height\" ";
								$tagTail = "><datalist id=\"mtrl_type\">";
								foreach($types as $type) {
									$tagTail.= "<option value=".str_replace(' ', '&nbsp;', $type->mtrl_type).">";
								}
								$tagTail.= "</datalist>";
								echo $tagHead."placeholder=\"\" value=\"\"".$tagTail;
							?>
						</div>
                    </div>
                    <div class="row">
						<div class="col"><label class="col-form-label">Model:&nbsp;</label><span class="text-danger">*</span></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="mtrl_model" name="mtrl_model"></div>
                        <div class="col"><label class="col-form-label">Used for Job:&nbsp;</label></div>
						<div class="col">
							<?php
								if ($job_id == "") {
									$tagHead = "<input list=\"job_name\" name=\"job_name\" id=\"jobnameinput\" class=\"form-control mt-1 my-text-height\" ";
									$tagTail = "><datalist id=\"job_name\">";
		
									$jobs = Job::all()->where('job_status', '<>', 'DELETED')->where('job_status', '<>', 'CANCELED')->where('job_status', '<>', 'COMPLETED')->sortBy('job_name');
									foreach($jobs as $job) {
										$tagTail.= "<option value=".str_replace(' ', '&nbsp;', $job->job_name).">";
									}
									$tagTail.= "</datalist>";
										echo $tagHead."placeholder=\"\" ".$tagTail;
								} else {
									$job = Job::where('id', $job_id)->first();
									if ($job) {
										echo "<input class=\"form-control mt-1 my-text-height\" readonly type=\"text\" id=\"job_name\" name=\"job_name\" value=\"".$job->job_name."\">";
									} else {
										Log::Info('Failed to access the target job object while doing the "Add a New Material to This Job" button (for job '.$job_id.'".');
										MyHelper::LogStaffActionResult(Auth::user()->id, 'Failed to access the target job object while doing the "Add a New Material to This Job" button (for job '.$job_id.').', '900');
									}
								}
							?>
						</div>
                    </div>
                    <div class="row">
						<div class="col"><label class="col-form-label">Item Size:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="mtrl_size" name="mtrl_size"></div>
                        <div class="col"><label class="col-form-label">Size Unit:&nbsp;</label></div>
						<div class="col">
							<?php
								$tagHead = "<input list=\"mtrl_size_unit\" name=\"mtrl_size_unit\" id=\"mtrlsizeunitinput\" class=\"form-control mt-1 my-text-height\" ";
								$tagTail = "><datalist id=\"mtrl_size_unit\">";

		
								$units = SizeUnit::all()->sortBy('unit_name');
								foreach($units as $unit) {
									$tagTail.= "<option value=".str_replace(' ', '&nbsp;', $unit->unit_name).">";
								}
								$tagTail.= "</datalist>";
								echo $tagHead."placeholder=\"\" value=\"\"".$tagTail;
							?>
						</div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Total Amount:&nbsp;</label><span class="text-danger">*</span></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="number" step="0.01" id="mtrl_amount" name="mtrl_amount"></div>
                        <div class="col"><label class="col-form-label">Amount Unit:&nbsp;</label></div>
						<div class="col">
							<?php
								$tagHead = "<input list=\"mtrl_amount_unit\" name=\"mtrl_amount_unit\" id=\"mtrlsizeunitinput\" class=\"form-control mt-1 my-text-height\" ";
								$tagTail = "><datalist id=\"mtrl_amount_unit\">";

		
								$units = AmountUnit::all()->sortBy('amount_unit_name');
								foreach($units as $unit) {
									$tagTail.= "<option value=".str_replace(' ', '&nbsp;', $unit->amount_unit_name).">";
								}
								$tagTail.= "</datalist>";
								echo $tagHead."placeholder=\"\" value=\"\"".$tagTail;
							?>
						</div>
                    </div>
                    <div class="row">
						<div class="col"><label class="col-form-label">Provider:&nbsp;</label></div>
						<div class="col">
							<?php
								$tagHead = "<input list=\"mtrl_source\" name=\"mtrl_source\" id=\"mtrlsourceinput\" class=\"form-control mt-1 my-text-height\" ";
								$tagTail = "><datalist id=\"mtrl_source\">";

		
								$providers = Provider::all()->sortBy('pvdr_name');
								foreach($providers as $provider) {
									$tagTail.= "<option value=".str_replace(' ', '&nbsp;', $provider->pvdr_name.' ('.$provider->pvdr_address.', '.$provider->pvdr_city.')').">";
								}
								$tagTail.= "</datalist>";
								echo $tagHead."placeholder=\"\" value=\"\"".$tagTail;
							?>
						</div>
						<div class="col"><label class="col-form-label">Shipped by:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="mtrl_shipped_by" name="mtrl_shipped_by" value="same as Provider"></div>
                    </div>
                    <div class="row">
						<div class="col"><label class="col-form-label">Unit Price:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="number" step="0.01" id="mtrl_price" name="mtrl_price"></div>
                        <div class="col"><label class="col-form-label">Total Price:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="number" step="0.01" id="mtrl_total_price" name="mtrl_total_price"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Amount Left:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" readonly type="number" step="0.01" id="mtrl_amount_left" name="mtrl_amount_left"></div>
						<div class="col"><label class="col-form-label">Notes:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="mtrl_notes" name="mtrl_notes"></div>
                    </div>
                    <div class="row">
						<div class="col"><label class="col-form-label">&nbsp;</label></div>
						@if ($job_id == "")
                        <div class="col"><input class="form-control mt-1 my-text-height" type="hidden" id="back_to" name="back_to" value="material_main?display_filter=active"></div>
						@else
                        <div class="col"><input class="form-control mt-1 my-text-height" type="hidden" id="back_to" name="back_to" value="job_combination_main?jobId={{$job_id}}"></div>
						@endif
                    </div>
                    <div class="row my-3">
                        <div class="w-25"></div>
                        <div class="col">
							<div class="row">
								<button class="btn btn-success mx-4" type="submit">Save</button>
								<button class="btn btn-secondary mx-3" type="button"><a href="{{route('material_main', ['display_filter'=>'active'])}}">Cancel</a></button>
							</div>
						</div>
                        <div class="col"></div>
                    </div>
                </form>
			</div>
        </div>
    </div>
	
	<script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.0/dist/js.cookie.min.js"></script>
	<script>
	</script>
			
@endsection
