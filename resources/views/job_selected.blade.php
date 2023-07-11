<?php
	use App\Models\Project;
	use App\Models\Customer;
	use App\Models\Status;
	use App\Models\JobType;
	use App\Models\Job;

    $job_id = $_GET['jobId'];
	if ($job_id) {
        $job = Job::where('id', $job_id)->first();
	}
?>

@extends('layouts.home_page_base')
<style>
.my-text-height {height:75%;}
</style>

@section('goback')
	<a class="text-primary" href="{{route('project_selected', ['id'=>$job->job_proj_id])}}" style="margin-right: 10px;">Back</a>
@show

@if (!$job_id) {
	@section('function_page')
		<div>
			<div class="row">
				<div class="col col-sm-auto">
					<h2 class="text-muted pl-2">Result of the Job</h2>
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
					<h2 class="text-muted pl-2">Job {{$job->job_name}}:</h2>
				</div>
				<div class="col my-auto ml-5">
					<button class="btn btn-danger me-2" type="button"><a href="job_delete?id={{$job->id}}" onclick="return myConfirmation();">Delete</a></button>
				</div>
				<div class="col"></div>
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
                <div class="row m-4">
                    <div class="col">
                        <form method="post" action="{{url('job_update')}}">
                            @csrf
                            <div class="row">
                                <div class="col"><label class="col-form-label">Project Id:&nbsp;</label></div>
                                <div class="col"><input class="form-control mt-1 my-text-height" type="number" readonly id="job_proj_id" name="job_proj_id" value="{{$job->job_proj_id}}"></div>
                                <div class="col"><label class="col-form-label">Job Name:&nbsp;</label></div>
                                <div class="col"><input class="form-control mt-1 my-text-height" type="text" readonly id="job_name" name="job_name" value="{{$job->job_name}}"></div>
                            </div>
                            <div class="row">
                                <div class="col"><label class="col-form-label">Job Type:&nbsp;</label></div>
                                <div class="col">
                                    <?php
                                    $tagHead = "<input list=\"job_type\" name=\"job_type\" id=\"jobtypeinput\" class=\"form-control mt-1 my-text-height\" value=\"".$job->job_type."\"";
                                    $tagTail = "><datalist id=\"job_type\">";

                                    $types = JobType::all()->sortBy('job_type');
                                    foreach($types as $type) {
                                        $tagTail.= "<option value=".str_replace(' ', '&nbsp;', $type->job_type).">";
                                    }
                                    $tagTail.= "</datalist>";
                                    // if (isset($_GET['selJobId'])) {
                                    // 	echo $tagHead."placeholder=\"".$booking->bk_job_type."\" value=\"".$booking->bk_job_type."\"".$tagTail;
                                    // } else {
                                        echo $tagHead."placeholder=\"\" value=\"\"".$tagTail;
                                    // }
                                    ?>
                                </div>
                                <div class="col"><label class="col-form-label">Job Address:&nbsp;</label></div>
                                <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="job_address" name="job_address" value="{{$job->job_address}}"></div>
                            </div>
                            <div class="row">
                                <div class="col"><label class="col-form-label">Job City:&nbsp;</label></div>
                                <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="job_city" name="job_city" value="{{$job->job_city}}"></div>
                                <div class="col"><label class="col-form-label">Job Province:&nbsp;</label></div>
                                <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="job_province" name="job_province" value="{{$job->job_province}}"></div>
                            </div>
                            <div class="row">
                                <div class="col"><label class="col-form-label">Job Description:&nbsp;</label></div>
                                <div class="col"><textarea class="form-control mt-1 my-text-height" rows = "5" id="job_desc" name="job_desc" placeholder="{{$job->job_desc}}">{{$job->job_desc}}</textarea></div>
                                <div class="col"><label class="col-form-label">Job Status:&nbsp;</label></div>
                                <div class="col">
                                    <?php
                                    $tagHead = "<input list=\"job_status\" name=\"job_status\" id=\"jobstatusinput\" class=\"form-control mt-1\" value=\"".$job->job_status."\"";
                                    $tagTail = "><datalist id=\"job_status\">";

                                    $statuses = Status::all()->sortBy('status_name');
                                    foreach($statuses as $status) {
                                        $tagTail.= "<option value=".str_replace(' ', '&nbsp;', $status->status_name).">";
                                    }
                                    $tagTail.= "</datalist>";
                                    // if (isset($_GET['selJobId'])) {
                                    // 	echo $tagHead."placeholder=\"".$booking->bk_job_type."\" value=\"".$booking->bk_job_type."\"".$tagTail;
                                    // } else {
                                        echo $tagHead."placeholder=\"\" value=\"\"".$tagTail;
                                    // }
                                    ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col"><label class="col-form-label">&nbsp;</label></div>
                                <div class="col"><input class="form-control mt-1 my-text-height" type="hidden" readonly id="job_id" name="job_id" value="{{$job->id}}"></div>
                            </div>
                            <div class="row my-3">
                                <div class="w-25"></div>
                                <div class="col">
                                    <div class="row">
                                        <button class="btn btn-success mx-4" type="submit" id="btn_save">Save</button>
                                        <button class="btn btn-info mx-3 mr-2" type="button" onclick="DoJobCombination();">Job Combination</button>
                                        <button class="btn btn-secondary mx-3 ml-2" type="button"><a href="{{route('project_selected', ['id'=>$job->job_proj_id])}}">Cancel</a></button>
                                    </div>
                                </div>
                                <div class="col"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
		</div>
		
		<script>
			function myConfirmation() {
				if(!confirm("Are you sure to delete this job?"))
				    event.preventDefault();
			}

            function DoJobCombination() {
                event.preventDefault();
                url   = './job_combination_main?jobId='+{!!json_encode($job_id)!!};
                window.location = url;
            }
		</script>
	@endsection
}
@endif

