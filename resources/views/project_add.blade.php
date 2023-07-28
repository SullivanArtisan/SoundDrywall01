<?php
	use App\Models\Client;
	use App\Models\Project;
	use Illuminate\Support\Facades\Session;

    $proj_notes = "";
    $cstmr_name = "";

    if (isset($_GET['projId'])) {
		$proj_id = $_GET['projId'];
        $project = Project::where('id', $proj_id)->first();
        $client = Client::where('id', $project->proj_cstmr_id)->first();

		$jobs = \App\Models\Job::where('job_proj_id', $proj_id)->where('job_status', '<>', 'DELETED')->get();

        if ($project && $client) {
            $proj_notes = $project->proj_notes;
            $cstmr_name = $client->clnt_name;
        }
    } else {
        $proj_id = "";
    }

    if (isset($_GET['projAddFailed'])) {
        Log::Info('For some reason, we failed to create the project.\n\rPlease try again later.');
    }
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
		<h2 id="page_headline" class="text-muted pl-2 mb-2">Add a New Project</h2>
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
        <?php
        // // Title Line
        // $outContents = "<div id=\"jobs_div\" class=\"container mw-100\">";
        // $outContents .= "<div class=\"row bg-info text-white fw-bold mb-2\">";
        //     $outContents .= "<div class=\"col mt-1 align-middle\">";
        //         $outContents .= "Job Name";
        //     $outContents .= "</div>";
        //     $outContents .= "<div class=\"col mt-1 align-middle\">";
        //         $outContents .= "Job Type";
        //     $outContents .= "</div>";
        //     $outContents .= "<div class=\"col mt-1 align-middle\">";
        //         $outContents .= "Location";
        //     $outContents .= "</div>";
        //     $outContents .= "<div class=\"col mt-1 align-middle\">";
        //         $outContents .= "Status";
        //     $outContents .= "</div>";
        // $outContents .= "</div>";
        // echo $outContents;

        // // Body Lines
        // $selected_job	 = "";
        // $listed_jobs = 0;

        // if (count($jobs) == 0) {
        //     echo "<div class=\"row\" style=\"background-color:Lavender\"><div class=\"col\"><p class=\"text-info\">There is 0 jobs associated with this project.</p></div></div>";
        // }

        // foreach ($jobs as $job) {
        //     $selected_job = $job->id;
        //     $listed_jobs++;
        //     if ($listed_jobs % 2) {
        //         $outContents = "<div class=\"row\" style=\"background-color:Lavender\">";
        //     } else {
        //         $outContents = "<div class=\"row\" style=\"background-color:PaleGreen\">";
        //     }
        //     $outContents .= "<div class=\"col\">";
        //         $outContents .= "<a href=\"".route('job_selected', ['jobId='.$job->id])."\">";
        //         $outContents .= $job->job_name;
        //         $outContents .= "</a>";
        //     $outContents .= "</div>";
        //     $outContents .= "<div class=\"col\">";
        //         $outContents .= $job->job_type;
        //     $outContents .= "</div>";
        //     $outContents .= "<div class=\"col\">";
        //         $outContents .= $job->job_location;
        //     $outContents .= "</div>";
        //     $outContents .= "<div class=\"col\">";
        //         $outContents .= $job->job_status;
        //     $outContents .= "</div>";
        //     // $outContents .= "<div class=\"col-2\">";
        //     // $outContents .= "</div>";
        //     // $outContents .= "<div class=\"col-2\">";
        //     //     $outContents .= "<button class=\"btn btn-secondary btn-sm my-1\" type=\"button\"><a href=\"".route('movements_selected', ['cntnrId'=>$job->id])."\">Edit Movements</a></button>";
        //     // $outContents .= "</div>";
        //     $outContents .= "</div>";
        //     echo $outContents;
        // }
        // echo "</div>";
        ?>
        <div class="card my-4">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <form method="post" action="{{route('op_result.project_add')}}">
                            @csrf
                            <div class="row">
                                <div class="col"><label class="col-form-label">Customer Name:&nbsp;</label><span class="text-danger">*</span></div>
                                <div class="col">
                                            <?php
                                            $tagHead = "<input list=\"proj_cstmr_name\" name=\"proj_cstmr_name\" id=\"projcstmrnameinput\" class=\"form-control mt-1 my-text-height\" ";
                                            $tagTail = "><datalist id=\"proj_cstmr_name\">";

                                            $clients = Client::all()->sortBy('clnt_name');
                                            foreach($clients as $client) {
                                                $tagTail.= "<option value=".str_replace(' ', '&nbsp;', $client->clnt_name).">";
                                            }
                                            $tagTail.= "</datalist>";
                                            // if (isset($_GET['selJobId'])) {
                                            // 	echo $tagHead."placeholder=\"".$booking->bk_job_type."\" value=\"".$booking->bk_job_type."\"".$tagTail;
                                            // } else {
                                                echo $tagHead."placeholder=\"\" value=\"\"".$tagTail;
                                            // }
                                            ?>
                                        </div>
                                <div class="col"><label class="col-form-label">Total Jobs:&nbsp;</label></div>
                                <div class="col"><input class="form-control mt-1 my-text-height" type="number" readonly id="proj_total_active_jobs" name="proj_total_active_jobs" value=0></div>
                            </div>
                            <div class="row">
                                <div class="col"><label class="col-form-label">Description:&nbsp;</label></div>
                                <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="proj_notes" name="proj_notes"></div>
                                <div class="col"><label class="col-form-label">Status:&nbsp;</label></div>
                                <div class="col"><input class="form-control mt-1 my-text-height" type="text" readonly id="proj_status" name="proj_status" value="CREATED"></div>
                            </div>
                            <div class="row">
                                <div class="col"><label class="col-form-label">&nbsp;</label></div>
                                <div class="col"><input class="form-control mt-1 my-text-height" type="hidden" readonly id="proj_my_creation_timestamp" name="proj_my_creation_timestamp" value="{{time()}}"></div>
                            </div>
                            <div class="row my-3">
                                <div class="w-25"></div>
                                <div class="col">
                                    <div class="row">
                                        <button class="btn btn-success mx-4" type="submit" id="btn_save" onclick="addThisProject();">Save</button>
                                        <button class="btn btn-secondary mx-3" type="button"><a href="{{route('project_main')}}">Cancel</a></button>
                                    </div>
                                </div>
                                <div class="col"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.0/dist/js.cookie.min.js"></script>
    <script>
            var projId = {!! json_encode($proj_id) !!}
            if (projId != "") {
                var cstmrName = {!! json_encode($cstmr_name) !!}
                var projNotes = {!! json_encode($proj_notes) !!}

                document.getElementById('projcstmrnameinput').value = cstmrName;
                document.getElementById('projcstmrnameinput').setAttribute('readonly', true);
                document.getElementById('proj_notes').value = projNotes;
                document.getElementById('proj_notes').setAttribute('readonly', true);
                document.getElementById('btn_save').disabled = true;

                document.getElementById('page_headline').innerHTML = "New Project: ";

                // document.getElementById('jobs_div').style.display = "block";
            } else {
                // document.getElementById('jobs_div').style.display = "none";
            }

        function addThisProject() {
            event.preventDefault();

            $.ajax({
                url: '/project_add',
                type: 'POST',
                data: {
                    _token:"{{ csrf_token() }}", 
                    proj_cstmr_name:document.getElementById('projcstmrnameinput').value,
                    proj_total_active_jobs:document.getElementById('proj_total_active_jobs').value,
                    proj_status:document.getElementById('proj_status').value, 
                    proj_notes:document.getElementById('proj_notes').value,
                    proj_my_creation_timestamp:document.getElementById('proj_my_creation_timestamp').value
                },    // the _token:token is for Laravel
                success: function(dataRetFromPHP) {
                    let statusKey = new String("pausedReason = ");
                    let position = dataRetFromPHP.indexOf(statusKey);
                    if (position >= 0) {
                        window.location = './op_result_project?status='+dataRetFromPHP.substr(statusKey.length);
                    } else {
                        if(!confirm("The new project is created successfully.\r\nDo you want to add any job to it now?")) {
                            window.location = './op_result_project?status=The project is added successfully!';
                        } else {
                            window.location = './project_selected?id='+dataRetFromPHP;
                        }
                    }
                },
                error: function(err) {
                    window.location = './op_result_project?status='+err;
                }
            });
        }
    </script>
			
@endsection
