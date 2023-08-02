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
        use Illuminate\Support\Facades\Log;
        use Illuminate\Support\Facades\Auth;

        $material_name = "";
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $staff_id = Auth::user()->id;
            $msg_to_show = "";
            $material = Material::where('id', $id)->first();
            if ($material) {
                $material_name = $material->mtrl_name;
                $association = JobDispatch::where('jobdsp_job_id', $material->mtrl_job_id)->where('jobdsp_staff_id', $staff_id)->first();

                if (isset($_GET['msgToAdminOK'])) {
                    $result = $_GET['msgToAdminOK'];
                    if ($result == 'true'){
                        $msg_to_show = 'Assistant '.Auth::user()->f_name.' '.Auth::user()->l_name.' sent a message to administrator successfully.';
                        Log::Info($msg_to_show);
                    }
                }
            } else {
                $err_msg = "Material ".$id."'s object cannot be accessed while just entering the material's main page.";
                Log::Info($err_msg);
            }

            // if ($job) {

            //     $project = Project::where('id', $job->job_proj_id)->first();
            //     if (!$project) {
            //         Log::Info("Project object cannot be found for job ".$id);
            //     }
            //     $client  = Client::where('id', $project->proj_cstmr_id)->first();
            //     if (!$client) {
            //         Log::Info("Client object cannot be found for job ".$id);
            //     } else {
            //         $client_name = $client->clnt_name;
            //     }
            //     $materials  = Material::where('mtrl_job_id', $id)->where('mtrl_status', '<>', 'DELETED')->where('mtrl_status', '<>', 'CANCELED')->orderBy('mtrl_type')->get();
            // } else {
            //     $err_msg = "Job ".$id."'s object cannot be accessed while just entering the job's main page.";
            //     Log::Info($err_msg);
            // }
        }
    ?>

    <div class="container pt-5 text-dark" style="background: var(--bs-btn-bg); background-color:beige;">
        <!-- Header Section -->
        <div class="row">
            <div class="col-md-9 my-2" style="">
                <h1>Hi, <span style="font-family: 'Times New Roman';font-weight: bold;font-style: italic; color:brown !important">{{Auth::user()->f_name}} {{Auth::user()->l_name}}</span>!    Material {{$material_name}}'s Details:</h1>
            </div>
            <div class="col-md-1 my-4">
                        <button class="btn btn-secondary text-center" type="button">
                            <a style="text-decoration:none;"  class="text-white" 
                                href="{{route('assistant_job_selected', ['id'=>$material->mtrl_job_id])}}">
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

        <!-- Material form Section -->
        <div class="row my-2">
            <div class="col">
                <form method="post" action="{{url('material_update')}}">
                    @csrf
                    <div class="row" style="max-height: 400px;">
                        <div class="col-3"><label class="col-form-label">Material Name:&nbsp;</label></div>
                        <div class="col-9"><input class="form-control mt-1 my-text-height" type="text" readonly id="mtrl_name" name="mtrl_name" value="{{$material->mtrl_name}}"></div>
                    </div>
                    <div class="row" style="max-height: 400px;">
                        <div class="col-3"><label class="col-form-label">Type:&nbsp;</label></div>
                        <div class="col-9"><input class="form-control mt-1 my-text-height" type="text" readonly id="mtrl_type" name="mtrl_type" value="{{$material->mtrl_type}}"></div>
                    </div>
                    <div class="row" style="max-height: 400px;">
                        <div class="col-3"><label class="col-form-label">Item Size:&nbsp;</label></div>
                        <div class="col-9"><input class="form-control mt-1 my-text-height" type="text" readonly id="mtrl_size" name="mtrl_size" value="{{$material->mtrl_size}}"></div>
                    </div>
                    <div class="row" style="max-height: 400px;">
                        <div class="col-3"><label class="col-form-label">Size Unit:&nbsp;</label></div>
                        <div class="col-9"><input class="form-control mt-1 my-text-height" type="text" readonly id="mtrl_size_unit" name="mtrl_size_unit" value="{{$material->mtrl_size_unit}}"></div>
                    </div>
                    <div class="row" style="max-height: 400px;">
                        <div class="col-3"><label class="col-form-label">Total Amount:&nbsp;</label></div>
                        <div class="col-9"><input class="form-control mt-1 my-text-height" type="text" readonly id="mtrl_amount" name="mtrl_amount" value="{{$material->mtrl_amount}}"></div>
                    </div>
                    <div class="row" style="max-height: 400px;">
                        <div class="col-3"><label class="col-form-label">Amount Left:&nbsp;</label></div>
                        <div class="col-9"><input class="form-control mt-1 my-text-height" type="text" id="mtrl_amount_left" name="mtrl_amount_left" value="{{$material->mtrl_amount_left}}"></div>
                    </div>
                    <div class="row" style="max-height: 400px;">
                        <div class="col-3"><label class="col-form-label">Amount Unit:&nbsp;</label></div>
                        <div class="col-9"><input class="form-control mt-1 my-text-height" type="text" readonly id="mtrl_amount_unit" name="mtrl_amount_unit" value="{{$material->mtrl_amount_unit}}"></div>
                    </div>
                    <div class="row" style="max-height: 400px;">
                        <div class="col-3"><label class="col-form-label">Provider:&nbsp;</label></div>
                        <div class="col-9"><input class="form-control mt-1 my-text-height" type="text" readonly id="mtrl_source" name="mtrl_source" value="{{$material->mtrl_source}}"></div>
                    </div>
                    <div class="row" style="max-height: 400px;">
                        <div class="col-3"><label class="col-form-label">Shipped by:&nbsp;</label></div>
                        <div class="col-9"><input class="form-control mt-1 my-text-height" type="text" readonly id="mtrl_shipped_by" name="mtrl_shipped_by" value="{{$material->mtrl_shipped_by}}"></div>
                    </div>
                    <div class="row" style="max-height: 400px;">
                        <div class="col-3"><label class="col-form-label">Model/Description:&nbsp;</label></div>
                        <div class="col-9"><input class="form-control mt-1 my-text-height" type="text" readonly id="mtrl_model" name="mtrl_model" value="{{$material->mtrl_model}}"></div>
                    </div>
                    <div class="row" style="max-height: 400px;">
                        <div class="col-3"><label class="col-form-label">Notes:&nbsp;</label></div>
                        <div class="col-9"><input class="form-control mt-1 my-text-height" type="text" id="mtrl_notes" name="mtrl_notes" value="{{$material->mtrl_notes}}"></div>
                    </div>
                    <div class="row" style="max-height: 400px;">
                        <div class="col-3"><label class="col-form-label">&nbsp;</label></div>
                        <div class="col-9"><input class="form-control mt-1 my-text-height" type="hidden" id="mtrl_id" name="mtrl_id" value="{{$material->id}}"></div>
                    </div>
                    <div class="row my-3">
                        <div class="w-25"></div>
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <button class="btn btn-warning mx-4" type="submit">Update</button>
                                </div>
                                <div class="col">
                                    <button class="btn btn-secondary mx-3" type="button"><a href="{{route('assistant_job_selected', ['id'=>$material->mtrl_job_id])}}" class="text-white text-decoration-none">Cancel</a></button>
                                </div>
                            </div>
                        </div>
                        <div class="col"></div>
                    </div>
                </form>
            </div>
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
            if(!confirm("Are you sure to complete this job?")) {
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