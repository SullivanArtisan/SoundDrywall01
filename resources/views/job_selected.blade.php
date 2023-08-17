<?php
	use App\Models\Project;
	use App\Models\Client;
	use App\Models\Status;
	use App\Models\Staff;
	use App\Models\Job;
	use App\Models\JobType;
	use App\Models\JobDispatch;

    $job_id = "";
    $staff_id = Auth::user()->id;
    $association_staff_id = "";
    $msg_to_show = "";
    if (isset($_GET['jobId'])) {
        $job_id = $_GET['jobId'];
    }

    if (isset($_GET['jobIdFromProj'])) {
        $job_id = $_GET['jobIdFromProj'];
    }

	if ($job_id) {
        $job = Job::where('id', $job_id)->first();
        $project = Project::where('id', $job->job_proj_id)->first();
        if (!$project) {
            Log::Info('Staff '.Auth::user()->id.' failed to access the project object while updating a task to the project '.$job->job_proj_id);
        }
        $client = Client::where('id', $project->proj_cstmr_id)->first();
        if (!$client) {
            Log::Info('Staff '.Auth::user()->id.' failed to access the client object while updating a task to the project '.$job->job_proj_id);
        }

        $associations = JobDispatch::where('jobdsp_job_id', $job_id)->where('jobdsp_status', '<>', 'DELETED')->where('jobdsp_status', '<>', 'CANCELED')->get();
        foreach($associations as $association) {
            $staff = Staff::where('id', $association->jobdsp_staff_id)->first();
            if ($staff) {
                if ($staff->role == 'SUPERINTENDENT') {
                    $association_staff_id = $staff->id;
                    break;
                }
            }
        }
	} else {
        Log::Info('Failed to get jobId');
    }

    if (isset($_GET['msgToStaffOK'])) {
        $result = $_GET['msgToStaffOK'];
        if ($result=='true' && $staff_id) {
            $msg_to_show = 'Message sent to the task\'s superintendent successfully.';
            Log::Info($msg_to_show);
        }
    }

    if (isset($_GET['msgToAdminOK'])) {
        $result = $_GET['msgToAdminOK'];
        if ($result == 'true'){
            $msg_to_show = 'Assistant '.Auth::user()->f_name.' '.Auth::user()->l_name.' sent a message to administrator successfully.';
            Log::Info($msg_to_show);
        }
    }
?>

@extends('layouts.home_page_base')
<style>
.my-text-height {height:75%;}
</style>

@section('goback')
    @if (isset($_GET['jobIdFromProj']))
	<a class="text-primary" href="{{route('project_selected', ['id'=>$job->job_proj_id])}}" style="margin-right: 10px;">Back</a>
    @else
	<a class="text-primary" href="{{route('job_main')}}" style="margin-right: 10px;">Back</a>
    @endif
@show

