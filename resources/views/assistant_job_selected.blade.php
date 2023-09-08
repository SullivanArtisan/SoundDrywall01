<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>2020_Assistant_Main_01</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/signature.js"></script>
</head>

<body>
    <?php
        use App\Models\Job;
        use App\Models\Staff;
        use App\Models\Client;
        use App\Models\Project;
        use App\Models\Material;
        use App\Models\JobDispatch;
        use App\Helper\MyHelper;
        use Illuminate\Support\Facades\Log;
        use Illuminate\Support\Facades\Auth;

        $client_name = "";
        $role = "";
        $inspector_sig = "";
        $todays_working_hours_saved = 'false';
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $staff_id = Auth::user()->id;
            $job = Job::where('id', $id)->first();
            $msg_to_show = "";
            if ($job) {
                $staff = Staff::where('id', $staff_id)->first();
                $role = $staff->role;

                $association = JobDispatch::where('jobdsp_job_id', $id)->where('jobdsp_staff_id', $staff_id)->first();
                if (!$association) {
                    Log::Info("JobDispatch object cannot be found for task ".$id);
                    url()->previous();
                } else {
                    if ($association->jobdsp_status == 'CREATED') {
                        $association->jobdsp_status = 'RECEIVED';

                        $result = $association->save();
                        if (!$result) {
                            MyHelper::LogStaffActionResult(Auth::user()->id, 'Failed to updated JobDispatch status to RECEIVED for task '.$id.'.', '900');
                        } else {
                            MyHelper::LogStaffActionResult(Auth::user()->id, 'Updated JobDispatch status to RECEIVED OK for task '.$id.'.', '');

                            $total_received = 0;
                            $associations = JobDispatch::where('jobdsp_job_id', $id)->get();
                            foreach($associations as $asso) {
                                if ($asso->jobdsp_status == 'RECEIVED') {
                                    $total_received++;
                                }
                            }

                            if (strstr($job->job_status, 'COMPLETED')) {
                                // If anybody associated with that task had completed it, keep that ?/? COMPLETED status
                            } else {
                                $job->job_status = $total_received.'/'.$job->job_total_assistants.' RECEIVED';
                                $result = $job->save();
                                if (!$result) {
                                    MyHelper::LogStaffActionResult(Auth::user()->id, 'Failed to updated Job status to '.$total_received.'/'.$job->job_total_assistants.' RECEIVED for task '.$id.'.', '900');
                                } else {
                                    MyHelper::LogStaffActionResult(Auth::user()->id, 'Updated Job status to '.$total_received.'/'.$job->job_total_assistants.' RECEIVED OK for task '.$id.'.', '');
                                }
                            }
                        }
                    }
                }

                if (isset($_GET['msgToAdminOK'])) {
                    $result = $_GET['msgToAdminOK'];
                    if ($result == 'true'){
                        $msg_to_show = 'Assistant '.Auth::user()->f_name.' '.Auth::user()->l_name.' sent a message to administrator successfully.';
                        Log::Info($msg_to_show);
                    }
                }

                $project = Project::where('id', $job->job_proj_id)->first();
                if (!$project) {
                    Log::Info("Project object cannot be found for task ".$id);
                }
                $client  = Client::where('id', $project->proj_cstmr_id)->first();
                if (!$client) {
                    Log::Info("Client object cannot be found for task ".$id);
                } else {
                    $client_name = $client->clnt_name;
                }
                $materials  = Material::where('mtrl_job_id', $id)->where('mtrl_status', '<>', 'DELETED')->where('mtrl_status', '<>', 'CANCELED')->orderBy('mtrl_type')->get();

                // Find out the signature of inspection (SUPERINTENDENT's priority is greater than INSPECTOR's; because SUPERINTENDENT can also perform the inspection)
                $sig_files = scandir('signature');
                foreach($sig_files as $sig_file) {
                    if ($sig_file == 'task_'.$id.'_sigof_'.$staff_id.'_img.png') {
                        $inspector_sig = $sig_file;
                        break;
                    }
                }
            } else {
                $err_msg = "Task ".$id."'s object cannot be accessed while just entering the task's main page.";
                Log::Info($err_msg);
            }
        }
    ?>

    <div class="container pt-5 text-dark" style="background: var(--bs-btn-bg); background-color:beige;">
        <!-- Header Section -->
        <div class="row">
            <div class="col-md-9 my-2" style="">
                <h1>Hi, <span style="font-family: 'Times New Roman';font-weight: bold;font-style: italic; color:brown !important">{{Auth::user()->f_name}} {{Auth::user()->l_name}}</span>!    Task {{$job->job_name}}'s Details:</h1>
            </div>
            <div class="col-md-1 my-4">
                        <button class="btn btn-secondary text-center" type="button">
                            <a style="text-decoration:none;"  class="text-white" 
                                href="{{route('assistant_home_page')}}">
                                <span style="font-weight:bold !important;">{{ __('Back') }}</span>
                            </a>
                        </button>
            </div>
            <div class="col-md-2 my-4" style="">
                <form method="POST" action="{{ route('logout') }}" style="cursor: pointer" id="form_assistant_logout">
                    @csrf
                    <a style="text-decoration:none;"  class="text-dark border rounded btn btn-dark" 
                        onclick="doLogout();">
                        <span style="font-weight:bold !important; color:white">{{ __('Log Out') }}</span>
                    </a>
                </form>
            </div>
        </div>

        <!-- Tasks Section -->
        <div class="row" style="max-height: 400px;">
            <div class="col-3"><label class="col-form-label">Client Name:&nbsp;</label></div>
            <div class="col-9"><input class="form-control mt-1 my-text-height" type="text" readonly id="clnt_name" name="clnt_name" value="{{$client_name}}"></div>
        </div>
        <div class="row" style="max-height: 400px;">
            <div class="col-3"><label class="col-form-label">Task Name:&nbsp;</label></div>
            <div class="col-9"><input class="form-control mt-1 my-text-height" type="text" readonly id="job_name" name="job_name" value="{{$job->job_name}}"></div>
        </div>
        <div class="row" style="max-height: 400px;">
            <div class="col-3"><label class="col-form-label">Task Type:&nbsp;</label></div>
            <div class="col-9"><input class="form-control mt-1 my-text-height" type="text" readonly id="job_type" name="job_type" value="{{$job->job_type}}"></div>
        </div>
        <div class="row" style="max-height: 400px;">
            <div class="col-3"><label class="col-form-label">Status:&nbsp;</label></div>
            <div class="col-9"><input class="form-control mt-1 my-text-height" type="text" readonly id="job_status" name="job_status" value="{{$job->job_status}}"></div>
        </div>
        <div class="row" style="max-height: 400px;">
            <div class="col-3"><label class="col-form-label">Site Address:&nbsp;</label></div>
            <div class="col-9"><input class="form-control mt-1 my-text-height" type="text" readonly id="job_address" name="job_address" value="{{$job->job_address}}"></div>
        </div>
        <div class="row" style="max-height: 400px;">
            <div class="col-3"><label class="col-form-label">Site City:&nbsp;</label></div>
            <div class="col-9"><input class="form-control mt-1 my-text-height" type="text" readonly id="job_city" name="job_city" value="{{$job->job_city}}"></div>
        </div>
        <div class="row" style="max-height: 400px;">
            <div class="col-3"><label class="col-form-label">Site Province:&nbsp;</label></div>
            <div class="col-9"><input class="form-control mt-1 my-text-height" type="text" readonly id="job_province" name="job_province" value="{{$job->job_province}}"></div>
        </div>
        <div class="row" style="max-height: 400px;">
            <div class="col-3"><label class="col-form-label">Expected Finished On:&nbsp;</label></div>
            <div class="col-9"><input class="form-control mt-1 my-text-height" type="text" readonly id="job_till_time" name="job_till_time" value="{{$job->job_till_time}}"></div>
        </div>
        <div class="row" style="max-height: 400px;">
            <div class="col-3"><label class="col-form-label">Job Description:&nbsp;</label></div>
            <div class="col-9"><textarea class="form-control mt-1 my-text-height" rows = "5" readonly id="job_desc" name="job_desc" placeholder="{{$job->job_desc}}">{{$job->job_desc}}</textarea></div>
        </div>
        <div class="row my-4 mx-1" style="background-color:lightsteelblue;">
            <div class="col">
                <form method="post" action="{{url('job_assistant_save_working_hours_today')}}">
                    @csrf
                    <div class="row mt-3">
                        <div class="col"><label class="col-form-label">Today's Working Hours:&nbsp;</label></div>
                        @if ((!$association->jobdsp_workinghours_last_time) || (date('Y-m-d', strtotime($association->jobdsp_workinghours_last_time)) != date('Y-m-d', time())))
                        <div class="col"><input class="form-control mt-1 my-text-height" type="number" step="0.1" id="jobdsp_workinghours_today" name="jobdsp_workinghours_today" value=""></div>
                        @elseif ($association->jobdsp_workinghours_today && $association->jobdsp_workinghours_today>=0)
                        <?php $todays_working_hours_saved = 'true'; ?>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="number" step="0.1" readonly id="jobdsp_workinghours_today" name="jobdsp_workinghours_today" value="{{$association->jobdsp_workinghours_today}}"></div>
                        @else
                        <div class="col"><input class="form-control mt-1 my-text-height" type="number" step="0.1" id="jobdsp_workinghours_today" name="jobdsp_workinghours_today" value=""></div>
                        @endif
                        <div class="col"><label class="col-form-label">Total Working Hours:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="number" step="0.1" readonly id="jobdsp_workinghours_total" name="jobdsp_workinghours_total" value="{{$association->jobdsp_workinghours_total}}"></div>
                    </div>
                    <div class="row my-3">
                        <div class="col d-flex justify-content-center">
                            @if ($inspector_sig == "")
                                @if ((!$association->jobdsp_workinghours_last_time) || (date('Y-m-d', strtotime($association->jobdsp_workinghours_last_time)) != date('Y-m-d', time())))
                                <button class="btn btn-success mx-4" type="submit" id="btn_submit" onclick="RecordTodaysWorkingHours();">Submit</button>
                                @elseif ($association->jobdsp_workinghours_today && $association->jobdsp_workinghours_today>=0)
                                <button class="btn btn-success mx-4" type="submit" id="btn_submit" disabled onclick="RecordTodaysWorkingHours();">Submit</button>
                                @else
                                <button class="btn btn-success mx-4" type="submit" id="btn_submit" onclick="RecordTodaysWorkingHours();">Submit</button>
                                @endif
                            @else
                                <button class="btn btn-success mx-4" type="submit" id="btn_submit" disabled onclick="RecordTodaysWorkingHours();">Submit</button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Footage Section -->
        <div class="row my-3">
            <p>
            <button class="btn btn-info" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
            <h5>Show / Hide Materials</h5>
            </button>
            </p>
            <div class="collapse" id="collapseExample">
                <div>
                    <?php
                    // Title Line
                    $outContents = "<div class=\"container mw-100\">";
                    $outContents .= "<div class=\"row bg-secondary text-white fw-bold\">";
                        $outContents .= "<div class=\"col-2\">";
                            $outContents .= "Material Name";
                        $outContents .= "</div>";
                        $outContents .= "<div class=\"col-2\">";
                            $outContents .= "Type";
                        $outContents .= "</div>";
                        $outContents .= "<div class=\"col-2\">";
                            $outContents .= "Model";
                        $outContents .= "</div>";
                        $outContents .= "<div class=\"col-2\">";
                            $outContents .= "Size";
                        $outContents .= "</div>";
                        $outContents .= "<div class=\"col-2\">";
                            $outContents .= "Original Amount";
                        $outContents .= "</div>";
                        $outContents .= "<div class=\"col-2\">";
                            $outContents .= "Left Amount";
                        $outContents .= "</div>";
                    $outContents .= "</div></div>";
                    {{echo $outContents;}}
                    // Body Lines
                    foreach ($materials as $material) {
                            $outContents = "<div class=\"row\">";
                            $outContents .= "<div class=\"col-2\">";
                            if (Auth::user()->role == 'SUPERINTENDENT')     // This doesn't happen as SUPERINTENDENT doesn't enter the Assistant...GUI for now
                                $outContents .= "<a href=\"assistant_material_in_job_selected?id=$material->id\">";
                            $outContents .= $material->mtrl_name;
                            if (Auth::user()->role == 'SUPERINTENDENT')
                                $outContents .= "</a>";
                            $outContents .= "</div>";
                            $outContents .= "<div class=\"col-2\">";
                            if (Auth::user()->role == 'SUPERINTENDENT')     // This doesn't happen as SUPERINTENDENT doesn't enter the Assistant...GUI for now
                                $outContents .= "<a href=\"assistant_material_in_job_selected?id=$material->id\">";
                                $outContents .= $material->mtrl_type;
                            if (Auth::user()->role == 'SUPERINTENDENT')
                                $outContents .= "</a>";
                            $outContents .= "</div>";
                            $outContents .= "<div class=\"col-2\">";
                            if (Auth::user()->role == 'SUPERINTENDENT')     // This doesn't happen as SUPERINTENDENT doesn't enter the Assistant...GUI for now
                                $outContents .= "<a href=\"assistant_material_in_job_selected?id=$material->id\">";
                                $outContents .= $material->mtrl_model;
                            if (Auth::user()->role == 'SUPERINTENDENT')
                                $outContents .= "</a>";
                            $outContents .= "</div>";
                            $outContents .= "<div class=\"col-2\">";
                            if (Auth::user()->role == 'SUPERINTENDENT')     // This doesn't happen as SUPERINTENDENT doesn't enter the Assistant...GUI for now
                                $outContents .= "<a href=\"assistant_material_in_job_selected?id=$material->id\">";
                                $outContents .= $material->mtrl_size;
                            if (Auth::user()->role == 'SUPERINTENDENT')
                                $outContents .= "</a>";
                            $outContents .= "</div>";
                            $outContents .= "<div class=\"col-2\">";
                            if (Auth::user()->role == 'SUPERINTENDENT')     // This doesn't happen as SUPERINTENDENT doesn't enter the Assistant...GUI for now
                                $outContents .= "<a href=\"assistant_material_in_job_selected?id=$material->id\">";
                                $outContents .= $material->mtrl_amount;
                            if (Auth::user()->role == 'SUPERINTENDENT')
                                $outContents .= "</a>";
                            $outContents .= "</div>";
                            $outContents .= "<div class=\"col-2\">";
                            if (Auth::user()->role == 'SUPERINTENDENT')     // This doesn't happen as SUPERINTENDENT doesn't enter the Assistant...GUI for now
                                $outContents .= "<a href=\"assistant_material_in_job_selected?id=$material->id\">";
                                $outContents .= $material->mtrl_amount_left;
                            if (Auth::user()->role == 'SUPERINTENDENT')
                                $outContents .= "</a>";
                            $outContents .= "</div>";
                            $outContents .= "</div><hr class=\"m-1\"/>";
                        {{ 					
                            echo $outContents;;
                        }}
                    }
                    if (count($materials) == 0) {
                        $outContents = "<div class=\"row mb-2\"><p><span style=\"margin-left:10px;\">No material dispatched yet.</span></p></div>";
                        echo $outContents;;
                    }
                    ?>
                </div>
            </div>        
            <!--div class="col">
                <div class="row mb-4">
                    <div class="col text-center" style="background: var(--bs-warning-border-subtle);position: static;padding-top: 11px; display: flex; justify-content: center;">
                        <button class="btn btn-secondary text-center" type="button">
                            <a style="text-decoration:none;"  class="text-white" 
                                href="{{route('assistant_home_page')}}">
                                <span style="font-weight:bold !important;">{{ __('Back') }}</span>
                            </a>
                        </button>
                    </div>                                        
                </div>
            </div-->
        </div>

        <!-- Messages Section -->
        <div class="row text-dark mt-4" style="background-color: khaki;">
            <h4><span class="px-2 pb-1" style="background-color: darkkhaki; color: white;">Message Section</span></h4>
            <div class="mx-2" id="msgSection">
                    <form method="post" action="{{url('job_combination_msg_to_admin')}}">
                        @csrf
                        <div class="row">
                            <div class="col m-1">
                                <div class="row font-weight-bold"><label class="col-form-label">Message From Superintendent:&nbsp;</label></div>
                                <div class="row">
                                    <textarea readonly class="form-control mt-1" style="background-color:silver; height: 150px; !important" type="text" row="10" id="msg_from_admin" name="msg_from_admin">{{$association->jobdsp_msg_from_admin}}</textarea>
                                </div>
                            </div>
                            <div class="col m-1">
                                <div class="row font-weight-bold"><label class="col-form-label">Message To  Superintendent:&nbsp;</label></div>
                                <div class="row"><textarea class="form-control mt-1" style="height: 150px; width: 640px; !important" type="text" row="10" id="msg_from_staff" name="msg_from_staff">{{$association->jobdsp_msg_from_staff}}</textarea></div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col" style="display: flex; justify-content: center;">
                                <button class="btn btn-success m-3 rounded" type="submit" onclick="return doSendMsgToAdmin();">Send Message</button>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
        <div class="row mt-3">
        </div>
            @if (Auth::user()->role == 'INSPECTOR')
            <div class="row text-dark" style="background-color:lightpink;">
                <div class="col d-flex justify-content-center align-items-center">
                    @if ($inspector_sig == "")
                    <div class="my-4" id="canvas">
                        <h4 class="mt-2 text-secondary">Signature: </h4>
                        <canvas class="roundCorners" id="signatureForTask" style=" background-color: white; position: relative; margin: 0; padding: 0; border: 1px solid #c4caac;"></canvas>
                    </div>
                    <script type="text/javascript">
                        signatureCapture('signatureForTask');
                    </script><br /><br />
                    <div class="my-4" id="canvas">
                        <canvas class="roundCorners" id="signatureForTask_shadow" style="display:none;"></canvas>
                    </div>
                    <script type="text/javascript">
                        signatureCapture('signatureForTask_shadow');
                    </script><br /><br />
                    @else
                    <div class="my-4" id="canvas">
                        <h4 class="mt-2 text-secondary">Signature: </h4>
                        <img src="signature/{{$inspector_sig}}" width="360" height="100" style="margin: 0; padding: 0; border: 1px solid #c4caac;"></img>
                    </div>
                    @endif
                </div>
                <!--div align='center' id='savedsig' style='display:none'>
                    <img align='center' id="saveSignature"/>
                </div-->
                <div class="col py-4">
                    <h4 class="mt-2 text-secondary">Inspection Report: </h4>
                    @if ($inspector_sig == "")
                    <textarea class="form-control mt-1" type="text" row="4" id="task_report" name="task_report" style="height:60%"></textarea>
                    @else
                    <textarea class="form-control mt-1" type="text" row="4" id="task_report" name="task_report" readonly style="height:60%">{{$job->job_inspection_report}}</textarea>
                    @endif
                </div>
                <div class="col my-4 text-center d-flex justify-content-end">
                    @if ($inspector_sig == "")
                    <button class="btn m-2 text-white rounded btn-secondary" onclick="signatureClear()">Clear Signature</button></br>
                    <button class="btn m-2 text-white rounded" style="background-color:lightcoral;" onclick="return doCompleteThisJob();">Finish the Inspection</button>
                    @else
                    <button class="btn m-2 text-white rounded btn-secondary" disabled>Clear Signature</button></br>
                    <button class="btn m-2 text-white rounded" style="background-color:lightcoral;" disabled>Finish the Inspection</button>
                    @endif
                </div>
            </div>
            @endif
    </div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        var msgToShow = {!!json_encode($msg_to_show)!!};
        var jobId = {!!json_encode($id)!!};
        var staffId = {!!json_encode($staff_id)!!};
        var todaysWorkingHoursSaved = {!!json_encode($todays_working_hours_saved)!!};

        if (msgToShow.length > 0) {
            alert(msgToShow);
        }

        function myFunction() {
            var x = document.getElementById("p2").getAttribute("aria-expanded"); 
            if (x == "true") {
                x = "false"
            } else {
                x = "true"
            }
            document.getElementById("p2").setAttribute("aria-expanded", x);
        }

        setTimeout(ReloadPageForJobMsg, 7500);

        function ReloadPageForJobMsg() {
            $.ajax({
                url: '/reload_page_for_job_msg_from_admin',
                type: 'POST',
                data: {
                    _token:"{{ csrf_token() }}", 
                    job_id:jobId,
                    staff_id:staffId,
                },    // the _token:token is for Laravel
                success: function(dataRetFromPHP) {
                    setTimeout(ReloadPageForJobMsg, 7500);
                    if (document.getElementById('msg_from_admin').value != dataRetFromPHP) {
                        document.getElementById('msg_from_admin').value = dataRetFromPHP;
                        document.getElementById('msg_from_admin').style.color = 'red';
                    } else {
                        document.getElementById('msg_from_admin').value = dataRetFromPHP;
                        document.getElementById('msg_from_admin').style.color = 'white';
                    }
                },
                error: function(err) {
                    setTimeout(ReloadPageForJobMsg, 7500);
                }
            });
        }

        function doSendMsgToAdmin() {
            msg = document.getElementById('msg_from_staff').value;
            if (msg.length > 0) {
                event.preventDefault();
                $.ajax({
                    url: '/job_combination_msg_to_admin',
                    type: 'POST',
                    data: {
                        _token:"{{ csrf_token() }}", 
                        job_id:jobId,
                        staff_id:staffId,
                        msg:msg
                    },    // the _token:token is for Laravel
                    success: function(dataRetFromPHP) {
                        window.location = './assistant_job_selected?id='+jobId+'&msgToAdminOK=true';
                    },
                    error: function(err) {
                        window.location = './assistant_job_selected?id='+jobId+'&msgToAdminOK=false';
                    }
                });
            }
        }

        function doLogout() {
            if(todaysWorkingHoursSaved == 'false') {
                if(!confirm('You haven\'t entered Today\'s Working Hours yet!\r\n\r\nContinue to logout without entering Today\'s Working Hours?')) {
                } else {
                    event.preventDefault(); 
                    document.getElementById('form_assistant_logout').submit();
                }
            } else {
                event.preventDefault(); 
                document.getElementById('form_assistant_logout').submit();
            }
        }

        function doCompleteThisJob() {
            if(todaysWorkingHoursSaved == 'false') {
                alert('Please enter your Today\'s Working Hours first.');
            } else {
                if (document.getElementById('signatureForTask_shadow').toDataURL() == document.getElementById('signatureForTask').toDataURL()) {
                    alert('To finish the inspection, you have to sign first.');
                } else {
                    let taskReport = document.getElementById('task_report').value;
                    // role = {!!json_encode($role)!!}
                    // if (role == 'SUPERINTENDENT') {
                    //     promptMsg = "You have to update the Amount Left value of each material before you finish the inspection.\r\n\r\nAre you sure to finish the inspection?";
                    // } else {
                        promptMsg = "Continue to finish the inspection?\r\n\r\nThe information you entered cannot be changed once you finish it!";
                    // }
                    if (taskReport == '') {
                        promptMsg = "The inspection report is empty.\r\n" + promptMsg;
                    }
                    if(!confirm(promptMsg)) {
                        //event.preventDefault();
                    } else {
                        var canvas = document.getElementById("signatureForTask");
                        var dataURL = canvas.toDataURL("image/png");
                        // document.getElementById("saveSignature").src = dataURL;
                        $.ajax({
                            url: '/job_assistants_complete',
                            type: 'POST',
                            data: {
                                _token:"{{ csrf_token() }}", 
                                job_id: jobId,
                                staff_id: staffId,
                                signatrue_data: dataURL,
                                inspection_report: taskReport,
                            },    // the _token:token is for Laravel
                            success: function(dataRetFromPHP) {
                                alert('Task is completed successfully.');
                                window.location = './assistant_home_page';
                            },
                            error: function(err) {
                                alert('Failed to finish the inspection.\r\nPlease tyr again.');
                                window.location = './assistant_job_selected?id='+jobId+'&jobCompleteOK=false';
                            }
                        });
                        // document.getElementById('sig').setAttribute('style','display:none');
                    }
                }
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
                            window.location = './assistant_job_selected?id='+jobId;
                        },
                        error: function(err) {
                            alert('Today\'s working hours cannot be saved.');
                        }
                    });
                }
            }
        }
    </script>
</body>

</html>