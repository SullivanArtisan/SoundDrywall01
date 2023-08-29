<?php
	use App\Models\Job;
	use App\Models\Material;
?>

@extends('layouts.home_page_base')
<style>
.my-text-height {height:75%;}
</style>

@section('goback')
	<a class="text-primary" href="{{route('drywall_main')}}" style="margin-right: 10px;">Back</a>
@show

<?php
	$id = $_GET['id'];
	if ($id) {
		$material = Material::where('id', $id)->first();
	}
?>

@if (!$id or !$material) {
	@section('function_page')
		<div>
			<div class="row">
				<div class="col col-sm-auto">
					<h2 class="text-muted pl-2">Result of the Drywall Operation</h2>
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
					<h2 class="text-muted pl-2">Drywall: {{$material->mtrl_name}}</h2>
				</div>
				<div class="col my-auto ml-5">
					<button class="btn btn-danger me-2" type="button"><a href="drywall_delete?id={{$material->id}}" onclick="return myConfirmation();">Delete</a></button>
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
					<form method="post" action="{{url('drywall_update')}}">
						@csrf
						<div class="row">
							<div class="col"><label class="col-form-label">Material Name:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="mtrl_name" name="mtrl_name" value="{{$material->mtrl_name}}"></div>
							<div class="col"><label class="col-form-label">Used for Job:&nbsp;</label></div>
							<div class="col">
								<?php
								$tagHead = "<input list=\"job_name\" name=\"job_name\" id=\"jobnameinput\" class=\"form-control mt-1 my-text-height\" ";
								$tagTail = "><datalist id=\"job_name\">";

								$selJob = Job::where('id', $material->mtrl_job_id)->first();
								$jobs = Job::all()->where('job_status', '<>', 'DELETED')->where('job_status', '<>', 'CANCELED')->where('job_status', '<>', 'COMPLETED')->sortBy('job_name');
								foreach($jobs as $job) {
									$tagTail.= "<option value=".str_replace(' ', '&nbsp;', $job->job_name).">";
								}
								$tagTail.= "</datalist>";
								// if (isset($_GET['selJobId'])) {
								// 	echo $tagHead."placeholder=\"".$booking->bk_job_type."\" value=\"".$booking->bk_job_type."\"".$tagTail;
								// } else {
									echo $tagHead."placeholder=\"\" value=\"".$selJob->job_name."\"".$tagTail;
								// }
								?>
							</div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">Size:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="mtrl_size" name="mtrl_size" value="{{$material->mtrl_size}}"></div>
							<div class="col"><label class="col-form-label">Size Unit:&nbsp;</label></div>
							<div class="col">
								<?php
								$tagHead = "<input list=\"mtrl_size_unit\" name=\"mtrl_size_unit\" id=\"mtrlsizeunitinput\" class=\"form-control mt-1 my-text-height\" ";
								$tagTail = "><datalist id=\"mtrl_size_unit\">";

								$tagTail.= "<option value=\"ft\">";
								$tagTail.= "<option value=\"cm\">";
								$tagTail.= "</datalist>";
								// if (isset($_GET['selJobId'])) {
								// 	echo $tagHead."placeholder=\"".$booking->bk_job_type."\" value=\"".$booking->bk_job_type."\"".$tagTail;
								// } else {
									echo $tagHead."placeholder=\"\" value=\"".$material->mtrl_size_unit."\"".$tagTail;
								// }
								?>
							</div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">Provider:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="mtrl_source" name="mtrl_source" value="{{$material->mtrl_source}}"></div>
							<div class="col"><label class="col-form-label">Shipped by:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="mtrl_shipped_by" name="mtrl_shipped_by" value="{{$material->mtrl_shipped_by}}"></div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">Amount:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="number" step="0.01" id="mtrl_amount" name="mtrl_amount" value="{{$material->mtrl_amount}}"></div>
							<div class="col"><label class="col-form-label">Amount Unit:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="text" id="mtrl_amount_unit" name="mtrl_amount_unit" value="{{$material->mtrl_amount_unit}}"></div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">Amount Left:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" readonly type="number" step="0.01" id="mtrl_amount_left" name="mtrl_amount_left" value="{{$material->mtrl_amount_left}}"></div>
							<div class="col"><label class="col-form-label">Price:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="number" step="0.01" id="mtrl_price" name="mtrl_price" value="{{$material->mtrl_price}}"></div>
						</div>
						<div class="row">
							<div class="col"><label class="col-form-label">Material ID:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="hidden" id="mtrl_id" name="mtrl_id" value="{{$material->id}}"></div>
							<div class="col"><label class="col-form-label">Material Type:&nbsp;</label></div>
							<div class="col"><input class="form-control mt-1 my-text-height" type="hidden" id="mtrl_type" name="mtrl_type" value="DRYWALL SHEET"></div>
						</div>
						<div class="row my-3">
							<div class="w-25"></div>
							<div class="col">
								<div class="row">
									<button class="btn btn-warning mx-4" type="submit">Update</button>
									<button class="btn btn-secondary mx-3" type="button"><a href="{{route('drywall_main')}}">Cancel</a></button>
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
				if(!confirm("Continue to delete this material?"))
				event.preventDefault();
			}
		</script>
	@endsection
}
@endif

