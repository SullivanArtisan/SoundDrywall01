<?php
	use App\Models\Material;
	use App\Models\JobDispatch;
	use App\Models\Job;
	use App\Models\Staff;

    if (isset($_GET['jobId'])) {
        $job_id = $_GET['jobId'];
        $from_project = 'false';
    } else if (isset($_GET['jobIdFromProj'])) {
        $job_id = $_GET['jobIdFromProj'];
        $from_project = 'true';
    }

	if ($job_id) {
        $job = Job::where('id', $job_id)->first();
        $materials = Material::all()->where('mtrl_job_id', $job_id)->where('mtrl_status', '<>', 'DELETED');
        $associations = JobDispatch::all()->where('jobdsp_job_id', $job_id)->where('jobdsp_status', '<>', 'DELETED')->where('jobdsp_status', '<>', 'CANCELED');
	} else {
        Log::Info('Staff '.Auth::user()->id.' failed to get the job ID parameter while entering the job_combination_main page');
    }

    $msg_to_show = "";
    if (isset($_GET['staffRemoveOK'])) {
        $staffRemoveResult = $_GET['staffRemoveOK'];
        $staff_id = $_GET['staffId'];
        if ($staffRemoveResult=='true' && $staff_id) {
            $staff = Staff::where('id', $staff_id)->first();
            $msg_to_show = "Staff ".$staff->f_name." ".$staff->l_name." is successfully removed from task ".$job_id;
            Log::Info($msg_to_show);
        }
    }
?>

@extends('layouts.home_page_base')
<style>
.my-text-height {height:75%;}
</style>

@section('goback')
    @if (isset($_GET['jobId']))
	<a class="text-primary" href="{{route('job_selected', ['jobId'=>$job_id])}}" style="margin-right: 10px;">Back</a>
    @else
	<a class="text-primary" href="{{route('job_selected', ['jobIdFromProj'=>$job_id])}}" style="margin-right: 10px;">Back</a>
    @endif
@show

