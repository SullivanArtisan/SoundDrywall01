<?php
	use App\Models\JobDispatch;
	use App\Models\Project;
	use App\Models\Client;
	use App\Models\Status;
	use App\Models\Staff;
	use App\Models\Job;
?>

@extends('layouts.home_page_base')
<style>
.my-text-height {height:75%;}
</style>

<?php
	$id = $_GET['id'];
    $client_name = "";
    $job_add_ok = "";
    $job_update_ok = "";
    $job_delete_ok = "";
	if ($id) {
		$project = Project::where('id', $id)->first();
	}
?>

@section('goback')
	<a class="text-primary" href="{{route('project_selected', ['id'=>$id])}}" style="margin-right: 10px;">Back</a>
@show

@if (!$id or !$project) {
	@section('function_page')
		<div>
			<div class="row">
				<div class="col col-sm-auto">
					<h2 class="text-muted pl-2">Result of the Project</h2>
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
			<div class="row m-2">
				<div>
					<h2 class="text-muted pl-2">Attachments of Project {{$id}}:</h2>
				</div>
				<div class="col"></div>
			</div>
            <div class="card">
                <div class="card-body" style="background: #BAD8D8;">
                    <?php
                    // Tasks' Title Line
                    $outContents = "<div class=\"container mw-100 mt-3\">";
                    $outContents .= "<div class=\"row bg-info text-white fw-bold mb-2\">";
                        $outContents .= "<div class=\"col mt-1 align-middle\">";
                            $outContents .= "File Name";
                        $outContents .= "</div>";
                        $outContents .= "<div class=\"col mt-1 align-middle\">";
                            $outContents .= "File Type";
                        $outContents .= "</div>";
                        $outContents .= "<div class=\"col mt-1 align-middle\">";
                            $outContents .= "Created On";
                        $outContents .= "</div>";
                        $outContents .= "<div class=\"col mt-1 align-middle\">";
                            $outContents .= "";
                        $outContents .= "</div>";
                    $outContents .= "</div>";
                    echo $outContents;
                    ?>
                    <!--div class="row mt-5 d-flex justify-content-center">
                        <div class="col-3 my-4 ml-5">
                            <button class="btn btn-success me-2" type="button"><a href="{{route('job_add', ['projId'=>$project->id])}}">Add a Task</a></button>
                        </div>
                    </div-->
                </div>
            </div>
            <div  style="background: #e8f5e9;">
                <div class="row m-4">
                    <div class="col">
                    </div>
                    <div class="col">
                        <?php
                        // echo Form::open(array('url' => '/uploadfile','files'=>'true'));
                        // echo 'Select the file to upload.';
                        // echo Form::file('image');
                        // echo Form::submit('Upload File');
                        // echo Form::close();
                        ?>
                        <form action="{{route('uploadfile')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <strong>{{ $message }}</strong>
                            </div>
                            @endif
                            @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <div class="custom-file">
                                <input type="file" name="file" id="chooseFile">
                                <input id="uploadFile" placeholder="No File" disabled="disabled" />
                                <label class="custom-file-label" for="chooseFile" id="uploadPath">Select file</label>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">Upload an Attachment File</button>
                        </form>
                    </div>
                    <div class="col">
                        <!--form method="post" action="{{url('project_update')}}">
                            @csrf
                            <div class="row">
                                <div class="col"><label class="col-form-label">Client Name:&nbsp;</label><span class="text-danger">*</span></div>
                                <div class="col">
                                    <?php
                                    // $tagHead = "<input list=\"proj_cstmr_name\" name=\"proj_cstmr_name\" id=\"projcstmrnameinput\" onfocus=\"this.value='';\" onblur=\"if (this.value=='') this.value='".$client_name."';\" class=\"form-control mt-1 my-text-height\" value=\"".$client_name."\"";
                                    // $tagTail = "><datalist id=\"proj_cstmr_name\">";

                                    // $clients = Client::all()->sortBy('clnt_name');
                                    // foreach($clients as $client) {
                                    //     $tagTail.= "<option value=".str_replace(' ', '&nbsp;', $client->clnt_name).">";
                                    // }
                                    // $tagTail.= "</datalist>";
                                    // // if (isset($_GET['selJobId'])) {
                                    // // 	echo $tagHead."placeholder=\"".$booking->bk_job_type."\" value=\"".$booking->bk_job_type."\"".$tagTail;
                                    // // } else {
                                    //     echo $tagHead."placeholder=\"\" value=\"\"".$tagTail;
                                    // // }
                                    ?>
                                </div>
                                <div class="col"><label class="col-form-label">Total Tasks:&nbsp;</label></div>
                                <div class="col"><input class="form-control mt-1 my-text-height" type="number" readonly id="proj_total_active_jobs" name="proj_total_active_jobs" value="{{$project->proj_total_active_jobs}}"></div>
                            </div>
                            <div class="row">
                                <div class="col"><label class="col-form-label">Task Address:&nbsp;</label><span class="text-danger">*</span></div>
                                <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="proj_address" name="proj_address" value="{{$project->proj_address}}"></div>
                                <div class="col"><label class="col-form-label">Task City:&nbsp;</label><span class="text-danger">*</span></div>
                                <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="proj_city" name="proj_city" value="{{$project->proj_city}}"></div>
                            </div>
                            <div class="row">
                                <div class="col"><label class="col-form-label">Task Province:&nbsp;</label></div>
                                <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="proj_province" name="proj_province" value="{{$project->proj_province}}"></div>
                                <div class="col"><label class="col-form-label">Task Postcode:&nbsp;</label></div>
                                <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="proj_postcode" name="proj_postcode" value="{{$project->proj_postcode}}"></div>
                            </div>
                            <div class="row">
                                <div class="col"><label class="col-form-label">Description:&nbsp;</label></div>
                                <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="proj_notes" name="proj_notes" value="{{$project->proj_notes}}"></div>
                                <div class="col"><label class="col-form-label">Status:&nbsp;</label></div>
                                <div class="col">
                                    <?php
                                    // $tagHead = "<input list=\"proj_status\" name=\"proj_status\" id=\"projstatusinput\" onfocus=\"this.value='';\" onblur=\"if (this.value=='') this.value='".$project->proj_status."';\" class=\"form-control mt-1 my-text-height\" value=\"".$project->proj_status."\"";
                                    // $tagTail = "><datalist id=\"proj_status\">";

                                    // $statuses = Status::all();
                                    // foreach($statuses as $status) {
                                    //     $tagTail.= "<option value=".str_replace(' ', '&nbsp;', $status->status_name).">";
                                    // }
                                    // $tagTail.= "</datalist>";
                                    // // if (isset($_GET['selJobId'])) {
                                    // // 	echo $tagHead."placeholder=\"".$booking->bk_job_type."\" value=\"".$booking->bk_job_type."\"".$tagTail;
                                    // // } else {
                                    //     echo $tagHead."placeholder=\"\" value=\"\"".$tagTail;
                                    // // }
                                    ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col"><label class="col-form-label">&nbsp;</label></div>
                                <div class="col"><input class="form-control mt-1 my-text-height" type="hidden" id="id" name="id" value="{{$project->id}}"></div>
                                <div class="col"><label class="col-form-label">&nbsp;</label></div>
                                <div class="col"><input class="form-control mt-1 my-text-height" type="hidden" id="proj_my_creation_timestamp" name="proj_my_creation_timestamp" value="{{time()}}"></div>
                            </div>
                            <div class="row my-3">
                                <div class="col"></div>
                                <div class="col">
                                    @if (Auth::user()->role == 'ADMINISTRATOR')
                                    <button class="btn btn-warning mx-3" type="submit">Update</button>
                                    @endif
                                    <button class="btn btn-secondary mx-3" type="button"><a href="{{route('project_main', ['display_filter'=>'active'])}}">Cancel</a></button>
                                    <button class="btn btn-info mx-3" type="button"><a href="{{route('project_attachment_main', ['id'=>$id])}}">Attachments</a></button>
                                </div>
                                <div class="col"></div>
                            </div>
                        </form-->
                    </div>
                </div>
            </div>
		</div>
		
		<script>
            var jobAddOk = {!!json_encode($job_add_ok)!!};
            var jobUpdateOk = {!!json_encode($job_update_ok)!!};
            var jobDeleteOk = {!!json_encode($job_delete_ok)!!};
            if (jobAddOk.length > 0) {
                alert("Task "+jobAddOk+" is didpatched successfully.");
            }
            if (jobUpdateOk.length > 0) {
                alert("Task "+jobUpdateOk+" is updated successfully.");
            }
            if (jobDeleteOk.length > 0) {
                alert("Task "+jobDeleteOk+" is deleted successfully.");
            }

			function myConfirmation() {
				if(!confirm("Are you sure to delete this project?"))
				    event.preventDefault();
			}
		</script>
	@endsection
}
@endif

