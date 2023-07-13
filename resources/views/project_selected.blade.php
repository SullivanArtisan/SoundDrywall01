<?php
	use App\Models\Project;
	use App\Models\Customer;
	use App\Models\Status;
	use App\Models\Job;
?>

@extends('layouts.home_page_base')
<style>
.my-text-height {height:75%;}
</style>

@section('goback')
	<a class="text-primary" href="{{route('project_main')}}" style="margin-right: 10px;">Back</a>
@show

<?php
	$id = $_GET['id'];
    $customer_name = "";
    $job_add_ok = "";
    $job_update_ok = "";
    $job_delete_ok = "";
	if ($id) {
		$project = Project::where('id', $id)->first();
        $customer = Customer::where('id', $project->proj_cstmr_id)->first();
        $jobs = Job::where('job_proj_id', $id)->where('job_status', '<>', 'DELETED')->orderBy('created_at')->get();
        $customer_name = $customer->cstm_account_name;
        if (isset($_GET['JobAddOk'])) {
            $job_add_ok = $_GET['JobAddOk'];
        }
        if (isset($_GET['JobUpdateOk'])) {
            $job_update_ok = $_GET['JobUpdateOk'];
        }
        if (isset($_GET['JobDeleteOk'])) {
            $job_delete_ok = $_GET['JobDeleteOk'];
        }
	}
?>