@if (!$job_id) {
	@section('function_page')
		<div>
			<div class="row">
				<div class="col col-sm-auto">
					<h2 class="text-muted pl-2">Result of the Task Dispatch</h2>
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
					<h2 class="text-muted pl-2">Dispatch of Task <span style="font-family: 'Times New Roman';font-weight: bold;font-style: italic; color:black !important">{{$job->job_name}}</span>:</h2>
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
                        <div class="container">
                            <div class="row bg-info text-white">
                                <div class="col-3"><h5 class="mt-1">Current Materials:&nbsp;</h5></div>
                                <div class="col-9 pt-2 font-italic text-warning"><h6>(Double click a row to cancel that material)</h6></div>
                            </div>
                            <div class="row my-2">
                                <div class="col">
                                    <div class="row text-white" style="max-height: 400px; background-color:grey; font-weight:bold !important;">
                                        <div class="col">Name</div>
                                        <div class="col">Type</div>
                                        <div class="col">Size</div>
                                        <div class="col">Amount</div>
                                    </div>
                                    <?php 
                                        $listed_items = 0;
                                        foreach ($materials as $material) {
                                            $listed_items++;
                                            if ($listed_items % 2) {
                                                $bg_color = "Lavender";
                                            } else {
                                                $bg_color = "PaleGreen";
                                            }
                                            $outContents = "<div class=\"row\" id=\"m_".$material->id."\" ondblclick=\"RemoveThisMaterial(this.id,'".$material->mtrl_status."')\" style=\"background-color:".$bg_color."\">";
                                            $outContents .= "<div class=\"col mt-1\">".$material->mtrl_name."</div>";
                                            $outContents .= "<div class=\"col mt-1\">".$material->mtrl_type."</div>";
                                            $outContents .= "<div class=\"col mt-1\">".$material->mtrl_size."</div>";
                                            $outContents .= "<div class=\"col mt-1\">".$material->mtrl_amount_left."/".$material->mtrl_amount." ".strtolower($material->mtrl_amount_unit)."</div>";
                                            $outContents .= "</div>";
                                            echo $outContents;
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-center">
                                <button class="btn-success m-3 p-2 rounded" onclick="AddMaterial('{{$job->job_status}}')">Dispatch a Material to This Task</button>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="container">
                            <div class="row bg-info text-white">
                                <div class="col-3"><h5 class="mt-1">Current Staffs:&nbsp;</h5></div>
                                <div class="col-9 pt-2 font-italic text-warning"><h6>(Click a row to chat or cancel that staff)</h6></div>
                            </div>
                            <div class="row my-2">
                                <div class="col">
                                    <div class="row text-white" style="max-height: 400px; background-color:grey; font-weight:bold !important;">
                                        <div class="col">Name</div>
                                        <div class="col">Role</div>
                                        <div class="col">Hours</div>
                                    </div>
                                    <?php 
                                        $listed_items = 0;
                                        foreach ($associations as $association) {
                                            $staff_origin = Staff::where('id', $association->jobdsp_staff_id)->first();
                                            $listed_items++;
                                            if ($listed_items % 2) {
                                                $bg_color = "Lavender";
                                            } else {
                                                $bg_color = "PaleGreen";
                                            }
                                            $outContents = "<div class=\"row\" style=\"background-color:".$bg_color."\">";
                                            $outContents .= "<div class=\"col mt-1\">";
                                            if ($association->jobdsp_status == "COMPLETED") {
                                                $outContents .= "<span style=\"text-decoration: line-through;color: blue;\">";
                                                $outContents .= $staff_origin->f_name." ".$staff_origin->l_name."</span></div>";
                                            } else {
                                                if ($from_project == 'true') {
                                                    $outContents .= "<a href=\"job_combination_staff_selected?jobIdFromProj=".$association->jobdsp_job_id."&staffId=".$association->jobdsp_staff_id."\">";
                                                } else{
                                                    $outContents .= "<a href=\"job_combination_staff_selected?jobId=".$association->jobdsp_job_id."&staffId=".$association->jobdsp_staff_id."\">";
                                                }    
                                                $outContents .= $staff_origin->f_name." ".$staff_origin->l_name."</a></div>";
                                            }
                                            $outContents .= "<div class=\"col mt-1\">";
                                            if ($association->jobdsp_status == "COMPLETED") {
                                                $outContents .= "<span style=\"text-decoration: line-through;color: blue;\">";
                                                $outContents .= $staff_origin->role."</span></div>";
                                            } else {
                                                if ($from_project == 'true') {
                                                    $outContents .= "<a href=\"job_combination_staff_selected?jobIdFromProj=".$association->jobdsp_job_id."&staffId=".$association->jobdsp_staff_id."\">";
                                                } else{
                                                    $outContents .= "<a href=\"job_combination_staff_selected?jobId=".$association->jobdsp_job_id."&staffId=".$association->jobdsp_staff_id."\">";
                                                }    
                                                $outContents .= $staff_origin->role."</a></div>";
                                            }
                                            $outContents .= "<div class=\"col mt-1\">";
                                            if ($association->jobdsp_status == "COMPLETED") {
                                                $outContents .= "<span style=\"text-decoration: line-through;color: blue;\">";
                                                $outContents .= $association->jobdsp_workinghours_total."</span></div>";
                                            } else {
                                                if ($from_project == 'true') {
                                                    $outContents .= "<a href=\"job_combination_staff_selected?jobIdFromProj=".$association->jobdsp_job_id."&staffId=".$association->jobdsp_staff_id."\">";
                                                } else{
                                                    $outContents .= "<a href=\"job_combination_staff_selected?jobId=".$association->jobdsp_job_id."&staffId=".$association->jobdsp_staff_id."\">";
                                                }    
                                                $outContents .= $association->jobdsp_workinghours_total."</a></div>";
                                            }
                                            $outContents .= "</div>";
                                            echo $outContents;
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-center">
                                <button class="btn-success m-3 p-2 rounded" onclick="AddAssistant('{{$job->job_status}}')">Dispatch a Staff to This Task</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
		
		<script>
            var msgToShow = {!!json_encode($msg_to_show)!!};
            if (msgToShow.length > 0) {
                alert(msgToShow);
            }

			function AddMaterial(jobStatus) {
                if (jobStatus.includes("COMPLETED")) {
                    alert('You cannot add any new material, as the job has been COMPLETED.');
                } else {
                    var jobId = {!!json_encode($job_id)!!};
                    var fromProject = {!!json_encode($from_project)!!};

                    event.preventDefault();
                    if (fromProject == 'true') {
                        url   = './material_associate?jobIdFromProj='+jobId;
                    } else {
                        url   = './material_associate?jobId='+jobId;
                    }
                    window.location = url;
                }
			}

			function AddAssistant(jobStatus) {
                if (jobStatus.includes("COMPLETED")) {
                    alert('You cannot add any new assistant, as the task has been COMPLETED.');
                } else {
                    jobId           = {!!json_encode($job_id)!!};
                    fromProject     = {!!json_encode($from_project)!!};

                    event.preventDefault();
                    if (fromProject == 'true') {
                        url   = './job_dispatch_by_adding?jobIdFromProj='+jobId;
                    } else {
                        url   = './job_dispatch_by_adding?jobId='+jobId;
                    }
                    window.location = url;
                }
			}

            function RemoveThisMaterial(inputId, mtrlStatus) {
                if ('COMPLETED' == mtrlStatus) {
                    alert('You cannot cancel the dispatch of this material, as the task has been COMPLETED.');
                } else {
                    mtrlId = inputId.substring(2, inputId.length);
                    if(!confirm("Continue to remove this material from this task?")) {
                        event.preventDefault();
                    } else {
                        var jobId   = {!!json_encode($job_id)!!};
                        var fromProject = {!!json_encode($from_project)!!};

                        $.ajax({
                            url: '/job_combination_material_remove',
                            type: 'POST',
                            data: {
                                _token:"{{ csrf_token() }}", 
                                job_id:jobId,
                                material_id:mtrlId
                            },    // the _token:token is for Laravel
                            success: function(dataRetFromPHP) {
                                if (fromProject == 'true') {
                                    url   = './job_combination_main?jobIdFromProj='+jobId;
                                } else {
                                    url   = './job_combination_main?jobId='+jobId;
                                }
                                window.location = url;
                            },
                            error: function(err) {
                                if (fromProject == 'true') {
                                    url   = './job_combination_main?jobIdFromProj='+jobId;
                                } else {
                                    url   = './job_combination_main?jobId='+jobId;
                                }
                                window.location = url;
                            }
                        });
                    }
                }
            }
        </script>
	@endsection
}
@endif

