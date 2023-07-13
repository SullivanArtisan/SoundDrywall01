<?php
	use App\Models\Material;
	use App\Models\JobDispatch;
	use App\Models\Job;

    $materials = Material::where('mtrl_status', '<>', 'DELETED')->orderBy('mtrl_name', 'asc')->get();
    $jobs = Job::all()->where('job_assistants_complete', '=', '0')->where('job_assistants_complete', '<', 'job_total_active_assistants')->where('job_status', '<>', 'DELETED')->where('job_status', '<>', 'CANCELED');
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
                <h2 class="text-muted pl-2">Associate a Material with a Job:</h2>
            </div>
        </div>
        <div class="row m-4">
            <div class="col-6">
                <!-- Available Materials Section -->
                <div class="container">
                    <div class="row">
                        <div class="col bg-info text-white"><h5 class="mt-1">Materials:&nbsp;</h5></div>
                    </div>
                    <div class="row my-2">
                    <div class="col">
                        <div class="row text-white" style="max-height: 400px; background-color:grey; font-weight:bold !important;">
                            <div class="col-3">Name</div>
                            <div class="col-5">Type</div>
                            <div class="col-2">Amount</div>
                            <div class="col-2">For Job</div>
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
                                $outContents .= "<div class=\"col-3\" style=\"cursor:default\">".$material->mtrl_name."</div>";
                                $outContents .= "<div class=\"col-5\" style=\"cursor:default\">".$material->mtrl_type."</div>";
                                $outContents .= "<div class=\"col-2\" style=\"cursor:default\">".intval($material->mtrl_amount_left)."/".intval($material->mtrl_amount)."</div>";
                                $job = Job::where('id', $material->mtrl_job_id)->first();
                                if ($job) {
                                    $outContents .= "<div class=\"col-2\" style=\"cursor:default\">".$job->job_name."</div>";
                                } else {
                                    $outContents .= "<div class=\"col-2\" style=\"cursor:default\"></div>";
                                }
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
                    <button class="btn btn-success align-items-center" onclick="doMtrlAssociate()">Associate</button>
                </div>
            </div>
            <div class="col-5">
                <!-- Available Jobs Section -->
                <div class="container">
                    <div class="row">
                        <div class="col bg-info text-white"><h5 class="mt-1">Available Jobs:&nbsp;</h5></div>
                    </div>
                    <div class="row my-2">
                    <div class="col">
                        <div class="row text-white" style="max-height: 400px; background-color:grey; font-weight:bold !important;">
                            <div class="col-2">Job Name</div>
                            <div class="col-4">Job Type</div>
                            <div class="col-2">Assistants#</div>
                            <div class="col-4">Job Address</div>
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

            // save the new selected job element's background color
            oldInputJobId = inputId;
            oldJobBgColor = document.getElementById(inputId).style.backgroundColor;

            // set new background color to the new selected job element
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
            if (jobId == "" || mtrlId == "") {
                alert('Please select Material and Job first befor you do the association!')
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
                        alert('Material associated successfully.')
                        window.location = './material_associate';
                    },
                    error: function(err) {
                        alert('Failed to associate the material.\r\nPlease try again!')
                    }
                });
            }
        }

        function EditJob(inputId) {
            jobId = inputId.substring(2, inputId.length);
            window.location = './job_selected?jobId='+jobId;
        }

        function EditMaterial(inputId) {
            mtrlId = inputId.substring(2, inputId.length);
            window.location = './material_selected?id='+mtrlId;
        }
    </script>
@endsection