@if (!$id or !$project) {
	@section('function_page')
		<div>
			<div class="row">
				<div class="col col-sm-auto">
					<h2 class="text-muted pl-2">Result of the Project</h2>
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
					<h2 class="text-muted pl-2">Project (for customer {{$customer->cstm_account_name}}):</h2>
				</div>
				<div class="col my-auto ml-5">
					<button class="btn btn-danger me-2" type="button"><a href="project_delete?id={{$project->id}}" onclick="return myConfirmation();">Delete</a></button>
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
			<div class="row m-4">
				<div class="col">
					<form method="post" action="{{url('project_update')}}">
						@csrf
                        <div class="row">
                            <div class="col"><label class="col-form-label">Customer Name:&nbsp;</label></div>
                            <div class="col">
                                <?php
                                $tagHead = "<input list=\"proj_cstmr_name\" name=\"proj_cstmr_name\" id=\"projcstmrnameinput\" class=\"form-control mt-1 my-text-height\" value=\"".$customer_name."\"";
                                $tagTail = "><datalist id=\"proj_cstmr_name\">";

                                $customers = Customer::all()->sortBy('cstm_account_name');
                                foreach($customers as $customer) {
                                    $tagTail.= "<option value=".str_replace(' ', '&nbsp;', $customer->cstm_account_name).">";
                                }
                                $tagTail.= "</datalist>";
                                // if (isset($_GET['selJobId'])) {
                                // 	echo $tagHead."placeholder=\"".$booking->bk_job_type."\" value=\"".$booking->bk_job_type."\"".$tagTail;
                                // } else {
                                    echo $tagHead."placeholder=\"\" value=\"\"".$tagTail;
                                // }
                                ?>
                            </div>
                            <div class="col"><label class="col-form-label">Total Jobs:&nbsp;</label></div>
                            <div class="col"><input class="form-control mt-1 my-text-height" type="number" readonly id="proj_total_active_jobs" name="proj_total_active_jobs" value="{{$project->proj_total_active_jobs}}"></div>
                        </div>
                        <div class="row">
                            <div class="col"><label class="col-form-label">Description:&nbsp;</label></div>
                            <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="proj_notes" name="proj_notes" value="{{$project->proj_notes}}"></div>
                            <div class="col"><label class="col-form-label">Status:&nbsp;</label></div>
                            <div class="col">
                                <?php
                                $tagHead = "<input list=\"proj_status\" name=\"proj_status\" id=\"projstatusinput\" class=\"form-control mt-1 my-text-height\" value=\"".$project->proj_status."\"";
                                $tagTail = "><datalist id=\"proj_status\">";

                                $statuses = Status::all();
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
                            <div class="col"><input class="form-control mt-1 my-text-height" type="hidden" id="id" name="id" value="{{$project->id}}"></div>
                            <div class="col"><label class="col-form-label">&nbsp;</label></div>
                            <div class="col"><input class="form-control mt-1 my-text-height" type="hidden" id="proj_my_creation_timestamp" name="proj_my_creation_timestamp" value="{{time()}}"></div>
                        </div>
						<div class="row my-3">
							<div class="w-25"></div>
							<div class="col-3 ml-4">
								<div class="row">
									<button class="btn btn-warning mx-4" type="submit">Update</button>
									<button class="btn btn-secondary mx-3" type="button"><a href="{{route('project_main')}}">Cancel</a></button>
								</div>
							</div>
							<div class="col"></div>
						</div>
					</form>
				</div>
			</div>
		</div>
        <div class="card">
            <div class="card-body" style="background: #BAD8D8;">
                <div class="row">
                    <div class="col-3">
                        <h4 class="card-title">Associated Jobs: </h4>
                    </div>
                    <div class="col-3 my-auto ml-5">
					    <button class="btn btn-success me-2" type="button"><a href="{{route('job_add', ['projId'=>$project->id])}}">Add a Job</a></button>
				    </div>
				</div>

                <?php
                // Jobs' Title Line
                $outContents = "<div class=\"container mw-100 mt-3\">";
                $outContents .= "<div class=\"row bg-info text-white fw-bold mb-2\">";
                    $outContents .= "<div class=\"col-1 mt-1 align-middle\">";
                        $outContents .= "Job Name";
                    $outContents .= "</div>";
                    $outContents .= "<div class=\"col-2 mt-1 align-middle\">";
                        $outContents .= "Job Type";
                    $outContents .= "</div>";
                    $outContents .= "<div class=\"col-1 mt-1 align-middle\">";
                        $outContents .= "Assistants#";
                    $outContents .= "</div>";
                    $outContents .= "<div class=\"col-2 mt-1 align-middle\">";
                        $outContents .= "Job Status";
                    $outContents .= "</div>";
                    $outContents .= "<div class=\"col-2 mt-1 align-middle\">";
                        $outContents .= "Job Address";
                    $outContents .= "</div>";
                    $outContents .= "<div class=\"col-2 mt-1 align-middle\">";
                        $outContents .= "Job City";
                    $outContents .= "</div>";
                    $outContents .= "<div class=\"col-2 align-middle\">";
                        $outContents .= "Province";
                    $outContents .= "</div>";
                $outContents .= "</div>";
                echo $outContents;

                // All Jobs' Body Lines
                $listed_jobs = 0;
                foreach ($jobs as $job) {
                    $listed_jobs++;
                    if ($listed_jobs % 2) {
                        $outContents = "<div class=\"row\" style=\"background-color:Lavender\">";
                    } else {
                        $outContents = "<div class=\"row\" style=\"background-color:PaleGreen\">";
                    }
                    $outContents .= "<div class=\"col-1\">";
                        $outContents .= "<a href=\"".route('job_selected', ['jobId='.$job->id])."\">";
                        $outContents .= $job->job_name;
                        $outContents .= "</a>";
                    $outContents .= "</div>";
                    $outContents .= "<div class=\"col-2\">";
                        $outContents .= "<a href=\"".route('job_selected', ['jobId='.$job->id])."\">";
                        $outContents .= $job->job_type;
                        $outContents .= "</a>";
                    $outContents .= "</div>";
                    $outContents .= "<div class=\"col-1\">";
                        $outContents .= "<a href=\"".route('job_selected', ['jobId='.$job->id])."\">";
                        $outContents .= $job->job_total_active_assistants;
                        $outContents .= "</a>";
                    $outContents .= "</div>";
                    $outContents .= "<div class=\"col-2\">";
                        $outContents .= "<a href=\"".route('job_selected', ['jobId='.$job->id])."\">";
                        $outContents .= $job->job_status;
                        $outContents .= "</a>";
                    $outContents .= "</div>";
                    $outContents .= "<div class=\"col-2\">";
                        $outContents .= "<a href=\"".route('job_selected', ['jobId='.$job->id])."\">";
                        $outContents .= $job->job_address;
                        $outContents .= "</a>";
                    $outContents .= "</div>";
                    $outContents .= "<div class=\"col-2\">";
                        $outContents .= "<a href=\"".route('job_selected', ['jobId='.$job->id])."\">";
                        $outContents .= $job->job_city;
                        $outContents .= "</a>";
                    $outContents .= "</div>";
                    $outContents .= "<div class=\"col-2\">";
                        $outContents .= "<a href=\"".route('job_selected', ['jobId='.$job->id])."\">";
                        $outContents .= $job->job_province;
                        $outContents .= "</a>";
                    $outContents .= "</div>";
                $outContents .= "</div>";
                echo $outContents;
                }
                ?>
            </div>
        </div>
		
		<script>
            var jobAddOk = {!!json_encode($job_add_ok)!!};
            var jobUpdateOk = {!!json_encode($job_update_ok)!!};
            var jobDeleteOk = {!!json_encode($job_delete_ok)!!};
            if (jobAddOk.length > 0) {
                alert("Job "+jobAddOk+" is associated successfully.");
            }
            if (jobUpdateOk.length > 0) {
                alert("Job "+jobUpdateOk+" is updated successfully.");
            }
            if (jobDeleteOk.length > 0) {
                alert("Job "+jobDeleteOk+" is deleted successfully.");
            }

			function myConfirmation() {
				if(!confirm("Are you sure to delete this project?"))
				    event.preventDefault();
			}
		</script>
	@endsection
}
@endif

