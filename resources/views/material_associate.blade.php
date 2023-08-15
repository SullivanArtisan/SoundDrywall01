<?php
	use App\Models\Material;
	use App\Models\JobDispatch;
	use App\Models\Job;

    $job_id = "";
    if (isset($_GET['jobId'])) {
        $job_id = $_GET['jobId'];
        $job = Job::where('id', $job_id)->first();
    } else {
        Log::Info('Failed get the input jobId parameter while doing job_dispatch_by_adding');
    }
    $materials = Material::where('mtrl_status', '<>', 'DELETED')->where('mtrl_job_id', '0')->orderBy('mtrl_name', 'asc')->get();
    $jobs = Job::all()->where('job_assistants_complete', '=', '0')->where('job_assistants_complete', '<', 'job_total_active_assistants')->where('job_status', '<>', 'DELETED')->where('job_status', '<>', 'CANCELED');
?>

@extends('layouts.home_page_base')
<style>
.my-text-height {height:75%;}
</style>

@section('goback')
    @if ($job_id == "")
	    <a class="text-primary" href="{{route('home_page')}}" style="margin-right: 10px;">Back</a>
    @else
        <a class="text-primary" href="{{route('job_combination_main', ['jobId'=>$job_id])}}" style="margin-right: 10px;">Back</a>
    @endif
@show

