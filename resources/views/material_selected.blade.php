<?php
	use App\Models\Job;
	use App\Models\Material;
	use App\Models\MaterialType;
	use App\Models\SizeUnit;
	use App\Models\AmountUnit;
	use App\Models\Provider;
?>

@extends('layouts.home_page_base')
<style>
.my-text-height {height:75%;}
</style>

@section('goback')
	<a class="text-primary" href="{{route('material_main', ['display_filter'=>'active'])}}" style="margin-right: 10px;">Back</a>
@show

<?php
	$id = $_GET['id'];
	$material_status = '';
	$mtrl_job_id = "";
	if ($id) {
		$material = Material::where('id', $id)->first();
		
		if ($material) {
			$material_status = $material->mtrl_status;
		} else {
			Log::Info(Auth::user()->id.' failed to access Material '.$id.'\'s object while entering material_selected page.');
		}
	}
?>

@if (!$id or !$material) {
	@section('function_page')
		<div>
			<div class="row">
				<div class="col col-sm-auto">
					<h2 class="text-muted pl-2">Result of the Material Operation</h2>
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
					<h2 class="text-muted pl-2">Material: {{$material->mtrl_name}}</h2>
				</div>
				<div class="col my-auto ml-5">
					<button class="btn btn-danger me-2" type="button"><a href="material_delete?id={{$material->id}}" onclick="return myConfirmation();">Delete</a></button>
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
					<form method="post" action="{{url('material_update')}}">
						@csrf
						<div class="row">
							<div class="col"><label class="col-form-label">Name:&nbsp;</label><span class="text-danger">*</span></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="mtrl_name" name="mtrl_name" value="{{$material->mtrl_name}}"></div>
							<div class="col"><label class="col-form-label">Type:&nbsp;</label><span class="text-danger">*</span></div>
							<div class="col">
								<?php
									$types = MaterialType::all()->sortBy('mtrl_type');
									$tagHead = "<input list=\"mtrl_type\" name=\"mtrl_type\" id=\"mtrltypeinput\" onfocus=\"this.value='';\" onblur=\"if (this.value=='') this.value='".$material->mtrl_type."';\" class=\"form-control mt-1 my-text-height\" ";
									$tagTail = "><datalist id=\"mtrl_type\">";
									foreach($types as $type) {
										$tagTail.= "<option value=".str_replace(' ', '&nbsp;', $type->mtrl_type).">";
									}
									$tagTail.= "</datalist>";
									echo $tagHead."placeholder=\"\" value=\"".$material->mtrl_type."\"".$tagTail;
								?>
							</div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">Model:&nbsp;</label><span class="text-danger">*</span></div>
							<div class="col"><input class="form-control mt-1 my-text-height" id="mtrl_model" name="mtrl_model" value="{{$material->mtrl_model}}"></div>
							<div class="col"><label class="col-form-label">Used for Task:&nbsp;</label></div>
							<div class="col">
								<?php
								$selJob = Job::where('id', $material->mtrl_job_id)->first();
								$jobs = Job::all()->where('job_status', '<>', 'DELETED')->where('job_status', '<>', 'CANCELED')->where('job_status', '<>', 'COMPLETED')->sortBy('job_name');
								
								// $tagHead = "<input list=\"job_name\" name=\"job_name\" id=\"jobnameinput\" onfocus=\"this.value='';\" class=\"form-control mt-1 my-text-height\" ";
								$tagHead = "<input list=\"job_name\" name=\"job_name\" id=\"jobnameinput\" ondblclick=\"GoToThatJob()\" readonly class=\"form-control mt-1 my-text-height\" ";
								$tagTail = "><datalist id=\"job_name\">";
								foreach($jobs as $job) {
									$tagTail.= "<option value=".str_replace(' ', '&nbsp;', $job->job_name).">";
								}
								$tagTail.= "</datalist>";
								if ($selJob) {
									$mtrl_job_id = $selJob->id;
									echo $tagHead."placeholder=\"\" value=\"".$selJob->job_name."\"".$tagTail;
								} else {
									echo $tagHead."placeholder=\"\" value=\"\"".$tagTail;
								}
								?>
							</div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">Item Size:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="mtrl_size" name="mtrl_size" value="{{$material->mtrl_size}}"></div>
							<div class="col"><label class="col-form-label">Size Unit:&nbsp;</label></div>
							<div class="col">
								<?php
									$tagHead = "<input list=\"mtrl_size_unit\" name=\"mtrl_size_unit\" id=\"mtrlsizeunitinput\" onfocus=\"this.value='';\" onblur=\"if (this.value=='') this.value='".$material->mtrl_size_unit."';\" class=\"form-control mt-1 my-text-height\" ";
									$tagTail = "><datalist id=\"mtrl_size_unit\">";

			
									$units = SizeUnit::all()->sortBy('unit_name');
									foreach($units as $unit) {
										$tagTail.= "<option value=".str_replace(' ', '&nbsp;', $unit->unit_name).">";
									}
									$tagTail.= "</datalist>";
									echo $tagHead."placeholder=\"\" value=\"".$material->mtrl_size_unit."\"".$tagTail;
								?>
							</div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">Total Amount:&nbsp;</label><span class="text-danger">*</span></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="number" id="mtrl_amount" name="mtrl_amount" value="{{$material->mtrl_amount}}"></div>
							<div class="col"><label class="col-form-label">Amount Unit:&nbsp;</label></div>
							<div class="col">
								<?php
									$tagHead = "<input list=\"mtrl_amount_unit\" name=\"mtrl_amount_unit\" id=\"mtrlsizeunitinput\" onfocus=\"this.value='';\" onblur=\"if (this.value=='') this.value='".$material->mtrl_amount_unit."';\" class=\"form-control mt-1 my-text-height\" ";
									$tagTail = "><datalist id=\"mtrl_amount_unit\">";

			
									$units = AmountUnit::all()->sortBy('amount_unit_name');
									foreach($units as $unit) {
										$tagTail.= "<option value=".str_replace(' ', '&nbsp;', $unit->amount_unit_name).">";
									}
									$tagTail.= "</datalist>";
									echo $tagHead."placeholder=\"\" value=\"".$material->mtrl_amount_unit."\"".$tagTail;
								?>
							</div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">Provider:&nbsp;</label></div>
							<div class="col">
								<?php
									$tagHead = "<input list=\"mtrl_source\" name=\"mtrl_source\" id=\"mtrlsourceinput\" onfocus=\"this.value='';\" onblur=\"if (this.value=='') this.value='".$material->mtrl_source."';\" class=\"form-control mt-1 my-text-height\" ";
									$tagTail = "><datalist id=\"mtrl_source\">";

			
									$providers = Provider::all()->sortBy('pvdr_name');
									foreach($providers as $provider) {
										$tagTail.= "<option value=".str_replace(' ', '&nbsp;', $provider->pvdr_name.' ('.$provider->pvdr_address.', '.$provider->pvdr_city.')').">";
									}
									$tagTail.= "</datalist>";
									echo $tagHead."placeholder=\"\" value=\"".$material->mtrl_source."\"".$tagTail;
								?>
							</div>
							<div class="col"><label class="col-form-label">Shipped by:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="mtrl_shipped_by" name="mtrl_shipped_by" value="{{$material->mtrl_shipped_by}}"></div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">Unit Price:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="number" step="0.01" id="mtrl_price" name="mtrl_price" value="{{$material->mtrl_price}}"></div>
							<div class="col"><label class="col-form-label">Total Price:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="number" step="0.01" id="mtrl_total_price" name="mtrl_total_price" value="{{$material->mtrl_total_price}}"></div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">Amount Left:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" readonly type="number" id="mtrl_amount_left" name="mtrl_amount_left" value="{{$material->mtrl_amount_left}}"></div>
							<div class="col"><label class="col-form-label">Notes:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="mtrl_notes" name="mtrl_notes" value="{{$material->mtrl_notes}}"></div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="hidden" id="mtrl_id" name="mtrl_id" value="{{$material->id}}"></div>
						</div>
						<div class="row my-3">
							<div class="w-25"></div>
							<div class="col">
								<div class="row">
									<button class="btn btn-warning mx-4" type="submit" onclick="CheckMtrlStatusFirst('{{$material->mtrl_status}}')">Update</button>
									<button class="btn btn-secondary mx-3" type="button"><a href="{{route('material_main', ['display_filter'=>'active'])}}">Cancel</a></button>
								</div>
							</div>
							<div class="col"></div>
						</div>
					</form>
				</div>
			</div>
		</div>
		
		<script>
			function myConfirmation() {
				let mtrlStatus = {!!json_encode($material_status)!!};

				if (mtrlStatus == 'DISPATCHED' || mtrlStatus == 'COMPLETED') {
					alert('This material has been dispatched, so you cannot delete it now.');
					event.preventDefault();
				} else {
					if(!confirm("Continue to delete this material?"))
					event.preventDefault();
				}
			}

			function CheckMtrlStatusFirst(mtrlStatus) {
				if(mtrlStatus.includes('COMPLETED')) {
					alert('You cannot update this material, as the dispatched task has been COMPLETED.');
					event.preventDefault();
				}
			}

			function GoToThatJob() {
				let jobId = {!!json_encode($mtrl_job_id)!!};
				let mtrlId = {!!json_encode($id)!!};

				if (jobId != '') {
					window.location = './job_selected?jobId='+jobId+'&jobFromMtrlId='+mtrlId;
				}
			}
		</script>
	@endsection
}
@endif

