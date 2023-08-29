<?php
	use App\Models\Material;
	use App\Models\JobDispatch;
	use App\Models\Job;
	use App\Models\Staff;

    $job_id             = "";
    $job_lead_num       = 0;
    $job_inspecor_num   = 0;

    if (isset($_GET['jobId'])) {
        $job_id = $_GET['jobId'];
        $job = Job::where('id', $job_id)->first();
    } else {
        Log::Info('Failed get the input jobId parameter while doing job_dispatch_by_adding');
    }
    $assistants = Staff::where('status', '<>', 'DELETED')->where('role', '<>', 'ADMINISTRATOR')->orderBy('f_name', 'asc')->get();

    $associations = JobDispatch::where('jobdsp_job_id', $job_id)->where('jobdsp_status', '<>', 'CANCELED')->where('jobdsp_status', '<>', 'DELETED')->get();
    foreach($associations as $association) {
        $dispatched_staff = Staff::where('id', $association->jobdsp_staff_id)->first();
        if ($dispatched_staff->role == 'SUPERINTENDENT') {
            $job_lead_num++;
        }
        if ($dispatched_staff->role == 'INSPECTOR') {
            $job_inspecor_num++;
        }
    } 
    // if (isset($_GET['staffRemoveOK'])) {
    //     $staffRemoveResult = $_GET['staffRemoveOK'];
    //     $staff_id = $_GET['staffId'];
    //     if ($staffRemoveResult=='true' && $staff_id) {
    //         $staff = Staff::where('id', $staff_id)->first();
    //         $msg_to_show = "Staff ".$staff->f_name." ".$staff->l_name." is successfully removed from job ".$job_id;
    //         Log::Info($msg_to_show);
    //     }
    // }
?>

@extends('layouts.home_page_base')
<style>
.my-text-height {height:75%;}
</style>

@section('goback')
	<a class="text-primary" href="{{route('job_combination_main', ['jobId' => $job_id])}}" style="margin-right: 10px;">Back</a>
@show

