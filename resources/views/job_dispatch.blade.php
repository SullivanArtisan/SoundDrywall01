<?php
	use App\Models\Material;
	use App\Models\JobDispatch;
	use App\Models\Job;
	use App\Models\Staff;

    $jobs = Job::all()->where('job_assistants_complete', '=', '0')->where('job_assistants_complete', '<', 'job_total_active_assistants')->where('job_status', '<>', 'DELETED')->where('job_status', '<>', 'CANCELED');
    $assistants = Staff::where('role', 'ASSISTANT')->orwhere('role', 'SUBCONTRACTOR')->orwhere('role', 'SUPERINTENDENT')->where('status', '<>', 'DELETED')->orderBy('f_name', 'asc')->get();

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
	<a class="text-primary" href="{{route('home_page')}}" style="margin-right: 10px;">Back</a>
@show

@section('function_page')
    <div>
        <div class="row m-4">
            <div>
                <h2 class="text-muted pl-2">Dispatch a Task to an Assistant:</h2>
            </div>
        </div>
        <div class="row m-4">
            <div class="col-6">
                <!-- Available Tasks Section -->
                <div class="container">
                    <div class="row">
                        <div class="col bg-info text-white"><h5 class="mt-1">Available Tasks:&nbsp;</h5></div>
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
                            $listed_items = 0;
                            foreach ($jobs as $job) {
                                $listed_items++;
                                if ($listed_items % 2) {
                                    $bg_color = "Lavender";
                                } else {
                                    $bg_color = "PaleGreen";
                                }
                                $outContents = "<div class=\"row\" id=\"j_".$job->id."\" onclick=\"JobSelected(this.id)\" ondblclick=\"EditJob(this.id)\" style=\"background-color:".$bg_color."\">";
                                $outContents .= "<div class=\"col-2 mt-1\" style=\"cursor:default\">".$job->job_name."</div>";
                                $outContents .= "<div class=\"col-4 mt-1\" style=\"cursor:default\">".$job->job_type."</div>";
                                $outContents .= "<div class=\"col-2 mt-1\" style=\"cursor:default\">".$job->job_total_active_assistants."</div>";
                                $outContents .= "<div class=\"col-4 mt-1\" style=\"cursor:default\">".$job->job_address."</div>";
                                $outContents .= "</div>";
                                echo $outContents;
                            }
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
                    <button class="btn btn-success align-items-center" onclick="doJobDispatch()">Dispatch</button>
                </div>
            </div>
            <div class="col-5">
                <!-- Available Asststants Section -->
                <div class="container">
                    <div class="row">
                        <div class="col bg-info text-white"><h5 class="mt-1">Available Staffs:&nbsp;</h5></div>
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
                                if ($assistant->status == 'DELETED') {
                                    continue;
                                }

                                $staff_origin = Staff::where('id', $assistant->jobdsp_staff_id)->first();
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
        var jobId           = "";
        var staffId         = "";
        var oldInputJobId   = "";
        var oldInputStaffId = "";
        var oldJobBgColor   = "";
        var oldStaffBgColor = "";

        function JobSelected(inputId) {
            // prepare the task data for the ajax post function
            jobId = inputId.substring(2, inputId.length);

            if (oldInputJobId != "") {
                // restore old selected task element's background color
                document.getElementById(oldInputJobId).style.backgroundColor = oldJobBgColor;
            }

            // save the new selected task element's background color
            oldInputJobId = inputId;
            oldJobBgColor = document.getElementById(inputId).style.backgroundColor;

            // set new background color to the new selected task element
            document.getElementById(inputId).style.backgroundColor = 'pink';
        }

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
                        window.location = './job_dispatch';
                    },
                    error: function(err) {
                        alert('Failed to dispatch the task.\r\nPlease try again!')
                        //window.location = './job_dispatch?jobDispatchOK=false';
                    }
                });
            }
        }

        function EditJob(inputId) {
            // jobId = inputId.substring(2, inputId.length);
            // window.location = './job_selected?jobId='+jobId;
        }

        function EditStaff(inputId) {
            // staffId = inputId.substring(2, inputId.length);
            // window.location = './staff_selected?id='+staffId;
        }
    </script>
@endsection

