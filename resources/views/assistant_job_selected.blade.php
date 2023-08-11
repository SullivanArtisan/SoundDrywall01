<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>2020_Assistant_Main_01</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
                    Log::Info("JobDispatch object cannot be found for job ".$id);
                    url()->previous();
                } else {
                    if ($association->jobdsp_status == 'CREATED') {
                        $association->jobdsp_status = 'RECEIVED';

                        $result = $association->save();
                        if (!$result) {
                            MyHelper::LogStaffActionResult(Auth::user()->id, 'Failed to updated JobDispatch status to RECEIVED OK for job '.$id.'.', '900');
                        } else {
                            MyHelper::LogStaffActionResult(Auth::user()->id, 'Updated JobDispatch status to RECEIVED OK for job '.$id.'.', '');

                            $total_received = 0;
                            $associations = JobDispatch::where('jobdsp_job_id', $id)->get();
                            foreach($associations as $asso) {
                                if ($asso->jobdsp_status == 'RECEIVED') {
                                    $total_received++;
                                }
                            }

                            if (strstr($job->job_status, 'COMPLETED')) {
                                // If anybody associated with that job had completed it, keep that ?/? COMPLETED status
                            } else {
                                $job->job_status = $total_received.'/'.$job->job_total_assistants.' RECEIVED';
                                $result = $job->save();
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
                    Log::Info("Project object cannot be found for job ".$id);
                }
                $client  = Client::where('id', $project->proj_cstmr_id)->first();
                if (!$client) {
                    Log::Info("Client object cannot be found for job ".$id);
                } else {
                    $client_name = $client->clnt_name;
                }
                $materials  = Material::where('mtrl_job_id', $id)->where('mtrl_status', '<>', 'DELETED')->where('mtrl_status', '<>', 'CANCELED')->orderBy('mtrl_type')->get();
            } else {
                $err_msg = "Job ".$id."'s object cannot be accessed while just entering the job's main page.";
                Log::Info($err_msg);
            }
        }
    ?>

    <div class="container pt-5 text-dark" style="background: var(--bs-btn-bg); background-color:beige;">
        <!-- Header Section -->
        <div class="row">
            <div class="col-md-9 my-2" style="">
                <h1>Hi, <span style="font-family: 'Times New Roman';font-weight: bold;font-style: italic; color:brown !important">{{Auth::user()->f_name}} {{Auth::user()->l_name}}</span>!    Job {{$job->job_name}}'s Details:</h1>
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
                <form method="POST" action="{{ route('logout') }}" style="cursor: pointer">
                    @csrf
                    <a style="text-decoration:none;"  class="text-dark border rounded btn btn-dark" 
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        <span style="font-weight:bold !important; color:white">{{ __('Log Out') }}</span>
                    </a>
                </form>
            </div>
        </div>

        <!-- Jobs Section -->
        <div class="row" style="max-height: 400px;">
            <div class="col-3"><label class="col-form-label">Customer Name:&nbsp;</label></div>
            <div class="col-9"><input class="form-control mt-1 my-text-height" type="text" readonly id="clnt_name" name="clnt_name" value="{{$client_name}}"></div>
        </div>
        <div class="row" style="max-height: 400px;">
            <div class="col-3"><label class="col-form-label">Job Name:&nbsp;</label></div>
            <div class="col-9"><input class="form-control mt-1 my-text-height" type="text" readonly id="job_name" name="job_name" value="{{$job->job_name}}"></div>
        </div>
        <div class="row" style="max-height: 400px;">
            <div class="col-3"><label class="col-form-label">Job Type:&nbsp;</label></div>
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

        <!-- Footage Section -->
        <div class="row mt-2">
            <p>
            <button class="btn btn-info" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                Show / Hide Materials
            </button>
            </p>
            <div class="collapse" id="collapseExample">
                <div class="my-3">
                    <?php
                    // Title Line
                    $outContents = "<div class=\"container mw-100\">";
                    $outContents .= "<div class=\"row bg-info text-white fw-bold\">";
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
                            if (Auth::user()->role == 'SUPERINTENDENT')
                                $outContents .= "<a href=\"assistant_material_in_job_selected?id=$material->id\">";
                            $outContents .= $material->mtrl_name;
                            if (Auth::user()->role == 'SUPERINTENDENT')
                                $outContents .= "</a>";
                            $outContents .= "</div>";
                            $outContents .= "<div class=\"col-2\">";
                            if (Auth::user()->role == 'SUPERINTENDENT')
                                $outContents .= "<a href=\"assistant_material_in_job_selected?id=$material->id\">";
                                $outContents .= $material->mtrl_type;
                            if (Auth::user()->role == 'SUPERINTENDENT')
                                $outContents .= "</a>";
                            $outContents .= "</div>";
                            $outContents .= "<div class=\"col-2\">";
                            if (Auth::user()->role == 'SUPERINTENDENT')
                                $outContents .= "<a href=\"assistant_material_in_job_selected?id=$material->id\">";
                                $outContents .= $material->mtrl_model;
                            if (Auth::user()->role == 'SUPERINTENDENT')
                                $outContents .= "</a>";
                            $outContents .= "</div>";
                            $outContents .= "<div class=\"col-2\">";
                            if (Auth::user()->role == 'SUPERINTENDENT')
                                $outContents .= "<a href=\"assistant_material_in_job_selected?id=$material->id\">";
                                $outContents .= $material->mtrl_size;
                            if (Auth::user()->role == 'SUPERINTENDENT')
                                $outContents .= "</a>";
                            $outContents .= "</div>";
                            $outContents .= "<div class=\"col-2\">";
                            if (Auth::user()->role == 'SUPERINTENDENT')
                                $outContents .= "<a href=\"assistant_material_in_job_selected?id=$material->id\">";
                                $outContents .= $material->mtrl_amount;
                            if (Auth::user()->role == 'SUPERINTENDENT')
                                $outContents .= "</a>";
                            $outContents .= "</div>";
                            $outContents .= "<div class=\"col-2\">";
                            if (Auth::user()->role == 'SUPERINTENDENT')
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
        <div class="row text-dark" style="background-color:lightsteelblue;">
            <div class="col mt-2">
                <form method="post" action="{{url('job_combination_msg_to_admin')}}">
                    @csrf
                    <div class="row">
                        <div class="col m-1">
                            <div class="row font-weight-bold"><label class="col-form-label">Message From Administrator:&nbsp;</label></div>
                            <div class="row">
                                <textarea readonly class="form-control mt-1 my-text-height" style="background-color:silver;" type="text" row="10" id="msg_from_admin" name="msg_from_admin">{{$association->jobdsp_msg_from_admin}}</textarea>
                            </div>
                        </div>
                        <div class="col m-1">
                            <div class="row font-weight-bold"><label class="col-form-label">Message To  Administrator:&nbsp;</label></div>
                            <div class="row"><textarea class="form-control mt-1 my-text-height" type="text" row="10" id="msg_from_staff" name="msg_from_staff">{{$association->jobdsp_msg_from_staff}}</textarea></div>
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
        <div class="row mt-2">
        </div>
        <div class="row text-dark" style="background-color:lightpink;">
            <div class="col my-4 text-center" style="position: static; display: flex; justify-content: right;">
                <button class="btn m-2 text-white rounded" style="background-color:lightcoral;" onclick="return doCompleteThisJob();">Complete This Job</button>
            </div>
        </div>
    </div>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script>
        var msgToShow = {!!json_encode($msg_to_show)!!};
        var jobId = {!!json_encode($id)!!};
        var staffId = {!!json_encode($staff_id)!!};
        if (msgToShow.length > 0) {
            alert(msgToShow);
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

        function doCompleteThisJob() {
            role = {!!json_encode($role)!!}
            if (role == 'SUPERINTENDENT') {
                promptMsg = "You have to update the Amount Left value of each material before you complete this job.\r\n\r\nAre you sure to complete this job?";
            } else {
                promptMsg = "Are you sure to complete this job?";
            }
            if(!confirm(promptMsg)) {
                //event.preventDefault();
            } else {
                $.ajax({
                    url: '/job_assistants_complete',
                    type: 'POST',
                    data: {
                        _token:"{{ csrf_token() }}", 
                        job_id:jobId,
                        staff_id:staffId,
                    },    // the _token:token is for Laravel
                    success: function(dataRetFromPHP) {
                        alert('Job is completed successfully.')
                        window.location = './assistant_home_page';
                    },
                    error: function(err) {
                        alert('Failed to complete this job.\r\nPlease tyr again.')
                        window.location = './assistant_job_selected?id='+jobId+'&jobCompleteOK=false';
                    }
                });
            }
        }
    </script>
</body>

</html>