@section('function_page')
    <div>
        <div class="row m-4">
            <div>
                <h2 class="text-muted pl-2">Dispatch the following Task to the desired Assistant:</h2>
            </div>
        </div>
        <div class="row m-4">
            <div class="col-6">
                <!-- Available Tasks Section -->
                <div class="container">
                    <div class="row">
                        <div class="col bg-info text-white"><h5 class="mt-1">Tasks:&nbsp;</h5></div>
                    </div>
                    <div class="row my-2">
                        <div class="col">
                            <div class="row text-white" style="max-height: 400px; background-color:grey; font-weight:bold !important;">
                                <div class="col-2">Task Name</div>
                                <div class="col-4">Task Type</div>
                                <div class="col-2">Crew#</div>
                                <div class="col-4">Task Address</div>
                            </div>
                            <?php 
                                $outContents = "<div class=\"row\" id=\"j_".$job->id."\" style=\"background-color:pink\">";
                                $outContents .= "<div class=\"col-2 mt-1\" style=\"cursor:default\">".$job->job_name."</div>";
                                $outContents .= "<div class=\"col-4 mt-1\" style=\"cursor:default\">".$job->job_type."</div>";
                                $outContents .= "<div class=\"col-2 mt-1\" style=\"cursor:default\">".$job->job_total_active_assistants."</div>";
                                $outContents .= "<div class=\"col-4 mt-1\" style=\"cursor:default\">".$job->job_address."</div>";
                                $outContents .= "</div>";
                                echo $outContents;
                            ?>
                        </div>
                    </div>
                    <!--div class="row d-flex justify-content-center">
                        <button class="btn-success m-3 rounded">Add Material</button>
                    </div-->
                </div>
            </div>
            <div class="col-1" style="position: relative;">
                <div style="position: absolute; top: 50%; -ms-transform: translateY(-50%); transform: translateY(-50%);">
                    <button class="btn btn-success align-items-center" onclick="doJobDispatch({{$job_id}})">Dispatch</button>
                </div>
            </div>
            <div class="col-5">
                <!-- Available Asststants Section -->
                <div class="container">
                    <div class="row">
                        <div class="col bg-info text-white"><h5 class="mt-1">Assistants:&nbsp;</h5></div>
                    </div>
                    <div class="row my-2">
                        <div class="col">
                            <div class="row text-white" style="max-height: 400px; background-color:grey; font-weight:bold !important;">
                                <div class="col-4">First Name</div>
                                <div class="col-4">Last Name</div>
                                <div class="col-4">Role</div>
                            </div>
                            <?php 
                                $listed_items = 0;
                                foreach ($assistants as $assistant) {
                                    // ADMINISTRATOR can dispatch any staff; SUPERINTENDENT can dispatch any staff but other SUPERINTENDENT
                                    if (($assistant->status == 'DELETED') || (($assistant->role == 'SUPERINTENDENT') && ($assistant->id != Auth::user()->id) && (Auth::user()->role != 'ADMINISTRATOR'))) {
                                        continue;
                                    }

                                    // Don't put any SUPERINTENDENT to the list anymore as there's 1 exists
                                    if ($job_lead_num > 0) {
                                        if ($assistant->role == 'SUPERINTENDENT') {
                                            continue;
                                        }
                                    }

                                    // Don't put any INSPECTOR to the list anymore as there's 1 exists
                                    if ($job_inspecor_num > 0) {
                                        if ($assistant->role == 'INSPECTOR') {
                                            continue;
                                        }
                                    }

                                    $dispatchExisting = JobDispatch::where('jobdsp_job_id', $job_id)->where('jobdsp_staff_id', $assistant->id)->where('jobdsp_status', '<>', 'COMPLETED')->where('jobdsp_status', '<>', 'CANCELED')->where('jobdsp_status', '<>', 'DELETED')->first();
                                    if ($dispatchExisting) {
                                        continue;
                                    } else {
                                        $listed_items++;
                                        if ($listed_items % 2) {
                                            $bg_color = "Lavender";
                                        } else {
                                            $bg_color = "PaleGreen";
                                        }
                                        if ($assistant->role == 'SUPERINTENDENT') {
                                            $outContents = "<div class=\"row text-danger\" id=\"s_".$assistant->id."\" onclick=\"StaffSelected(this.id)\" ondblclick=\"EditStaff(this.id)\" style=\"background-color:".$bg_color."\">";
                                        } else {
                                            $outContents = "<div class=\"row\" id=\"s_".$assistant->id."\" onclick=\"StaffSelected(this.id)\" ondblclick=\"EditStaff(this.id)\" style=\"background-color:".$bg_color."\">";
                                        }
                                                $outContents .= "<div class=\"col-4\" style=\"cursor:default\">".$assistant->f_name."</div>";
                                        $outContents .= "<div class=\"col-4\" style=\"cursor:default\">".$assistant->l_name."</div>";
                                        $outContents .= "<div class=\"col-4\" style=\"cursor:default\">".$assistant->role."</div>";
                                        $outContents .= "</div>";
                                        echo $outContents;
                                    }
                                }
                            ?>
                        </div>
                    </div>
                    <!--div class="row d-flex justify-content-center">
                        <button class="btn-success m-3 rounded">Add Assistant</button>
                    </div-->
                </div>
            </div>
        </div>
    </div>
    
    <script>
        var jobId           = {!!json_encode($job_id)!!};
        var staffId         = "";
        var oldInputJobId   = "";
        var oldInputStaffId = "";
        var oldJobBgColor   = "";
        var oldStaffBgColor = "";

        function StaffSelected(inputId) {
            // prepare the staff data for the ajax post function
            staffId = inputId.substring(2, inputId.length);

            if (oldInputStaffId != "") {
                // restore old selected staff element's background color
                document.getElementById(oldInputStaffId).style.backgroundColor = oldStaffBgColor;
            }

            // save the new selected staff element's background color
            oldInputStaffId = inputId;
            oldStaffBgColor = document.getElementById(inputId).style.backgroundColor;

            // set new background color to the new selected staff element
            document.getElementById(inputId).style.backgroundColor = 'pink';
        }

        function doJobDispatch(inputId) {
            if (jobId == "" || staffId == "") {
                alert('Please select Task and Assistant first befor you do the dispatch!')
            } else {
                $.ajax({
                    url: '/job_dispatch_to_staff',
                    type: 'POST',
                    data: {
                        _token:"{{ csrf_token() }}", 
                        job_id:jobId,
                        staff_id:staffId,
                    },    // the _token:token is for Laravel
                    success: function(dataRetFromPHP) {
                        alert('Task dispatched successfully.')
                        window.location = './job_combination_main?jobId='+inputId;
                    },
                    error: function(err) {
                        alert('Failed to dispatch the Task.\r\nPlease try again!')
                        //window.location = './job_dispatch?jobDispatchOK=false';
                    }
                });
            }
        }
    </script>
@endsection

