<?php
	use App\Models\Job;
	use App\Models\SizeUnit;
	use App\Models\AmountUnit;
	use App\Models\Provider;
	use App\Models\Material;
	use App\Models\MaterialType;
	use Illuminate\Support\Facades\Session;
?>

@extends('layouts.home_page_base')
<style>
.my-text-height {height:75%;}
</style>

@section('goback')
	<a class="text-primary" href="{{route('material_main')}}" style="margin-right: 10px;">Back</a>
@show

@section('function_page')
	<?php
		$picPath = Session::get('uploadPath');
		Session::forget(['uploadPath']);

		$job_id = "";
		if (isset($_GET['jobId'])) {
			$job_id = $_GET['jobId'];
		}

		if (!isset($_GET['mtrlType'])) {
			$mtrl_type = 'INSULATION';
		} else {
			$mtrl_type = $_GET['mtrlType'];
		}
	?>
	<div>
		<h2 class="text-muted pl-2 mb-2">Add New Material</h2>
		<div class="ml-2">
			<label>(for Type:</label>
			<input type="radio" class="mx-2" id="rdo_insulation" name="for_mtrl_type" onclick="RdoSelected(this.id)" checked><label>Insulation</label>
			<input type="radio" class="mx-2" id="rdo_drywall" name="for_mtrl_type" onclick="RdoSelected(this.id)"><label>Drywall</label>
			<input type="radio" class="mx-2" id="rdo_screw" name="for_mtrl_type" onclick="RdoSelected(this.id)"><label>Screw</label>
			<input type="radio" class="mx-2" id="rdo_tape" name="for_mtrl_type" onclick="RdoSelected(this.id)"><label>Tape</label>
			<input type="radio" class="mx-2" id="rdo_other" name="for_mtrl_type" onclick="RdoSelected(this.id)"><label>Stud/Track/Channel</label>
			<label>)</label>
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
        <div class="row mt-4 mx-1">
			<!--------------------->
			<!-- for Insulations -->
			<!--------------------->
			@if ($mtrl_type == 'INSULATION')
            <div class="col-12" id="col_insulation" style="position: relative; top: 0px; left: 0px;">
                <form method="post" action="{{route('op_result.material_add')}}">
					@csrf
                    <div class="row">
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
									// if (isset($_GET['selJobId'])) {
									// 	echo $tagHead."placeholder=\"".$booking->bk_job_type."\" value=\"".$booking->bk_job_type."\"".$tagTail;
									// } else {
										echo $tagHead."placeholder=\"\" ".$tagTail;
									// }
								} else {
									$job = Job::where('id', $job_id)->first();
									if ($job) {
										echo "<input class=\"form-control mt-1 my-text-height\" readonly type=\"text\" id=\"job_name\" name=\"job_name\" value=\"".$job->job_name."\">";
									} else {
										Log::Info('Failed to access the target job object while doing the "Add a New Material to This Job" button (for job '.$job_id.'".');
									}
								}
							?>
						</div>
						<div class="col"><label class="col-form-label">Model/Description:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="mtrl_model" name="mtrl_model"></div>
                    </div>
					<!--
                    <div class="row">
						<div class="col"><label class="col-form-label">Item Size:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="mtrl_size" name="mtrl_size"></div>
                        <div class="col"><label class="col-form-label">Size Unit:&nbsp;</label></div>
						<div class="col">
							<?php
								// $tagHead = "<input list=\"mtrl_size_unit\" name=\"mtrl_size_unit\" id=\"mtrlsizeunitinput\" class=\"form-control mt-1 my-text-height\" ";
								// $tagTail = "><datalist id=\"mtrl_size_unit\">";

		
								// $units = SizeUnit::all()->sortBy('unit_name');
								// foreach($units as $unit) {
								// 	$tagTail.= "<option value=".str_replace(' ', '&nbsp;', $unit->unit_name).">";
								// }
								// $tagTail.= "</datalist>";
								// // if (isset($_GET['selJobId'])) {
								// // 	echo $tagHead."placeholder=\"".$booking->bk_job_type."\" value=\"".$booking->bk_job_type."\"".$tagTail;
								// // } else {
								// 	echo $tagHead."placeholder=\"\" value=\"SqFt\"".$tagTail;
								// // }
							?>
						</div>
                    </div>
					-->
                    <div class="row">
                        <div class="col"><label class="col-form-label">Total Amount:&nbsp;</label></div>
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
								// if (isset($_GET['selJobId'])) {
								// 	echo $tagHead."placeholder=\"".$booking->bk_job_type."\" value=\"".$booking->bk_job_type."\"".$tagTail;
								// } else {
									echo $tagHead."placeholder=\"\" value=\"SqFt\"".$tagTail;
								// }
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
								// if (isset($_GET['selJobId'])) {
								// 	echo $tagHead."placeholder=\"".$booking->bk_job_type."\" value=\"".$booking->bk_job_type."\"".$tagTail;
								// } else {
									echo $tagHead."placeholder=\"\" value=\"\"".$tagTail;
								// }
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
                        <div class="col"><input class="form-control mt-1 my-text-height" type="hidden" id="mtrl_type" name="mtrl_type" value="{{$mtrl_type}}"></div>
						<div class="col"><label class="col-form-label">&nbsp;</label></div>
						@if ($job_id == "")
                        <div class="col"><input class="form-control mt-1 my-text-height" type="hidden" id="back_to" name="back_to" value="material_main"></div>
						@else
                        <div class="col"><input class="form-control mt-1 my-text-height" type="hidden" id="back_to" name="back_to" value="job_combination_main?jobId={{$job_id}}"></div>
						@endif
                    </div>
					<!--
                    <div class="row">
                        <div class="col"><label class="col-form-label">Material Type:&nbsp;</label></div>
						<div class="col">
                            <?php
                                // $tagHead = "<input list=\"mtrl_type\" name=\"mtrl_type\" id=\"mtrltypeinput\" class=\"form-control mt-1 my-text-height\" ";
                                // $tagTail = "><datalist id=\"mtrl_type\">";

                                // $types = MaterialType::all()->sortBy('mtrl_type');
                                // foreach($types as $type) {
                                //     $tagTail.= "<option value=".str_replace(' ', '&nbsp;', $type->mtrl_type).">";
                                // }
                                // $tagTail.= "</datalist>";
                                // echo $tagHead."placeholder=\"\" value=\"\"".$tagTail;
                            ?>
						</div>
                        <div class="col"><label class="col-form-label">&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="hidden" ></div>
                    </div>
							-->
                    <div class="row my-3">
                        <div class="w-25"></div>
                        <div class="col">
							<div class="row">
								<button class="btn btn-success mx-4" type="submit">Save</button>
								<button class="btn btn-secondary mx-3" type="button"><a href="{{route('material_main')}}">Cancel</a></button>
							</div>
						</div>
                        <div class="col"></div>
                    </div>
                </form>
			</div>
			@elseif ($mtrl_type == 'DRYWALL')
			<!------------------>
			<!-- for Drywalls -->
			<!------------------>
			<div class="col-12" id="col_drywall" style="position: relative; top: 0px; left: 0px;">
				<form method="post" action="{{route('op_result.material_add')}}">
					@csrf
                    <div class="row">
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
									// if (isset($_GET['selJobId'])) {
									// 	echo $tagHead."placeholder=\"".$booking->bk_job_type."\" value=\"".$booking->bk_job_type."\"".$tagTail;
									// } else {
										echo $tagHead."placeholder=\"\" ".$tagTail;
									// }
								} else {
									$job = Job::where('id', $job_id)->first();
									if ($job) {
										echo "<input class=\"form-control mt-1 my-text-height\" readonly type=\"text\" id=\"job_name\" name=\"job_name\" value=\"".$job->job_name."\">";
									} else {
										Log::Info('Failed to access the target job object while doing the "Add a New Material to This Job" button (for job '.$job_id.'".');
									}
								}
							?>
						</div>
						<div class="col"><label class="col-form-label">Model/Description:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="mtrl_model" name="mtrl_model"></div>
                    </div>
                    <div class="row">
						<div class="col"><label class="col-form-label">Thickness:&nbsp;</label></div>
						<div class="col">
							<?php	//mtrl_size here for Drywall is actually mtrl_thickness !!
								$tagHead = "<input list=\"mtrl_size\" name=\"mtrl_size\" id=\"mtrlsizeinput\" class=\"form-control mt-1 my-text-height\" ";
								$tagTail = "><datalist id=\"mtrl_size\">";

		
								$tagTail.= "<option value=\"1/2\">";
								$tagTail.= "<option value=\"5/8\">";
								$tagTail.= "<option value=\"3/8\">";
								$tagTail.= "<option value=\"1/4\">";
								$tagTail.= "<option value=\"7/16\">";
								$tagTail.= "<option value=\"1\">";
								$tagTail.= "</datalist>";
								echo $tagHead."placeholder=\"\"".$tagTail;
							?>
						</div>
                        <div class="col"><label class="col-form-label">Thickness Unit:&nbsp;</label></div>
						<div class="col">
							<?php
								$tagHead = "<input list=\"mtrl_size_unit\" name=\"mtrl_size_unit\" id=\"mtrlsizeunitinput\" class=\"form-control mt-1 my-text-height\" ";
								$tagTail = "><datalist id=\"mtrl_size_unit\">";

		
								$units = SizeUnit::all()->sortBy('unit_name');
								foreach($units as $unit) {
									$tagTail.= "<option value=".str_replace(' ', '&nbsp;', $unit->unit_name).">";
								}
								$tagTail.= "</datalist>";
								// if (isset($_GET['selJobId'])) {
								// 	echo $tagHead."placeholder=\"".$booking->bk_job_type."\" value=\"".$booking->bk_job_type."\"".$tagTail;
								// } else {
									echo $tagHead."placeholder=\"\" value=\"INCH\"".$tagTail;
								// }
							?>
						</div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Total Amount:&nbsp;</label></div>
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
								// if (isset($_GET['selJobId'])) {
								// 	echo $tagHead."placeholder=\"".$booking->bk_job_type."\" value=\"".$booking->bk_job_type."\"".$tagTail;
								// } else {
									echo $tagHead."placeholder=\"\" value=\"SHEET\"".$tagTail;
								// }
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
								// if (isset($_GET['selJobId'])) {
								// 	echo $tagHead."placeholder=\"".$booking->bk_job_type."\" value=\"".$booking->bk_job_type."\"".$tagTail;
								// } else {
									echo $tagHead."placeholder=\"\" value=\"\"".$tagTail;
								// }
							?>
						</div>
						<div class="col"><label class="col-form-label">Shipped by:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="mtrl_shipped_by" name="mtrl_shipped_by" value="same as Provider"></div>
                    </div>
                    <div class="row">
						<div class="col"><label class="col-form-label">Unit Price (MSF):&nbsp;</label></div>
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
                        <div class="col"><input class="form-control mt-1 my-text-height" type="hidden" id="mtrl_type" name="mtrl_type" value="{{$mtrl_type}}"></div>
						<div class="col"><label class="col-form-label">&nbsp;</label></div>
						@if ($job_id == "")
                        <div class="col"><input class="form-control mt-1 my-text-height" type="hidden" id="back_to" name="back_to" value="material_main"></div>
						@else
                        <div class="col"><input class="form-control mt-1 my-text-height" type="hidden" id="back_to" name="back_to" value="job_combination_main?jobId={{$job_id}}"></div>
						@endif
                    </div>
                    <div class="row my-3">
                        <div class="w-25"></div>
                        <div class="col">
							<div class="row">
								<button class="btn btn-success mx-4" type="submit">Save</button>
								<button class="btn btn-secondary mx-3" type="button"><a href="{{route('material_main')}}">Cancel</a></button>
							</div>
						</div>
                        <div class="col"></div>
                    </div>
                </form>
            </div>
			@elseif ($mtrl_type == 'SCREW') 
			<!---------------->
			<!-- for Screws -->
			<!---------------->
            <div class="col-12" id="col_screw" style="position: relative; top: 0px; left: 0px;">
				<form method="post" action="{{route('op_result.material_add')}}">
					@csrf
                    <div class="row">
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
									// if (isset($_GET['selJobId'])) {
									// 	echo $tagHead."placeholder=\"".$booking->bk_job_type."\" value=\"".$booking->bk_job_type."\"".$tagTail;
									// } else {
										echo $tagHead."placeholder=\"\" ".$tagTail;
									// }
								} else {
									$job = Job::where('id', $job_id)->first();
									if ($job) {
										echo "<input class=\"form-control mt-1 my-text-height\" readonly type=\"text\" id=\"job_name\" name=\"job_name\" value=\"".$job->job_name."\">";
									} else {
										Log::Info('Failed to access the target job object while doing the "Add a New Material to This Job" button (for job '.$job_id.'".');
									}
								}
							?>
						</div>
						<div class="col"><label class="col-form-label">Model/Description:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="mtrl_model" name="mtrl_model"></div>
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
								// if (isset($_GET['selJobId'])) {
								// 	echo $tagHead."placeholder=\"".$booking->bk_job_type."\" value=\"".$booking->bk_job_type."\"".$tagTail;
								// } else {
									echo $tagHead."placeholder=\"\" value=\"INCH\"".$tagTail;
								// }
							?>
						</div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Total Amount:&nbsp;</label></div>
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
								// if (isset($_GET['selJobId'])) {
								// 	echo $tagHead."placeholder=\"".$booking->bk_job_type."\" value=\"".$booking->bk_job_type."\"".$tagTail;
								// } else {
									echo $tagHead."placeholder=\"\" value=\"PIECE\"".$tagTail;
								// }
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
								// if (isset($_GET['selJobId'])) {
								// 	echo $tagHead."placeholder=\"".$booking->bk_job_type."\" value=\"".$booking->bk_job_type."\"".$tagTail;
								// } else {
									echo $tagHead."placeholder=\"\" value=\"\"".$tagTail;
								// }
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
                        <div class="col"><input class="form-control mt-1 my-text-height" type="hidden" id="mtrl_type" name="mtrl_type" value="{{$mtrl_type}}"></div>
						<div class="col"><label class="col-form-label">&nbsp;</label></div>
						@if ($job_id == "")
                        <div class="col"><input class="form-control mt-1 my-text-height" type="hidden" id="back_to" name="back_to" value="material_main"></div>
						@else
                        <div class="col"><input class="form-control mt-1 my-text-height" type="hidden" id="back_to" name="back_to" value="job_combination_main?jobId={{$job_id}}"></div>
						@endif
                    </div>
                    <div class="row my-3">
                        <div class="w-25"></div>
                        <div class="col">
							<div class="row">
								<button class="btn btn-success mx-4" type="submit">Save</button>
								<button class="btn btn-secondary mx-3" type="button"><a href="{{route('material_main')}}">Cancel</a></button>
							</div>
						</div>
                        <div class="col"></div>
                    </div>
                </form>
			</div>
			@elseif ($mtrl_type == 'TAPE') 
			<!--------------->
			<!-- for Tapes -->
			<!--------------->
            <div class="col-12" id="col_tape" style="position: relative; top: 0px; left: 0px;">
				<form method="post" action="{{route('op_result.material_add')}}">
					@csrf
                    <div class="row">
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
									// if (isset($_GET['selJobId'])) {
									// 	echo $tagHead."placeholder=\"".$booking->bk_job_type."\" value=\"".$booking->bk_job_type."\"".$tagTail;
									// } else {
										echo $tagHead."placeholder=\"\" ".$tagTail;
									// }
								} else {
									$job = Job::where('id', $job_id)->first();
									if ($job) {
										echo "<input class=\"form-control mt-1 my-text-height\" readonly type=\"text\" id=\"job_name\" name=\"job_name\" value=\"".$job->job_name."\">";
									} else {
										Log::Info('Failed to access the target job object while doing the "Add a New Material to This Job" button (for job '.$job_id.'".');
									}
								}
							?>
						</div>
						<div class="col"><label class="col-form-label">Model/Description:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="mtrl_model" name="mtrl_model"></div>
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
								// if (isset($_GET['selJobId'])) {
								// 	echo $tagHead."placeholder=\"".$booking->bk_job_type."\" value=\"".$booking->bk_job_type."\"".$tagTail;
								// } else {
									echo $tagHead."placeholder=\"\" value=\"SqFt\"".$tagTail;
								// }
							?>
						</div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Total Amount:&nbsp;</label></div>
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
								// if (isset($_GET['selJobId'])) {
								// 	echo $tagHead."placeholder=\"".$booking->bk_job_type."\" value=\"".$booking->bk_job_type."\"".$tagTail;
								// } else {
									echo $tagHead."placeholder=\"\" value=\"ROLL\"".$tagTail;
								// }
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
								// if (isset($_GET['selJobId'])) {
								// 	echo $tagHead."placeholder=\"".$booking->bk_job_type."\" value=\"".$booking->bk_job_type."\"".$tagTail;
								// } else {
									echo $tagHead."placeholder=\"\" value=\"\"".$tagTail;
								// }
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
                        <div class="col"><input class="form-control mt-1 my-text-height" type="hidden" id="mtrl_type" name="mtrl_type" value="{{$mtrl_type}}"></div>
						<div class="col"><label class="col-form-label">&nbsp;</label></div>
						@if ($job_id == "")
                        <div class="col"><input class="form-control mt-1 my-text-height" type="hidden" id="back_to" name="back_to" value="material_main"></div>
						@else
                        <div class="col"><input class="form-control mt-1 my-text-height" type="hidden" id="back_to" name="back_to" value="job_combination_main?jobId={{$job_id}}"></div>
						@endif
                    </div>
                    <div class="row my-3">
                        <div class="w-25"></div>
                        <div class="col">
							<div class="row">
								<button class="btn btn-success mx-4" type="submit">Save</button>
								<button class="btn btn-secondary mx-3" type="button"><a href="{{route('material_main')}}">Cancel</a></button>
							</div>
						</div>
                        <div class="col"></div>
                    </div>
                </form>
			</div>
			@else
			<!------------------------------------>
			<!-- for Other (Stud/Track/Channel) -->
			<!------------------------------------>
            <div class="col-12" id="col_other" style="position: relative; top: 0px; left: 0px;">
				<form method="post" action="{{route('op_result.material_add')}}">
					@csrf
                    <div class="row">
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
									// if (isset($_GET['selJobId'])) {
									// 	echo $tagHead."placeholder=\"".$booking->bk_job_type."\" value=\"".$booking->bk_job_type."\"".$tagTail;
									// } else {
										echo $tagHead."placeholder=\"\" ".$tagTail;
									// }
								} else {
									$job = Job::where('id', $job_id)->first();
									if ($job) {
										echo "<input class=\"form-control mt-1 my-text-height\" readonly type=\"text\" id=\"job_name\" name=\"job_name\" value=\"".$job->job_name."\">";
									} else {
										Log::Info('Failed to access the target job object while doing the "Add a New Material to This Job" button (for job '.$job_id.'".');
									}
								}
							?>
						</div>
						<div class="col"><label class="col-form-label">Model/Description:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="mtrl_model" name="mtrl_model"></div>
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
								// if (isset($_GET['selJobId'])) {
								// 	echo $tagHead."placeholder=\"".$booking->bk_job_type."\" value=\"".$booking->bk_job_type."\"".$tagTail;
								// } else {
									echo $tagHead."placeholder=\"\" value=\"FT\"".$tagTail;
								// }
							?>
						</div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Total Amount:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="number" step="1" id="mtrl_amount" name="mtrl_amount"></div>
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
								// if (isset($_GET['selJobId'])) {
								// 	echo $tagHead."placeholder=\"".$booking->bk_job_type."\" value=\"".$booking->bk_job_type."\"".$tagTail;
								// } else {
									echo $tagHead."placeholder=\"\" value=\"PIECE\"".$tagTail;
								// }
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
								// if (isset($_GET['selJobId'])) {
								// 	echo $tagHead."placeholder=\"".$booking->bk_job_type."\" value=\"".$booking->bk_job_type."\"".$tagTail;
								// } else {
									echo $tagHead."placeholder=\"\" value=\"\"".$tagTail;
								// }
							?>
						</div>
						<div class="col"><label class="col-form-label">Shipped by:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="mtrl_shipped_by" name="mtrl_shipped_by" value="same as Provider"></div>
                    </div>
                    <div class="row">
						<div class="col"><label class="col-form-label">Unit Price (MLF):&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="number" step="0.01" id="mtrl_price" name="mtrl_price"></div>
                        <div class="col"><label class="col-form-label">Total Price:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="number" step="0.01" id="mtrl_total_price" name="mtrl_total_price"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Amount Left:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" readonly type="number" step="1" id="mtrl_amount_left" name="mtrl_amount_left"></div>
						<div class="col"><label class="col-form-label">Notes:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="mtrl_notes" name="mtrl_notes"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="hidden" id="mtrl_type" name="mtrl_type" value="{{$mtrl_type}}"></div>
						<div class="col"><label class="col-form-label">&nbsp;</label></div>
						@if ($job_id == "")
                        <div class="col"><input class="form-control mt-1 my-text-height" type="hidden" id="back_to" name="back_to" value="material_main"></div>
						@else
                        <div class="col"><input class="form-control mt-1 my-text-height" type="hidden" id="back_to" name="back_to" value="job_combination_main?jobId={{$job_id}}"></div>
						@endif
                   </div>
                    <div class="row my-3">
                        <div class="w-25"></div>
                        <div class="col">
							<div class="row">
								<button class="btn btn-success mx-4" type="submit">Save</button>
								<button class="btn btn-secondary mx-3" type="button"><a href="{{route('material_main')}}">Cancel</a></button>
							</div>
						</div>
                        <div class="col"></div>
                    </div>
                </form>
			</div>
			@endif
        </div>
    </div>
	
	<script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.0/dist/js.cookie.min.js"></script>
	<script>
		// var rdoSelected = "rdo_insulation";
		// var rdoPrevSel  = "";
		// var colInsulation = document.getElementById('col_insulation');
		// var colDrywall    = document.getElementById('col_drywall');
		// var colScrew      = document.getElementById('col_screw');
		// var colTape       = document.getElementById('col_tape');
		// var inputMtrlType = "";
		var jobId =  {!!json_encode($job_id)!!};
		var mtrlType = {!!json_encode($mtrl_type)!!};

		if (mtrlType == '' || mtrlType == 'INSULATION') {
			document.getElementById('rdo_insulation').checked = true;
		} else if (mtrlType == 'DRYWALL') {
			document.getElementById('rdo_drywall').checked = true;
		} else if (mtrlType == 'SCREW') {
			document.getElementById('rdo_screw').checked = true;
		} else if (mtrlType == 'TAPE') {
			document.getElementById('rdo_tape').checked = true;
		} else {
			document.getElementById('rdo_other').checked = true;
		}

		// colDrywall.style.visibility='hidden';
		// colScrew.style.visibility='hidden';
		// colTape.style.visibility='hidden';

        function RdoSelected(elmId) {
			// rdoPrevSel = rdoSelected;
			// rdoSelected = elmId;
			// fmPrevSel  = rdoPrevSel.replace("rdo_", "col_");
			fmSelected = elmId.replace("rdo_", "col_");

			if (fmSelected == 'col_insulation') {
				inputMtrlType = "INSULATION";
				// bgColor = "red";
			} else if (fmSelected == 'col_drywall') {
				// colDrywall.style.top = "-"+colInsulation.offsetHeight;
				inputMtrlType = "DRYWALL";
				// bgColor = "orange";
			} else if (fmSelected == 'col_screw') {
				// var unusedHeight = colInsulation.offsetHeight + colDrywall.offsetHeight;
				// colScrew.style.top = "-"+unusedHeight;
				inputMtrlType = "SCREW";
				// bgColor = "yellow";
			} else if (fmSelected == 'col_tape') {
				// var unusedHeight = colInsulation.offsetHeight + colDrywall.offsetHeight + colScrew.offsetHeight;
				// colTape.style.top = "-"+unusedHeight;
				inputMtrlType = "TAPE";
				// bgColor = "green";
			} else {
				inputMtrlType = "OTHER";
			}

			// document.getElementById(fmPrevSel).style.visibility='hidden';

			// document.getElementById('mtrl_notes').value = '????';
			// document.getElementById('mtrl_type').style.backgroundColor = bgColor;

			// document.getElementById(fmSelected).style.visibility='visible';
			// alert('Type = ' + document.getElementById('mtrl_type').value);
			if (jobId.length == 0)
				window.location = './material_add?mtrlType='+inputMtrlType;
			else
				window.location = './material_add?jobId='+jobId+'&mtrlType='+inputMtrlType;
        }
	</script>
			
@endsection