@if (!$job_id) {
	@section('function_page')
		<div>
			<div class="row">
				<div class="col col-sm-auto">
					<h2 class="text-muted pl-2">Result of the Task</h2>
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
					<h2 class="text-muted pl-2">Task {{$job->job_name}} (for Client <span style="color:maroon; font-family: Georgia; font-style: italic;">{{$client->clnt_name}}</span>):</h2>
				</div>
				<div class="col my-auto ml-5">
					<button class="btn btn-danger" type="button"><a href="job_delete?id={{$job->id}}" onclick="return myConfirmation();">Delete</a></button>
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
                                <div class="col"><label class="col-form-label">Task Name:&nbsp;</label></div>
                                <div class="col"><input class="form-control mt-1 my-text-height" type="text" readonly id="job_name" name="job_name" value="{{$job->job_name}}"></div>
                            </div>
                            <div class="row">
                                <div class="col"><label class="col-form-label">Task Type:&nbsp;</label><span class="text-danger">*</span></div>
                                <div class="col">
                                    <?php
                                    $tagHead = "<input list=\"job_type\" name=\"job_type\" id=\"jobtypeinput\" onfocus=\"this.value='';\" onblur=\"if (this.value=='') this.value='".$job->job_type."';\" class=\"form-control mt-1 my-text-height\" value=\"".$job->job_type."\"";
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
                                <div class="col"><label class="col-form-label">Task Address:&nbsp;</label></div>
                                @if (!$project)
                                <div class="col"><input class="form-control mt-1 my-text-height" type="text" readonly id="job_address" name="job_address"></div>
                                @else
                                <div class="col"><input class="form-control mt-1 my-text-height" type="text" readonly id="job_address" name="job_address" value="{{$project->proj_address}}"></div>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col"><label class="col-form-label">Task City:&nbsp;</label></div>
                                @if (!$project)
                                <div class="col"><input class="form-control mt-1 my-text-height" type="text" readonly id="job_city" name="job_city"></div>
                                @else
                                <div class="col"><input class="form-control mt-1 my-text-height" type="text" readonly id="job_city" name="job_city" value="{{$project->proj_city}}"></div>
                                @endif
                                <div class="col"><label class="col-form-label">Task Province:&nbsp;</label></div>
                                @if (!$project)
                                <div class="col"><input class="form-control mt-1 my-text-height" type="text" readonly id="job_province" name="job_province"></div>
                                @else
                                <div class="col"><input class="form-control mt-1 my-text-height" type="text" readonly id="job_province" name="job_province" value="{{$project->proj_province}}"></div>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col"><label class="col-form-label">Task Description:&nbsp;</label></div>
                                <div class="col"><textarea class="form-control mt-1 my-text-height" rows = "5" id="job_desc" name="job_desc" placeholder="{{$job->job_desc}}">{{$job->job_desc}}</textarea></div>
                                <div class="col"><label class="col-form-label">Task Status:&nbsp;</label></div>
                                <div class="col">
                                    <?php
                                    $tagHead = "<input list=\"job_status\" name=\"job_status\" id=\"jobstatusinput\" onfocus=\"this.value='';\" onblur=\"if (this.value=='') this.value='".$job->job_status."';\" class=\"form-control mt-1\" value=\"".$job->job_status."\"";
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
                                <div class="col">
                                    <div class="row d-flex justify-content-center">
                                        <button class="btn btn-success mx-4" type="submit" id="btn_save">Save</button>
                                        <button class="btn btn-info mx-3 mr-2" type="button" onclick="DoJobCombination();">Edit Task Dispatch</button>
                                        <button class="btn btn-secondary mx-3 ml-2" type="button"><a href="{{route('project_selected', ['id'=>$job->job_proj_id])}}">Cancel</a></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
			<div class="m-4" style="background: var(--bs-btn-bg); background-color:gold;">
                        @if (Auth::user()->role == 'ADMINISTRATOR')
                        <h3 class="ml-2">Conversation with the Task Superintendent</h3>
                        @else
                        <h3 class="ml-2">Conversation with Administrator</h3>
                        @endif
                <div class="row mx-2">
                    <div class="col">
                        <form method="post" action="{{url('job_combination_msg_to_staff')}}">
                            @csrf
                            <div class="row">
                                <div class="col ml-1">
                                    @if (Auth::user()->role == 'ADMINISTRATOR')
                                    <div class="row"><label class="col-form-label">Message To Superintendent:&nbsp;</label></div>
                                    <div class="row"><textarea class="form-control mt-1 my-text-height" type="text" row="10" id="msg_from_admin" name="msg_from_admin">{{$association->jobdsp_msg_from_admin}}</textarea></div>
                                    @else
                                    <div class="row"><label class="col-form-label">Message From Administrator:&nbsp;</label></div>
                                    <div class="row"><textarea readonly class="form-control mt-1 my-text-height" style="background-color:silver;" type="text" row="10" id="msg_from_admin" name="msg_from_admin">{{$association->jobdsp_msg_from_admin}}</textarea></div>
                                    @endif
                                </div>
                                <div class="col ml-1">
                                    @if (Auth::user()->role == 'ADMINISTRATOR')
                                    <div class="row"><label class="col-form-label">Message From Superintendent:&nbsp;</label></div>
                                    <div class="row"><textarea readonly class="form-control mt-1 my-text-height" style="background-color:silver;" type="text" row="10" id="msg_from_staff" name="msg_from_staff">{{$association->jobdsp_msg_from_staff}}</textarea></div>
                                    @else
                                    <div class="row"><label class="col-form-label">Message To Administrator:&nbsp;</label></div>
                                    <div class="row"><textarea class="form-control mt-1 my-text-height" type="text" row="10" id="msg_from_staff" name="msg_from_staff">{{$association->jobdsp_msg_from_staff}}</textarea></div>
                                    @endif
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="w-25"></div>
                                <div class="col">
                                    <div class="row d-flex justify-content-start">
                                        <button class="btn btn-success mx-4" type="submit" onclick="return doSendMsgToReceiver('{{Auth::user()->role}}');">Send</button>
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
            var msgToShow = {!!json_encode($msg_to_show)!!};
            var thisUserRole = {!!json_encode(Auth::user()->role)!!};
            var jobId = {!!json_encode($job_id)!!};
            var staffId = {!!json_encode($staff_id)!!};
            if (msgToShow.length > 0) {
                alert(msgToShow);
            }

			function myConfirmation() {
				if(!confirm("Are you sure to delete this task?"))
				    event.preventDefault();
			}

            function DoJobCombination() {
                event.preventDefault();
                url   = './job_combination_main?jobId='+{!!json_encode($job_id)!!};
                window.location = url;
            }

            setTimeout(ReloadJobMsg, 7500);

            function ReloadJobMsg() {
                if (thisUserRole == 'ADMINISTRATOR') {
                    toThisUrl = '/reload_page_for_job_msg_from_staff';
                } else {
                    toThisUrl = '/reload_page_for_job_msg_from_admin';
                }
                $.ajax({
                    url: toThisUrl,
                    type: 'POST',
                    data: {
                        _token:"{{ csrf_token() }}", 
                        job_id:jobId,
                        staff_id:{!!json_encode($association_staff_id)!!},
                    },    // the _token:token is for Laravel
                    success: function(dataRetFromPHP) {
                        setTimeout(ReloadJobMsg, 7500);
                        if (thisUserRole == 'ADMINISTRATOR') {
                            if (document.getElementById('msg_from_staff').value != dataRetFromPHP) {
                                document.getElementById('msg_from_staff').value = dataRetFromPHP;
                                document.getElementById('msg_from_staff').style.color = 'red';
                            } else {
                                document.getElementById('msg_from_staff').value = dataRetFromPHP;
                                document.getElementById('msg_from_staff').style.color = 'white';
                            }
                        } else {
                            if (document.getElementById('msg_from_admin').value != dataRetFromPHP) {
                                document.getElementById('msg_from_admin').value = dataRetFromPHP;
                                document.getElementById('msg_from_admin').style.color = 'red';
                            } else {
                                document.getElementById('msg_from_admin').value = dataRetFromPHP;
                                document.getElementById('msg_from_admin').style.color = 'white';
                            }
                        }
                    },
                    error: function(err) {
                        setTimeout(ReloadJobMsg, 7500);
                    }
                });
            }

            function doSendMsgToReceiver(senderRole) {
                event.preventDefault();
                if (senderRole == 'ADMINISTRATOR') {
                    msg = document.getElementById('msg_from_admin').value;
                    toThisUrl = '/job_combination_msg_to_staff';
                    staffId = {!!json_encode($association_staff_id)!!};
                    if (staffId == '') {
                        alert('The task has not been dispatched to any superintendent yet, so the message cannot be sent now.');
                        return;
                    }
                } else {
                    msg = document.getElementById('msg_from_staff').value;
                    toThisUrl = '/job_combination_msg_to_admin';
                }
                if (msg.length > 0) {
                    $.ajax({
                        url: toThisUrl,
                        type: 'POST',
                        data: {
                            _token:"{{ csrf_token() }}", 
                            job_id:jobId,
                            staff_id:staffId,
                            msg:msg
                        },    // the _token:token is for Laravel
                        success: function(dataRetFromPHP) {
                            if (senderRole == 'ADMINISTRATOR') {
                                window.location = './job_selected?jobId='+jobId+'&msgToStaffOK=true';
                            } else {
                                window.location = './job_selected?jobId='+jobId+'&msgToAdminOK=true';
                            }
                        },
                        error: function(err) {
                            if (senderRole == 'ADMINISTRATOR') {
                                window.location = './job_selected?jobId='+jobId+'&msgToStaffOK=false';
                            } else {
                                window.location = './job_selected?jobId='+jobId+'&msgToAdminOK=false';
                            }
                        }
                    });
                }
            }
		</script>
	@endsection
}
@endif

