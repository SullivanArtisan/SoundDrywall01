<?php
	use App\Models\JobDispatch;
	use App\Models\Project;
	use App\Models\ProjectAttachment;
	use App\Models\Job;
?>

@extends('layouts.home_page_base')
<style>
.my-text-height {height:75%;}
</style>

<?php
	$id = $_GET['id'];
	if ($id) {
		$project = Project::where('id', $id)->first();
		$attachments = ProjectAttachment::where('atchmnt_proj_id', $id)->where('atchmnt_status', '<>', 'DELETED')->orderBy('atchmnt_file_name')->get();
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
                    // Attachments' Title Line
                    $outContents = "<div class=\"container mw-100 mt-3\">";
                    $outContents .= "<div class=\"row bg-info text-white fw-bold mb-2\">";
                        $outContents .= "<div class=\"col mt-1 align-middle\">";
                            $outContents .= "File Name";
                        $outContents .= "</div>";
                        $outContents .= "<div class=\"col mt-1 align-middle\">";
                            $outContents .= "Created On";
                        $outContents .= "</div>";
                        $outContents .= "<div class=\"col mt-1 align-middle\">";
                            $outContents .= "";
                        $outContents .= "</div>";
                    $outContents .= "</div>";
                    echo $outContents;

                    // All Attachments' Body Lines
                    foreach($attachments as $attachment) {
                        $outContents = "<div class=\"row\" >";
                            $outContents .= "<div class=\"col\">";
                                $outContents .= "<a href=\"./project_attachments/".$attachment->atchmnt_file_name."\">";
                                $outContents .= $attachment->atchmnt_file_name;
                                $outContents .= "</a>";
                            $outContents .= "</div>";
                            $outContents .= "<div class=\"col\">";
                                $outContents .= "<a href=\"./project_attachments/".$attachment->atchmnt_file_name."\">";
                                $outContents .= $attachment->created_at;
                                $outContents .= "</a>";
                            $outContents .= "</div>";
                            $outContents .= "<div class=\"col\">";
                                // $outContents .= "<a href=\"./project_attachments/".$attachment->atchmnt_file_name."\">";
                                // $outContents .= $attachment->atchmnt_file_name;
                                // $outContents .= "</a>";
                                $outContents .= "<button class=\"btn btn-sm text-white rounded btn-danger\" id=\"".$attachment->id."\" onclick=\"RemoveThisAttachment(this.id, '".$attachment->atchmnt_file_name."')\">Remove</button>";
                            $outContents .= "</div>";
                        $outContents .= "</div>";
                        echo $outContents;
                    }
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
                                <strong class="text-success">{{ $message }}</strong>
                            </div>
                            <?php Session::forget(['success']); ?>
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
                                <input type="hidden" name="proj_id" id="proj_id" value="{{$id}}">
                                <!--input id="uploadFile" placeholder="No File" disabled="disabled" /-->
                                <label class="custom-file-label" for="chooseFile" id="uploadPath">Select file</label>
                            </div>
                            <button type="submit" id="btn_upld_attchmnt" name="submit" class="btn btn-primary btn-block mt-4" disabled>Upload an Attachment File</button>
                        </form>
                    </div>
                    <div class="col">
                    </div>
                </div>
            </div>
		</div>
		
		<script>
            document.getElementById("btn_upld_attchmnt").disabled = true;

            document.getElementById("chooseFile").onchange = function() {
                var pathInArray = this.value.split("\\");
                var fName = pathInArray[pathInArray.length - 1];
                document.getElementById("uploadPath").innerHTML = fName;
                if (fName.length < 64) {
                    document.getElementById("btn_upld_attchmnt").disabled = false;
                } else {
                    alert('The filename\'s length has to be less than 64 characters!');
                }
            };

            function RemoveThisAttachment(inputId, fileName) {
                if(!confirm("Continue to remove this attachment from this project?")) {
                    event.preventDefault();
                } else {
                    $.ajax({
                        url: '/project_attachment_remove',
                        type: 'POST',
                        data: {
                            _token:"{{ csrf_token() }}", 
                            atchmnt_proj_id: inputId,
                        },    // the _token:token is for Laravel
                        success: function(dataRetFromPHP) {
                            alert('Attachment '+fileName+' is removed successfully.');
                            window.location = './project_attachment_main?id='+{!!json_encode($id)!!};
                        },
                        error: function(err) {
                            window.location = './project_attachment_main?id='+{!!json_encode($id)!!};
                        }
                    });
                }
            }
		</script>
	@endsection
}
@endif