@section('function_page')
    <div>
        <div class="row m-4">
            <div>
                <h2 class="text-muted pl-2">Dispatch Material To a Task:</h2>
            </div>
        </div>
        <div class="row m-4">
            <div class="col-5">
                <!-- Available Materials Section -->
                <div class="container">
                    <div class="row">
                        <div class="col bg-info text-white"><h5 class="mt-1">Available Materials:&nbsp;</h5></div>
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
                                $outContents = "<div class=\"row\" id=\"m_".$material->id."\" onclick=\"MaterialSelected(this.id)\" ondblclick=\"EditMaterial(this.id)\" style=\"background-color:".$bg_color."\">";
                                $outContents .= "<div class=\"col\" style=\"cursor:default\">".$material->mtrl_name."</div>";
                                $outContents .= "<div class=\"col\" style=\"cursor:default\">".$material->mtrl_type."</div>";
                                $outContents .= "<div class=\"col\" style=\"cursor:default\">".$material->mtrl_size."</div>";
                                $outContents .= "<div class=\"col\" style=\"cursor:default\">".intval($material->mtrl_amount_left)."/".intval($material->mtrl_amount)."</div>";
                                // $job = Job::where('id', $material->mtrl_job_id)->first();
                                // if ($job) {
                                //     $outContents .= "<div class=\"col-2\" style=\"cursor:default\">".$job->job_name."</div>";
                                // } else {
                                //     $outContents .= "<div class=\"col-2\" style=\"cursor:default\"></div>";
                                // }
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
            <div class="col-1" style="position: relative;">
                <div style="position: absolute; top: 50%; -ms-transform: translateY(-50%); transform: translateY(-50%);">
                    <button class="btn btn-success align-items-center" onclick="doMtrlAssociate()">Dispatch</button>
                </div>
            </div>
            <div class="col-6">
                <!-- Available Tasks Section -->
                <div class="container">
                    <div class="row">
                        <div class="col bg-info text-white"><h5 class="mt-1">Available Tasks:&nbsp;</h5></div>
                    </div>
                    <div class="row my-2">
                    <div class="col">
                        <div class="row text-white" style="max-height: 400px; background-color:grey; font-weight:bold !important;">
                            <div class="col">Task Name</div>
                            <div class="col">Task Type</div>
                            <div class="col">Material#</div>
                            <div class="col">Task Address</div>
                        </div>
                        <?php 
                            $listed_items = 0;
                            if ($job_id == "") {

                            foreach ($jobs as $job) {
                                    $listed_items++;
                                    if ($listed_items % 2) {
                                        $bg_color = "Lavender";
                                    } else {
                                        $bg_color = "PaleGreen";
                                    }
                                    $outContents = "<div class=\"row\" id=\"j_".$job->id."\" onclick=\"JobSelected(this.id)\" ondblclick=\"EditJob(this.id)\" style=\"background-color:".$bg_color."\">";
                                    $outContents .= "<div class=\"col mt-1\" style=\"cursor:default\">".$job->job_name."</div>";
                                    $outContents .= "<div class=\"col mt-1\" style=\"cursor:default\">".$job->job_type."</div>";
                                    $outContents .= "<div class=\"col mt-1\" style=\"cursor:default\">".$job->job_total_active_materials."</div>";
                                    $outContents .= "<div class=\"col mt-1\" style=\"cursor:default\">".$job->job_address.", ".$job->job_city."</div>";
                                    $outContents .= "</div>";
                                    echo $outContents;
                                }
                            } else {
                                $outContents = "<div class=\"row\" id=\"j_".$job->id."\" style=\"background-color:pink\">";
                                $outContents .= "<div class=\"col mt-1\" style=\"cursor:default\">".$job->job_name."</div>";
                                $outContents .= "<div class=\"col mt-1\" style=\"cursor:default\">".$job->job_type."</div>";
                                $outContents .= "<div class=\"col mt-1\" style=\"cursor:default\">".$job->job_total_active_materials."</div>";
                                $outContents .= "<div class=\"col mt-1\" style=\"cursor:default\">".$job->job_address.", ".$job->job_city."</div>";
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
        </div>
    </div>
    
    <script>
        var jobId           = "";
        var mtrlId         = "";
        var oldInputJobId   = "";
        var oldInputMtrlId = "";
        var oldJobBgColor   = "";
        var oldMtrlBgColor = "";

        function JobSelected(inputId) {
            // prepare the job data for the ajax post function
            jobId = inputId.substring(2, inputId.length);

            if (oldInputJobId != "") {
                // restore old selected job element's background color
                document.getElementById(oldInputJobId).style.backgroundColor = oldJobBgColor;
            }

            // save the new selected task element's background color
            oldInputJobId = inputId;
            oldJobBgColor = document.getElementById(inputId).style.backgroundColor;

            // set new background color to the new selected task element
            document.getElementById(inputId).style.backgroundColor = 'pink';
        }

        function MaterialSelected(inputId) {
            // prepare the mtrl data for the ajax post function
            mtrlId = inputId.substring(2, inputId.length);

            if (oldInputMtrlId != "") {
                // restore old selected mtrl element's background color
                document.getElementById(oldInputMtrlId).style.backgroundColor = oldMtrlBgColor;
            }

            // save the new selected mtrl element's background color
            oldInputMtrlId = inputId;
            oldMtrlBgColor = document.getElementById(inputId).style.backgroundColor;

            // set new background color to the new selected mtrl element
            document.getElementById(inputId).style.backgroundColor = 'pink';
        }

        function doMtrlAssociate(inputId) {
            if (jobId == "") {
                jobId = {!!json_encode($job_id)!!};
            }
            if (jobId == "" || mtrlId == "") {
                alert('Please select Material and Task first befor you do the dispatch!')
            } else {
                $.ajax({
                    url: '/mtrl_associate_with_job',
                    type: 'POST',
                    data: {
                        _token:"{{ csrf_token() }}", 
                        job_id:jobId,
                        mtrl_id:mtrlId,
                    },    // the _token:token is for Laravel
                    success: function(dataRetFromPHP) {
                        alert('Material didpatched successfully.')
                        parmJobId = {!!json_encode($job_id)!!};
                        if (parmJobId == "") {
                            window.location = './material_associate';
                        } else {
                            window.location = './material_associate?jobId='+jobId;
                        }
                    },
                    error: function(err) {
                        alert('Failed to didpatch the material.\r\nPlease try again!')
                    }
                });
            }
        }

        function EditJob(inputId) {
            // jobId = inputId.substring(2, inputId.length);
            // window.location = './job_selected?jobId='+jobId;
        }

        function EditMaterial(inputId) {
            // mtrlId = inputId.substring(2, inputId.length);
            // window.location = './material_selected?id='+mtrlId;
        }
    </script>
@endsection

