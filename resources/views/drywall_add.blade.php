<?php
	use App\Models\Job;
	use App\Models\Material;
	use Illuminate\Support\Facades\Session;
?>

@extends('layouts.home_page_base')
<style>
.my-text-height {height:75%;}
</style>

@section('goback')
	<a class="text-primary" href="{{route('drywall_main')}}" style="margin-right: 10px;">Back</a>
@show

@section('function_page')
	<?php
		$picPath = Session::get('uploadPath');
		Session::forget(['uploadPath']);
	?>
	<div>
		<h2 class="text-muted pl-2 mb-2">Add New Drywalls</h2>
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
                <form method="post" action="{{route('op_result.drywall_add')}}">
					@csrf
                    <div class="row">
                        <div class="col"><label class="col-form-label">Material Name:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="mtrl_name" name="mtrl_name"></div>
                        <div class="col"><label class="col-form-label">Used for Job:&nbsp;</label></div>
						<div class="col">
							<?php
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
							?>
						</div>
                    </div>
                    <div class="row">
						<div class="col"><label class="col-form-label">Size:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="mtrl_size" name="mtrl_size"></div>
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
								echo $tagHead."placeholder=\"\" value=\"ft\"".$tagTail;
							// }
							?>
						</div>
                    </div>
                    <div class="row">
						<div class="col"><label class="col-form-label">Provider:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="mtrl_source" name="mtrl_source"></div>
						<div class="col"><label class="col-form-label">Shipped by:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="mtrl_shipped_by" name="mtrl_shipped_by"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Amount:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="number" step="0.01" id="mtrl_amount" name="mtrl_amount"></div>
                        <div class="col"><label class="col-form-label">Amount Unit:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="mtrl_amount_unit" name="mtrl_amount_unit"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Unit Price:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="number" step="0.01" id="mtrl_unit_price" name="mtrl_unit_price"></div>
                        <div class="col"><label class="col-form-label">Total Price:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="number" step="0.01" id="mtrl_total_price" name="mtrl_total_price"></div>
                    </div>
                    <div class="row">
						<div class="col"><label class="col-form-label">Amount Left:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" readonly type="number" step="0.01" id="mtrl_amount_left" name="mtrl_amount_left"></div>
						<div class="col"><label class="col-form-label">&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="hidden"></div>
                    </div>
                    <div class="row my-3">
                        <div class="w-25"></div>
                        <div class="col">
							<div class="row">
								<button class="btn btn-success mx-4" type="submit">Save</button>
								<button class="btn btn-secondary mx-3" type="button"><a href="{{route('drywall_main')}}">Cancel</a></button>
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
        function myConfirmation() {
        }
	</script>
			
@endsection
