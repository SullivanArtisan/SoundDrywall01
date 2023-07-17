<?php
	use App\Models\Material;
	use App\Models\JobDispatch;
	use App\Models\Job;
	use App\Models\Staff;

    $job_id = $_GET['jobId'];
	if ($job_id) {
        $job = Job::where('id', $job_id)->first();
        $materials = Material::all()->where('mtrl_job_id', $job_id)->where('mtrl_status', '<>', 'DELETED');
        $associations = JobDispatch::all()->where('jobdsp_job_id', $job_id);
	}

    $msg_to_show = "";
    if (isset($_GET['staffRemoveOK'])) {
        $staffRemoveResult = $_GET['staffRemoveOK'];
        $staff_id = $_GET['staffId'];
        if ($staffRemoveResult=='true' && $staff_id) {
            $staff = Staff::where('id', $staff_id)->first();
            $msg_to_show = "Staff ".$staff->f_name." ".$staff->l_name." is successfully removed from job ".$job_id;
            Log::Info($msg_to_show);
        }
    }
?>

@extends('layouts.home_page_base')
<style>
.my-text-height {height:75%;}
</style>

@section('goback')
	<a class="text-primary" href="{{route('job_selected', ['jobId'=>$job_id])}}" style="margin-right: 10px;">Back</a>
@show

@if (!$job_id) {
	@section('function_page')
		<div>
			<div class="row">
				<div class="col col-sm-auto">
					<h2 class="text-muted pl-2">Result of the Job Combination</h2>
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
					<h2 class="text-muted pl-2">Job Combination for <span style="font-family: 'Times New Roman';font-weight: bold;font-style: italic; color:black !important">{{$job->job_name}}</span>:</h2>
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
                            <div class="row">
                                <div class="col bg-info text-white"><h5 class="mt-1">Materials:&nbsp;</h5></div>
                            </div>
                            <div class="row my-2">
                                <div class="col">
                                    <div class="row text-white" style="max-height: 400px; background-color:grey; font-weight:bold !important;">
                                        <div class="col">Type</div>
                                        <div class="col">Name</div>
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
                                            $outContents = "<div class=\"row\" style=\"background-color:".$bg_color."\">";
                                            $outContents .= "<div class=\"col mt-1\">".$material->mtrl_type."</div>";
                                            $outContents .= "<div class=\"col mt-1\">".$material->mtrl_name."</div>";
                                            $outContents .= "</div>";
                                            echo $outContents;
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-center">
                                <button class="btn-success m-3 rounded" onclick="AddMaterial()">Add a New Material to This Job</button>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="container">
                            <div class="row">
                                <div class="col bg-info text-white"><h5 class="mt-1">Assistants:&nbsp;</h5></div>
                            </div>
                            <div class="row my-2">
                                <div class="col">
                                    <div class="row text-white" style="max-height: 400px; background-color:grey; font-weight:bold !important;">
                                        <div class="col-4">First Name</div>
                                        <div class="col-8">Last Name</div>
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
                                            $outContents .= "<div class=\"col-4 mt-1\">";
                                            $outContents .= "<a href=\"job_combination_staff_selected?jobId=".$association->jobdsp_job_id."&staffId=".$association->jobdsp_staff_id."\">";
                                            $outContents .= $staff_origin->f_name."</a></div>";
                                            $outContents .= "<div class=\"col-8 mt-1\">";
                                            $outContents .= "<a href=\"job_combination_staff_selected?jobId=".$association->jobdsp_job_id."&staffId=".$association->jobdsp_staff_id."\">";
                                            $outContents .= $staff_origin->l_name."</a></div>";
                                            $outContents .= "</div>";
                                            echo $outContents;
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-center">
                                <button class="btn-success m-3 rounded" onclick="AddAssistant()">Add Another Assistant to This Job</button>
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

			function AddMaterial() {
                jobId = {!!json_encode($job_id)!!};
                event.preventDefault();
                window.location = './material_add?jobId='+jobId;
			}

			function AddAssistant() {
                jobId = {!!json_encode($job_id)!!};
                event.preventDefault();
                window.location = './job_dispatch_by_adding?jobId='+jobId;
			}
		</script>
	@endsection
}
@endif

