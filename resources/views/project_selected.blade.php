<?php
	use App\Models\JobDispatch;
	use App\Models\Project;
	use App\Models\Client;
	use App\Models\Status;
	use App\Models\Job;
?>

@extends('layouts.home_page_base')
<style>
.my-text-height {height:75%;}
</style>

@section('goback')
	<a class="text-primary" href="{{route('project_main', ['display_filter'=>'active'])}}" style="margin-right: 10px;">Back</a>
@show

<?php
	$id = $_GET['id'];
    $client_name = "";
    $job_add_ok = "";
    $job_update_ok = "";
    $job_delete_ok = "";
	if ($id) {
		$project = Project::where('id', $id)->first();
        $client = Client::where('id', $project->proj_cstmr_id)->first();
        $jobs = Job::where('job_proj_id', $id)->where('job_status', '<>', 'DELETED')->where('job_status', '<>', 'CANCELED')->where('job_status', '<>', 'COMPLETED')->orderBy('created_at')->get();
        $client_name = $client->clnt_name;
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
					<h2 class="text-muted pl-2">Project {{$id}}:</h2>
				</div>
				<div class="col my-auto ml-5">
                    @if (Auth::user()->role == 'ADMINISTRATOR')
					<button class="btn btn-danger me-2" type="button"><a href="project_delete?id={{$project->id}}" onclick="return myConfirmation();">Delete</a></button>
                    @endif
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
                            <div class="col"><label class="col-form-label">Client Name:&nbsp;</label><span class="text-danger">*</span></div>
                            <div class="col">
                                <?php
                                $tagHead = "<input list=\"proj_cstmr_name\" name=\"proj_cstmr_name\" id=\"projcstmrnameinput\" onfocus=\"this.value='';\" onblur=\"if (this.value=='') this.value='".$client_name."';\" class=\"form-control mt-1 my-text-height\" value=\"".$client_name."\"";
                                $tagTail = "><datalist id=\"proj_cstmr_name\">";

                                $clients = Client::all()->sortBy('clnt_name');
                                foreach($clients as $client) {
                                    $tagTail.= "<option value=".str_replace(' ', '&nbsp;', $client->clnt_name).">";
                                }
                                $tagTail.= "</datalist>";
                                // if (isset($_GET['selJobId'])) {
                                // 	echo $tagHead."placeholder=\"".$booking->bk_job_type."\" value=\"".$booking->bk_job_type."\"".$tagTail;
                                // } else {
                                    echo $tagHead."placeholder=\"\" value=\"\"".$tagTail;
                                // }
                                ?>
                            </div>
                            <div class="col"><label class="col-form-label">Total Tasks:&nbsp;</label></div>
                            <div class="col"><input class="form-control mt-1 my-text-height" type="number" readonly id="proj_total_active_jobs" name="proj_total_active_jobs" value="{{$project->proj_total_active_jobs}}"></div>
                        </div>
                        <div class="row">
                            <div class="col"><label class="col-form-label">Task Address:&nbsp;</label><span class="text-danger">*</span></div>
                            <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="proj_address" name="proj_address" value="{{$project->proj_address}}"></div>
                            <div class="col"><label class="col-form-label">Task City:&nbsp;</label><span class="text-danger">*</span></div>
                            <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="proj_city" name="proj_city" value="{{$project->proj_city}}"></div>
                        </div>
                        <div class="row">
                            <div class="col"><label class="col-form-label">Task Province:&nbsp;</label></div>
                            <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="proj_province" name="proj_province" value="{{$project->proj_province}}"></div>
                            <div class="col"><label class="col-form-label">Task Postcode:&nbsp;</label></div>
                            <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="proj_postcode" name="proj_postcode" value="{{$project->proj_postcode}}"></div>
                        </div>
                        <div class="row">
                            <div class="col"><label class="col-form-label">Description:&nbsp;</label></div>
                            <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="proj_notes" name="proj_notes" value="{{$project->proj_notes}}"></div>
                            <div class="col"><label class="col-form-label">Status:&nbsp;</label></div>
                            <div class="col">
                                <?php
                                $tagHead = "<input list=\"proj_status\" name=\"proj_status\" id=\"projstatusinput\" onfocus=\"this.value='';\" onblur=\"if (this.value=='') this.value='".$project->proj_status."';\" class=\"form-control mt-1 my-text-height\" value=\"".$project->proj_status."\"";
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
							<div class="col"></div>
							<div class="col">
                                @if (Auth::user()->role == 'ADMINISTRATOR')
                                <button class="btn btn-warning mx-3" type="submit">Update</button>
                                @endif
                                <button class="btn btn-secondary mx-3" type="button"><a href="{{route('project_main', ['display_filter'=>'active'])}}">Cancel</a></button>
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
                        <h4 class="card-title">Dispatched Tasks: </h4>
                    </div>
				</div>

                <?php
                // Tasks' Title Line
                $outContents = "<div class=\"container mw-100 mt-3\">";
                $outContents .= "<div class=\"row bg-info text-white fw-bold mb-2\">";
                    $outContents .= "<div class=\"col-2 mt-1 align-middle\">";
                        $outContents .= "Task Name";
                    $outContents .= "</div>";
                    $outContents .= "<div class=\"col-2 mt-1 align-middle\">";
                        $outContents .= "Task Type";
                    $outContents .= "</div>";
                    $outContents .= "<div class=\"col-2 mt-1 align-middle\">";
                        $outContents .= "Crew#";
                    $outContents .= "</div>";
                    $outContents .= "<div class=\"col-2 mt-1 align-middle\">";
                        $outContents .= "Materail#";
                    $outContents .= "</div>";
                    $outContents .= "<div class=\"col-2 mt-1 align-middle\">";
                        $outContents .= "Task Status";
                    $outContents .= "</div>";
                    $outContents .= "<div class=\"col-2 mt-1 align-middle\">";
                        $outContents .= "Description";
                    $outContents .= "</div>";
                    // $outContents .= "<div class=\"col-2 mt-1 align-middle\">";
                    //     $outContents .= "Task Address";
                    // $outContents .= "</div>";
                    // $outContents .= "<div class=\"col-1 mt-1 align-middle\">";
                    //     $outContents .= "Task City";
                    // $outContents .= "</div>";
                    // $outContents .= "<div class=\"col-2 align-middle\">";
                    //     $outContents .= "Province";
                    // $outContents .= "</div>";
                $outContents .= "</div>";
                echo $outContents;

                // All Tasks' Body Lines
                $listed_jobs = 0;
                foreach ($jobs as $job) {
                    if (Auth::user()->role != 'ADMINISTRATOR') {
                        $association = JobDispatch::where('jobdsp_job_id', $job->id)->where('jobdsp_staff_id', Auth::user()->id)->where('jobdsp_status', '<>', 'DELETED')->where('jobdsp_status', '<>', 'CANCELED')->first();
                        if (!$association) {
                            continue;
                        }
                    }
        
                    $listed_jobs++;
                    if ($listed_jobs % 2) {
                        $outContents = "<div class=\"row\" style=\"background-color:Lavender\">";
                    } else {
                        $outContents = "<div class=\"row\" style=\"background-color:PaleGreen\">";
                    }
                    $outContents .= "<div class=\"col-2\">";
                        $outContents .= "<a href=\"".route('job_selected', ['jobIdFromProj='.$job->id])."\">";
                        $outContents .= $job->job_name;
                        $outContents .= "</a>";
                    $outContents .= "</div>";
                    $outContents .= "<div class=\"col-2\">";
                        $outContents .= "<a href=\"".route('job_selected', ['jobIdFromProj='.$job->id])."\">";
                        $outContents .= $job->job_type;
                        $outContents .= "</a>";
                    $outContents .= "</div>";
                    $outContents .= "<div class=\"col-2\">";
                        $outContents .= "<a href=\"".route('job_selected', ['jobIdFromProj='.$job->id])."\">";
                        $outContents .= $job->job_total_active_assistants;
                        $outContents .= "</a>";
                    $outContents .= "</div>";
                    $outContents .= "<div class=\"col-2\">";
                        $outContents .= "<a href=\"".route('job_selected', ['jobIdFromProj='.$job->id])."\">";
                        $outContents .= $job->job_total_active_materials;
                        $outContents .= "</a>";
                    $outContents .= "</div>";
                    $outContents .= "<div class=\"col-2\">";
                        $outContents .= "<a href=\"".route('job_selected', ['jobIdFromProj='.$job->id])."\">";
                        $outContents .= $job->job_status;
                        $outContents .= "</a>";
                    $outContents .= "</div>";
                    $outContents .= "<div class=\"col-2\">";
                        $outContents .= "<a href=\"".route('job_selected', ['jobIdFromProj='.$job->id])."\">";
                        $outContents .= $job->job_desc;
                        $outContents .= "</a>";
                    $outContents .= "</div>";
                    // $outContents .= "<div class=\"col-2\">";
                    //     $outContents .= "<a href=\"".route('job_selected', ['jobIdFromProj='.$job->id])."\">";
                    //     $outContents .= $job->job_address;
                    //     $outContents .= "</a>";
                    // $outContents .= "</div>";
                    // $outContents .= "<div class=\"col-1\">";
                    //     $outContents .= "<a href=\"".route('job_selected', ['jobIdFromProj='.$job->id])."\">";
                    //     $outContents .= $job->job_city;
                    //     $outContents .= "</a>";
                    // $outContents .= "</div>";
                    // $outContents .= "<div class=\"col-2\">";
                    //     $outContents .= "<a href=\"".route('job_selected', ['jobIdFromProj='.$job->id])."\">";
                    //     $outContents .= $job->job_province;
                    //     $outContents .= "</a>";
                    // $outContents .= "</div>";
                $outContents .= "</div>";
                echo $outContents;
                }
                ?>
                <div class="row mt-5 d-flex justify-content-center">
                    <div class="col-3 my-4 ml-5">
					    <button class="btn btn-success me-2" type="button"><a href="{{route('job_add', ['projId'=>$project->id])}}">Add a Task</a></button>
				    </div>
				</div>
            </div>
        </div>
		
		<script>
            var jobAddOk = {!!json_encode($job_add_ok)!!};
            var jobUpdateOk = {!!json_encode($job_update_ok)!!};
            var jobDeleteOk = {!!json_encode($job_delete_ok)!!};
            if (jobAddOk.length > 0) {
                alert("Task "+jobAddOk+" is didpatched successfully.");
            }
            if (jobUpdateOk.length > 0) {
                alert("Task "+jobUpdateOk+" is updated successfully.");
            }
            if (jobDeleteOk.length > 0) {
                alert("Task "+jobDeleteOk+" is deleted successfully.");
            }

			function myConfirmation() {
				if(!confirm("Are you sure to delete this project?"))
				    event.preventDefault();
			}
		</script>
	@endsection
}
@endif

