<?php
	use App\Models\Project;
	use App\Models\JobType;
	use App\Models\Job;
	use Illuminate\Support\Facades\Session;

    $proj_notes = "";
    $cstmr_name = "";

    if (isset($_GET['projId'])) {
		$proj_id = $_GET['projId'];
        $project = Project::where('id', $proj_id)->first();
    } else {
        $proj_id = "";
    }
?>

@extends('layouts.home_page_base')
<style>
.my-text-height {height:75%;}
</style>

@section('goback')
	<a class="text-primary" href="{{route('project_selected', ['id'=>$project->id])}}" style="margin-right: 10px;">Back</a>
@show

@section('function_page')
	<div>
		<h2 id="page_headline" class="text-muted pl-2 mb-2">Add a New Job</h2>
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
        ?>
        <div class="card my-4">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <form method="post" action="{{route('op_result.job_add')}}">
                            @csrf
                            <div class="row">
                                <div class="col"><label class="col-form-label">Project Id:&nbsp;</label></div>
                                <div class="col"><input class="form-control mt-1 my-text-height" type="number" readonly id="job_proj_id" name="job_proj_id" value={{$proj_id}}></div>
                                <div class="col"><label class="col-form-label">Job Name:&nbsp;</label></div>
                                <?php
                                    $job_name = "P".$project->id."J".strval($project->proj_total_jobs+1);
                                ?>
                                <div class="col"><input class="form-control mt-1 my-text-height" type="text" readonly id="job_name" name="job_name" value={{$job_name}}></div>
                            </div>
                            <div class="row">
                                <div class="col"><label class="col-form-label">Job Type:&nbsp;</label><span class="text-danger">*</span></div>
                                <div class="col">
                                    <?php
                                    $tagHead = "<input list=\"job_type\" name=\"job_type\" id=\"jobtypeinput\" class=\"form-control mt-1 my-text-height\" ";
                                    $tagTail = "><datalist id=\"job_type\">";

                                    $types = JobType::all()->sortBy('job_type');
                                    foreach($types as $type) {
                                        $tagTail.= "<option value=".str_replace(' ', '&nbsp;', $type->job_type).">";
                                    }
                                    $tagTail.= "</datalist>";
                                    // if (isset($_GET['selJobId'])) {
                                    // 	echo $tagHead."placeholder=\"".$booking->bk_job_type."\" value=\"".$booking->bk_job_type."\"".$tagTail;
                                    // } else {
                                        echo $tagHead."placeholder=\"\" value=\"\"".$tagTail;
                                    // }
                                    ?>
                                </div>
                                <div class="col"><label class="col-form-label">Job Address:&nbsp;</label><span class="text-danger">*</span></div>
                                <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="job_address" name="job_address"></div>
                            </div>
                            <div class="row">
                                <div class="col"><label class="col-form-label">Job City:&nbsp;</label><span class="text-danger">*</span></div>
                                <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="job_city" name="job_city"></div>
                                <div class="col"><label class="col-form-label">Job Province:&nbsp;</label></div>
                                <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="job_province" name="job_province"></div>
                            </div>
                            <div class="row">
                                <div class="col"><label class="col-form-label">Job Description:&nbsp;</label></div>
                                <div class="col"><textarea class="form-control mt-1 my-text-height" rows = "5" id="job_desc" name="job_desc"></textarea></div>
                                <div class="col"><label class="col-form-label">&nbsp;</label></div>
                                <div class="col"><input class="form-control mt-1 my-text-height" type="hidden" readonly id="proj_id" name="proj_id" value="{{$proj_id}}"></div>
                            </div>
                            <div class="row my-3">
                                <div class="w-25"></div>
                                <div class="col">
                                    <div class="row">
                                        <button class="btn btn-success mx-4" type="submit" id="btn_save">Save</button>
                                        <button class="btn btn-secondary mx-3" type="button"><a href="{{route('project_selected', ['id'=>$project->id])}}">Cancel</a></button>
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
			
@endsection
