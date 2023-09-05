<?php
	use App\Models\Project;
	use App\Models\Client;
	use App\Models\Status;
	use App\Models\Staff;
	use App\Models\Job;
	use App\Models\JobType;
	use App\Models\Material;
	use App\Models\JobDispatch;

    $job_id = "";
    $staff_id = Auth::user()->id;
    $job_lead_id = "";
    $lead_association = "";
    $msg_to_show = "";
    $job_inspector_id = "";
    $inspector_sig = "";
    $workinghours_last_time = "";
    $today_daytime = date('Y-m-d', time());
    $status_of_this_job = "";
    $todays_working_hours_saved = 'false';

    if (isset($_GET['jobId'])) {
        $job_id = $_GET['jobId'];
        $from_project = 'false';
    }

    if (isset($_GET['jobIdFromProj'])) {
        $job_id = $_GET['jobIdFromProj'];
        $from_project = 'true';
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
        $total_received = 0;
        foreach($associations as $association) {
            $staff = Staff::where('id', $association->jobdsp_staff_id)->first();
            if ($staff) {
                if ($staff->role == 'SUPERINTENDENT') {
                    $job_lead_id = $staff->id;
                    $lead_association = $association;
                    $workinghours_last_time = date('Y-m-d', strtotime($association->jobdsp_workinghours_last_time));
                    // break;
                    if (($association->jobdsp_status == 'CREATED') && (Auth::user()->id == $staff->id)) {
                        $association->jobdsp_status = 'RECEIVED';

                        $result = $association->save();
                        if (!$result) {
                            MyHelper::LogStaffActionResult(Auth::user()->id, 'Failed to updated JobDispatch status to RECEIVED for task '.$job_id.'.', '900');
                        } else {
                            MyHelper::LogStaffActionResult(Auth::user()->id, 'Updated JobDispatch status to RECEIVED OK for task '.$job_id.'.', '');
                        }
                    }
                }
                if ($staff->role == 'INSPECTOR') {
                    $job_inspector_id = $staff->id;
                }
                if ($association->jobdsp_status == 'RECEIVED') {
                    $total_received++;
                }
            }
        }
        if ((Auth::user()->id == $job_lead_id) && (Auth::user()->role == 'SUPERINTENDENT')) {
            if (strstr($job->job_status, 'COMPLETED')) {
                // If anybody associated with that task had completed it, keep that ?/? COMPLETED status
                // Or, if the SUPERINTENDENT's association had be received, keep that ?/? RECEIVED status
            } else {
                $new_job_status = $total_received.'/'.$job->job_total_assistants.' RECEIVED';
                if ($new_job_status != $job->job_status) {
                    $job->job_status = $new_job_status;
                    $result = $job->save();
                    if (!$result) {
                        MyHelper::LogStaffActionResult(Auth::user()->id, 'Failed to updated Job status to '.$total_received.'/'.$job->job_total_assistants.' RECEIVED for task '.$job_id.'.', '900');
                    } else {
                        MyHelper::LogStaffActionResult(Auth::user()->id, 'Updated Job status to '.$total_received.'/'.$job->job_total_assistants.' RECEIVED OK for task '.$job_id.'.', '');
                    }
                }
            }
        }

        // Find out the signature of inspection (SUPERINTENDENT's priority is greater than INSPECTOR's; because SUPERINTENDENT can also perform the inspection)
        $sig_files = scandir('signature');
        foreach($sig_files as $sig_file) {
            if ($sig_file == 'task_'.$job_id.'_sigof_'.$job_lead_id.'_img.png') {
                $inspector_sig = $sig_file;
                break;
            }
            if ($sig_file == 'task_'.$job_id.'_sigof_'.$job_inspector_id.'_img.png') {
                $inspector_sig = $sig_file;
            }
        }

        $status_of_this_job = $job->job_status;
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
    @elseif (isset($_GET['jobFromMtrlId']))
	<a class="text-primary" href="{{route('material_selected', ['id'=>$_GET['jobFromMtrlId']])}}" style="margin-right: 10px;">Back</a>
    @else
	<a class="text-primary" href="{{route('job_main', ['display_filter'=>'active'])}}" style="margin-right: 10px;">Back</a>
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
                                    if ($job->job_status == 'COMPLETED') {
                                        $tagHead = "<input list=\"job_type\" name=\"job_type\" id=\"jobtypeinput\" readonly onfocus=\"this.value='';\" onblur=\"if (this.value=='') this.value='".$job->job_type."';\" class=\"form-control mt-1 my-text-height\" value=\"".$job->job_type."\"";
                                    } else {
                                        $tagHead = "<input list=\"job_type\" name=\"job_type\" id=\"jobtypeinput\" onfocus=\"this.value='';\" onblur=\"if (this.value=='') this.value='".$job->job_type."';\" class=\"form-control mt-1 my-text-height\" value=\"".$job->job_type."\"";
                                    }
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
                                <div class="col"><input class="form-control mt-1 my-text-height" type="text" readonly id="job_city" name="job_city" value="{{$project->proj_city}}, {{$project->proj_province}}"></div>
                                @endif
                                <div class="col"><label class="col-form-label">Task Status:&nbsp;</label></div>
                                <div class="col">
                                    <?php
                                    if ($job->job_status == 'COMPLETED') {
                                        $tagHead = "<input list=\"job_status\" name=\"job_status\" id=\"jobstatusinput\" readonly onfocus=\"this.value='';\" onblur=\"if (this.value=='') this.value='".$job->job_status."';\" class=\"form-control mt-1\" value=\"".$job->job_status."\"";
                                    }                                        
                                    else {
                                        $tagHead = "<input list=\"job_status\" name=\"job_status\" id=\"jobstatusinput\" onfocus=\"this.value='';\" onblur=\"if (this.value=='') this.value='".$job->job_status."';\" class=\"form-control mt-1\" value=\"".$job->job_status."\"";
                                    }
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
                                <div class="col"><label class="col-form-label">Inspection Report:&nbsp;</label></div>
                                <div class="col"><textarea class="form-control mt-1 my-text-height" rows = "5" id="job_desc" name="job_inspection_report" readonly placeholder="{{$job->job_inspection_report}}">{{$job->job_inspection_report}}</textarea></div>
                                <div class="col"><label class="col-form-label">Task Description:&nbsp;</label></div>
                                <div class="col"><textarea class="form-control mt-1 my-text-height" rows = "5" id="job_desc" name="job_desc" placeholder="{{$job->job_desc}}">{{$job->job_desc}}</textarea></div>
                            </div>
                            <div class="row">
                                <div class="col"><label class="col-form-label">Inspector Signature:&nbsp;</label></div>
                                @if ($inspector_sig == "")
                                <div class="col"><img src="" style="margin: 0; padding: 0; border: 1px solid #c4caac;"></img></div>
                                @else
                                <div class="col"><img src="signature/{{$inspector_sig}}" width="360" height="100" style="margin: 0; padding: 0; border: 1px solid #c4caac;"></img></div>
                                @endif
                                <div class="col"><label class="col-form-label">&nbsp;</label></div>
                                <div class="col"><input class="form-control mt-1 my-text-height" type="hidden" readonly id="job_id" name="job_id" value="{{$job->id}}"></div>
                            </div>
                            <div class="row my-3">
                                <div class="col">
                                    <div class="row d-flex justify-content-center">
                                        <button class="btn btn-success mx-4" type="submit" id="btn_save">Save</button>
                                        <button class="btn btn-info mx-3 mr-2" type="button" onclick="DoJobCombination();">Edit Task Dispatchment</button>


                                        @if (isset($_GET['jobIdFromProj']))
                                        <button class="btn btn-secondary mx-3 ml-2" type="button"><a href="{{route('project_selected', ['id'=>$job->job_proj_id])}}">Cancel</a></button>
                                        @elseif (isset($_GET['jobFromMtrlId']))
                                        <button class="btn btn-secondary mx-3 ml-2" type="button"><a href="{{route('material_selected', ['id'=>$_GET['jobFromMtrlId']])}}">Cancel</a></button>
                                        @else
                                        <button class="btn btn-secondary mx-3 ml-2" type="button"><a href="{{route('job_main', ['display_filter'=>'active'])}}">Cancel</a></button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @if ($job_lead_id != "") 
                @if (Auth::user()->role != 'ADMINISTRATOR')
                <div class="row m-4" style="background-color:lightsteelblue;">
                    <div class="col">
                        <form method="post" action="{{url('job_assistant_save_working_hours_today')}}">
                            @csrf
                            <div class="row mt-3">
                                <div class="col"><label class="col-form-label">Today's Working Hours:&nbsp;</label></div>
                                @if ((!$lead_association->jobdsp_workinghours_last_time) || (date('Y-m-d', strtotime($lead_association->jobdsp_workinghours_last_time)) != date('Y-m-d', time())))
                                <div class="col"><input class="form-control mt-1 my-text-height" type="number" step="0.1" id="jobdsp_workinghours_today" name="jobdsp_workinghours_today" value=""></div>
                                @elseif ($lead_association->jobdsp_workinghours_today && $lead_association->jobdsp_workinghours_today>=0)
                                <?php $todays_working_hours_saved = 'true'; ?>
                                <div class="col"><input class="form-control mt-1 my-text-height" type="number" step="0.1" readonly id="jobdsp_workinghours_today" name="jobdsp_workinghours_today" value="{{$lead_association->jobdsp_workinghours_today}}"></div>
                                @else
                                <div class="col"><input class="form-control mt-1 my-text-height" type="number" step="0.1" id="jobdsp_workinghours_today" name="jobdsp_workinghours_today" value=""></div>
                                @endif
                                <div class="col"><label class="col-form-label">Total Working Hours:&nbsp;</label></div>
                                <div class="col"><input class="form-control mt-1 my-text-height" type="number" step="0.1" readonly id="jobdsp_workinghours_total" name="jobdsp_workinghours_total" value="{{$lead_association->jobdsp_workinghours_total}}"></div>
                            </div>
                            <div class="row my-3">
                                <div class="col d-flex justify-content-center">
                                    @if ((!$lead_association->jobdsp_workinghours_last_time) || (date('Y-m-d', strtotime($lead_association->jobdsp_workinghours_last_time)) != date('Y-m-d', time())))
                                    <button class="btn btn-success mx-4" type="submit" id="btn_submit" onclick="RecordTodaysWorkingHours();">Submit</button>
                                    @elseif ($lead_association->jobdsp_workinghours_today && $lead_association->jobdsp_workinghours_today>=0)
                                    <button class="btn btn-success mx-4" type="submit" id="btn_submit" disabled onclick="RecordTodaysWorkingHours();">Submit</button>
                                    @else
                                    <button class="btn btn-success mx-4" type="submit" id="btn_submit" onclick="RecordTodaysWorkingHours();">Submit</button>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @endif

                <!-- The section for the conversation between ADMINISTRATOR and SUPERINTENDENT -->
                @if (($lead_association->jobdsp_status != 'COMPLETED') && ($lead_association->jobdsp_status != 'DELETED'))
                <div class="m-4" style="background: var(--bs-btn-bg); background-color:gold;">
                    @if (Auth::user()->role == 'ADMINISTRATOR')
                    <h3 class="ml-2">Conversation with the Task Superintendent</h3>
                    @else
                    <h3 class="ml-2">Conversation with Administrator</h3>
                    @endif

                    <div class="row mx-2 mt-3">
                        <div class="col">
                            <form method="post" action="{{url('job_combination_msg_to_staff')}}">
                                @csrf
                                <div class="row">
                                    <div class="col ml-1">
                                        @if (Auth::user()->role == 'ADMINISTRATOR')
                                        <div class="row"><label class="col-form-label">Message To Superintendent:&nbsp;</label></div>
                                        <div class="row">
                                            <textarea class="form-control mt-1" style="height: 150px; !important" type="text" row="10" id="msg_from_admin" name="msg_from_admin">{{$lead_association->jobdsp_msg_from_admin}}</textarea>
                                        </div>
                                        @else
                                        <div class="row"><label class="col-form-label">Message From Administrator:&nbsp;</label></div>
                                        <div class="row">
                                            <textarea readonly class="form-control mt-1" style="background-color:silver; height: 150px; !important" type="text" row="10" id="msg_from_admin" name="msg_from_admin">{{$lead_association->jobdsp_msg_from_admin}}</textarea>
                                            <?php 
                                                $lead_association->jobdsp_msg_from_admin_old = $lead_association->jobdsp_msg_from_admin; 
                                                $lead_association->save();
                                            ?>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col ml-1">
                                        @if (Auth::user()->role == 'ADMINISTRATOR')
                                        <div class="row"><label class="col-form-label">Message From Superintendent:&nbsp;</label></div>
                                        <div class="row">
                                            <textarea readonly class="form-control mt-1" style="background-color:silver; height: 150px; !important" type="text" row="10" id="msg_from_staff" name="msg_from_staff">{{$lead_association->jobdsp_msg_from_staff}}</textarea>
                                            <?php 
                                                $lead_association->jobdsp_msg_from_staff_old = $lead_association->jobdsp_msg_from_staff; 
                                                $lead_association->save();
                                            ?>                        
                                        </div>
                                        @else
                                        <div class="row"><label class="col-form-label">Message To Administrator:&nbsp;</label></div>
                                        <div class="row">
                                            <textarea class="form-control mt-1" style="height: 150px; !important" type="text" row="10" id="msg_from_staff" name="msg_from_staff">{{$lead_association->jobdsp_msg_from_staff}}</textarea>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="row my-3">
                                    <div class="w-75"></div>
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
                @endif

                <!-- The section of changing each material's mtrl_amount_left -->
                <?php
                $materials  = Material::where('mtrl_job_id', $job_id)->where('mtrl_status', '<>', 'DELETED')->where('mtrl_status', '<>', 'CANCELED')->orderBy('mtrl_type')->get();
                ?>
                @if (count($materials) > 0)
                <div class="m-4 bg-info text-white">
                    <h4 class="ml-2">Materials</h4>
                    <div class="row mx-2 mt-3 mb-1">
                        <?php
                        $outContents = "<div class=\"col-2\">";
                            $outContents .= "<strong>Material Name</strong>";
                        $outContents .= "</div>";
                        $outContents .= "<div class=\"col-1\">";
                            $outContents .= "<strong>Type</strong>";
                        $outContents .= "</div>";
                        $outContents .= "<div class=\"col-2\">";
                            $outContents .= "<strong>Model</strong>";
                        $outContents .= "</div>";
                        $outContents .= "<div class=\"col-2\">";
                            $outContents .= "<strong>Size</strong>";
                        $outContents .= "</div>";
                        $outContents .= "<div class=\"col-2\">";
                            $outContents .= "<strong>Original Amount</strong>";
                        $outContents .= "</div>";
                        $outContents .= "<div class=\"col-2\">";
                            $outContents .= "<strong>Left Amount</strong>";
                        $outContents .= "</div>";
                        $outContents .= "<div class=\"col-1\">";
                            $outContents .= "<strong></strong>";
                        $outContents .= "</div>";
                        echo $outContents;
                        ?>
                    </div>
                    <?php
                    foreach ($materials as $material) {
                        $outContents = "<div class=\"row mx-2\">";
                        $outContents .= "<div class=\"col-2\">";
                            // $outContents .= "<a href=\"assistant_material_in_job_selected?id=$material->id\">";
                        $outContents .= $material->mtrl_name;
                            // $outContents .= "</a>";
                        $outContents .= "</div>";
                        $outContents .= "<div class=\"col-1\">";
                            // $outContents .= "<a href=\"assistant_material_in_job_selected?id=$material->id\">";
                            $outContents .= $material->mtrl_type;
                            // $outContents .= "</a>";
                        $outContents .= "</div>";
                        $outContents .= "<div class=\"col-2\">";
                            // $outContents .= "<a href=\"assistant_material_in_job_selected?id=$material->id\">";
                            $outContents .= $material->mtrl_model;
                            // $outContents .= "</a>";
                        $outContents .= "</div>";
                        $outContents .= "<div class=\"col-2\">";
                            // $outContents .= "<a href=\"assistant_material_in_job_selected?id=$material->id\">";
                            $outContents .= $material->mtrl_size;
                            // $outContents .= "</a>";
                        $outContents .= "</div>";
                        $outContents .= "<div class=\"col-2\">";
                            // $outContents .= "<a href=\"assistant_material_in_job_selected?id=$material->id\">";
                            $outContents .= $material->mtrl_amount;
                            // $outContents .= "</a>";
                        $outContents .= "</div>";
                        $outContents .= "<div class=\"col-2\">";
                            // $outContents .= "<a href=\"assistant_material_in_job_selected?id=$material->id\">";
                            $outContents .= "<input class=\"form-control mt-1 my-text-height\" step=\"0.01\" type=\"number\" id=\"m_left_".$material->id."\" value=\"".$material->mtrl_amount_left."\">";
                            // $outContents .= "</a>";
                        $outContents .= "</div>";
                        $outContents .= "<div class=\"col-1 mt-1\">";
                            $outContents .= "<button onclick=\"UpdateMtrlLeft(".$material->id.")\" class=\"rounded\">";
                            $outContents .= "Update";
                            $outContents .= "</button>";
                        $outContents .= "</div>";
                        $outContents .= "</div>";
                        echo $outContents;;
                    }
                    ?>
                </div>
                @endif

                <!-- The section for the 'Close this Task' button -->
                <div class="row my-3">
                    <div class="col">
                        <div class="row d-flex justify-content-center">
                            @if ((Auth::user()->role != 'ADMINISTRATOR') && ($job->job_status != 'COMPLETED') && ($job_lead_id != ""))
                            <button class="btn btn-danger m-2 p-4 rounded" type="button" onclick="CloseThisTask();">Close this Task</button>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
		</div>
		
		<script>
            var msgToShow = {!!json_encode($msg_to_show)!!};
            var thisUserRole = {!!json_encode(Auth::user()->role)!!};
            var jobId = {!!json_encode($job_id)!!};
            var staffId = {!!json_encode($staff_id)!!};
            let fromProject = {!!json_encode($from_project)!!};

            if (msgToShow.length > 0) {
                alert(msgToShow);
            }

			function myConfirmation() {
                let jobStatus = {!!json_encode($status_of_this_job)!!};
                if (jobStatus == 'COMPLETED' || jobStatus.indexOf("RECEIVED") >= 0 || jobStatus.indexOf("DISPATCHED") >= 0) {
				    event.preventDefault();
                    alert('This task has been dispatched, so you cannot delete it now.');
                } else {
                    if(!confirm("Continue to delete this task?")) {
                        event.preventDefault();
                    }
                }
			}

            function DoJobCombination() {
                event.preventDefault();
                if (fromProject == 'true') {
                    url   = './job_combination_main?jobIdFromProj='+{!!json_encode($job_id)!!};
                } else {
                    url   = './job_combination_main?jobId='+{!!json_encode($job_id)!!};
                }
                window.location = url;
            }

            setTimeout(ReloadJobMsg, 7500);

            function ReloadJobMsg() {
                // alert('HHOHO')
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
                        staff_id:{!!json_encode($job_lead_id)!!},
                    },    // the _token:token is for Laravel
                    success: function(dataRetFromPHP) {
                        setTimeout(ReloadJobMsg, 7500);
                        if (thisUserRole == 'ADMINISTRATOR') {
                            if (document.getElementById('msg_from_staff')) {
                                if (document.getElementById('msg_from_staff').value != dataRetFromPHP) {
                                    document.getElementById('msg_from_staff').value = dataRetFromPHP;
                                    document.getElementById('msg_from_staff').style.color = 'red';
                                } else {
                                    document.getElementById('msg_from_staff').value = dataRetFromPHP;
                                    document.getElementById('msg_from_staff').style.color = 'white';
                                }
                            }
                        } else {
                            if (document.getElementById('msg_from_admin')) {
                                if (document.getElementById('msg_from_admin').value != dataRetFromPHP) {
                                    document.getElementById('msg_from_admin').value = dataRetFromPHP;
                                    document.getElementById('msg_from_admin').style.color = 'red';
                                } else {
                                    document.getElementById('msg_from_admin').value = dataRetFromPHP;
                                    document.getElementById('msg_from_admin').style.color = 'white';
                                }
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
                    staffId = {!!json_encode($job_lead_id)!!};
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
                                if (fromProject == 'true') {
                                    window.location = './job_selected?jobIdFromProj='+jobId+'&msgToStaffOK=true';
                                } else {
                                    window.location = './job_selected?jobId='+jobId+'&msgToStaffOK=true';
                                }
                            } else {
                                if (fromProject == 'true') {
                                    window.location = './job_selected?jobIdFromProj='+jobId+'&msgToAdminOK=true';
                                } else {
                                    window.location = './job_selected?jobId='+jobId+'&msgToAdminOK=true';
                                }
                            }
                        },
                        error: function(err) {
                            if (senderRole == 'ADMINISTRATOR') {
                                if (fromProject == 'true') {
                                    window.location = './job_selected?jobIdFromProj='+jobId+'&msgToStaffOK=false';
                                } else {
                                    window.location = './job_selected?jobId='+jobId+'&msgToStaffOK=false';
                                }
                            } else {
                                if (fromProject == 'true') {
                                    window.location = './job_selected?jobIdFromProj='+jobId+'&msgToAdminOK=false';
                                } else {
                                    window.location = './job_selected?jobId='+jobId+'&msgToAdminOK=false';
                                }
                            }
                        }
                    });
                }
            }

            function RecordTodaysWorkingHours() {
                event.preventDefault();
                let workingHours = document.getElementById('jobdsp_workinghours_today').value;
                if (workingHours == '') {
                    alert('Today\'s working hours cannot be emtpy!\r\n\r\nPlease try again.');
                } else {
                    if(!confirm('You cannot change this value after you submit it.\r\rContinue to submit this value?')) {
                        //event.preventDefault();
                    } else {
                        $.ajax({
                            url: '/job_assistant_save_working_hours_today',
                            type: 'POST',
                            data: {
                                _token:"{{ csrf_token() }}", 
                                job_id: jobId,
                                staff_id: staffId,
                                jobdsp_workinghours_today: workingHours,
                            },    // the _token:token is for Laravel
                            success: function(dataRetFromPHP) {
                                alert('Today\'s working hours has been saved successfully.');
                                if (fromProject == 'true') {
                                    window.location = './job_selected?jobIdFromProj='+jobId;
                                } else {
                                    window.location = './job_selected?jobId='+jobId;
                                }
                            },
                            error: function(err) {
                                alert('Today\'s working hours cannot be saved.');
                            }
                        });
                    }
                }
            }

            function CloseThisTask() {
                event.preventDefault();
                let workingHoursLastTime = {!!json_encode($workinghours_last_time)!!};
                let todayDayTime = {!!json_encode($today_daytime)!!};
                let workingHours = document.getElementById('jobdsp_workinghours_today').value;
                let inspectorSig = {!!json_encode($inspector_sig)!!};
                let confirmRslt = true;
                let continueIt  = false;
                let todaysWorkingHoursSaved = {!!json_encode($todays_working_hours_saved)!!};
                // let confirmMessage = 'Today\'s working hours is empty.\r\nAfter you close this task, you won\'t be able to enter it again!\r\n\r\nAre you sure to close this task?';
                // if (todayDayTime == workingHoursLastTime && (workingHours == 0 || workingHours == '')) {
                //     confirmRslt = confirm(confirmMessage);
                // } else if (todayDayTime != workingHoursLastTime) {
                //     confirmRslt = confirm(confirmMessage);
                // }

                if(todaysWorkingHoursSaved == 'false') {
                    alert('Please enter your Today\'s Working Hours first.');
                } else {
                    if (inspectorSig == '') {
                        if (!confirm('The task is not inspected yet.\r\n\r\nContinut to close it?')) {                            
                        } else {
                            continueIt = true;
                        }
                    } else {
                        continueIt = true;
                    }

                    if (continueIt == true) {
                        if (!confirm('\r\nMAKE SURE ALL THE \'Left Amount\' VALUES ARE ENTERED CORRECTLY BEFORE YOU CLOSE THIS TASK!\r\n\r\nAfter you close this task, you cannot change it anymore.\r\nContinue to close it?')) {
                            //
                        } else {
                            $.ajax({
                                url: '/job_close_by_lead',
                                type: 'POST',
                                data: {
                                    _token:"{{ csrf_token() }}", 
                                    job_id: jobId,
                                    staff_id: staffId,
                                },    // the _token:token is for Laravel
                                success: function(dataRetFromPHP) {
                                    alert('This task has been closed successfully.');
                                    if (fromProject == 'true') {
                                        window.location = './job_selected?jobIdFromProj='+jobId;
                                    } else {
                                        window.location = './job_selected?jobId='+jobId;
                                    }
                                },
                                error: function(err) {
                                    alert('Oops, failed to close this task.');
                                    if (fromProject == 'true') {
                                        window.location = './job_selected?jobIdFromProj='+jobId;
                                    } else {
                                        window.location = './job_selected?jobId='+jobId;
                                    }
                                }
                            });
                        }
                    }
                }
            }

            function UpdateMtrlLeft(mtrlId) {
                let mtrlLeftAmount = document.getElementById('m_left_'+mtrlId).value;
                // if (!confirm('After you update this value, you cannot change it anymore.\r\n\r\nContinue to update?')) {
                //     //
                // } else {
                    $.ajax({
                        url: '/update_material_left_amount',
                        type: 'POST',
                        data: {
                            _token:"{{ csrf_token() }}", 
                            id: mtrlId,
                            mtrl_amount_left: mtrlLeftAmount,
                        },    // the _token:token is for Laravel
                        success: function(dataRetFromPHP) {
                            alert('The material\'s left amount has been updated successfully.');
                            if (fromProject == 'true') {
                                window.location = './job_selected?jobIdFromProj='+jobId;
                            } else {
                                window.location = './job_selected?jobId='+jobId;
                            }
                        },
                        error: function(err) {
                            alert('Oops, failed to close this task.');
                            if (fromProject == 'true') {
                                window.location = './job_selected?jobIdFromProj='+jobId;
                            } else {
                                window.location = './job_selected?jobId='+jobId;
                            }
                        }
                    });
                // }
            }
		</script>
	@endsection
}
@endif

