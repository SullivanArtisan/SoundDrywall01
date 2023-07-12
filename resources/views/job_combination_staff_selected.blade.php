<?php
	use App\Models\Material;
	use App\Models\JobDispatch;
	use App\Models\Job;
	use App\Models\Staff;

    $job_id = $_GET['jobId'];
    $staff_id = $_GET['staffId'];
	if ($job_id && $staff_id) {
        $job = Job::where('id', $job_id)->first();
        $staff = Staff::where('id', $staff_id)->first();
        $association = JobDispatch::where('jobdsp_job_id', $job_id)->where('jobdsp_staff_id', $staff_id)->first();
	}

    if (isset($_GET['msgToStaffOK'])) {
        $msgToStaffResult = $_GET['msgToStaffOK'];
        if ($msgToStaffResult=='true' && $staff_id) {
            Log::Info('Message sent to staff '.$staff->f_name.' '.$staff->l_name.' successfully.');
        }
    }
?>

@extends('layouts.home_page_base')
<style>
.my-text-height {height:75%;}
</style>

@section('goback')
	<a class="text-primary" href="{{route('job_combination_main', ['jobId'=>$job_id])}}" style="margin-right: 10px;">Back</a>
@show

@if (!$job_id) {
	@section('function_page')
		<div>
			<div class="row">
				<div class="col col-sm-auto">
					<h2 class="text-muted pl-2">Result of the Job-Staff Combination</h2>
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
					<h2 class="text-muted pl-2">Assistant {{$staff->f_name}} {{$staff->l_name}}:</h2>
				</div>
                <div class="col-1 my-auto ml-5">
				    <button class="btn btn-danger me-2" type="button" onclick="return doRemoveStaff();">Remove</button>
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
                        <form method="post" action="{{url('job_combination_msg_to_staff')}}">
                            @csrf
                            <div class="row">
                                <div class="col m-1">
                                    <div class="row"><label class="col-form-label">Message To Assistant:&nbsp;</label></div>
                                    <div class="row"><textarea class="form-control mt-1 my-text-height" type="text" row="10" id="msg_from_admin" name="msg_from_admin">{{$association->jobdsp_msg_from_admin}}</textarea></div>
                                </div>
                                <div class="col m-1">
                                    <div class="row"><label class="col-form-label">Message From Assistant:&nbsp;</label></div>
                                    <div class="row"><textarea readonly class="form-control mt-1 my-text-height text-white" style="background-color:silver;" type="text" row="10" id="msg_from_staff" name="msg_from_staff">{{$association->jobdsp_msg_from_staff}}</textarea></div>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="w-25"></div>
                                <div class="col">
                                    <div class="row">
                                        <button class="btn btn-success mx-4" type="submit" onclick="return doSendMsgToStaff();">Send</button>
                                        <button class="btn btn-secondary mx-3" type="button"><a href="{{route('job_combination_main', ['jobId'=>$job_id])}}">Cancel</a></button>
                                    </div>
                                </div>
                                <div class="col"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
		</div>
		
		<script>
			function doSendMsgToStaff() {
                msg = document.getElementById('msg_from_admin').value;
                if (msg.length > 0) {
                    event.preventDefault();
                    var jobId = {!!json_encode($job_id)!!};
                    var staffId = {!!json_encode($staff_id)!!};
                    $.ajax({
                        url: '/job_combination_msg_to_staff',
                        type: 'POST',
                        data: {
                            _token:"{{ csrf_token() }}", 
                            job_id:jobId,
                            staff_id:staffId,
                            msg:msg
                        },    // the _token:token is for Laravel
                        success: function(dataRetFromPHP) {
                            window.location = './job_combination_staff_selected?jobId='+jobId+'&staffId='+staffId+'&msgToStaffOK=true';
                        },
                        error: function(err) {
                            window.location = './job_combination_staff_selected?jobId='+jobId+'&staffId='+staffId+'&msgToStaffOK=false';
                        }
                    });
                }
            }
            
            function doRemoveStaff() {
                if(!confirm("Are you sure to remove this assistant from this job?")) {
			        event.preventDefault();
                } else {
                    var jobId = {!!json_encode($job_id)!!};
                    var staffId = {!!json_encode($staff_id)!!};
                    $.ajax({
                        url: '/job_combination_staff_remove',
                        type: 'POST',
                        data: {
                            _token:"{{ csrf_token() }}", 
                            job_id:jobId,
                            staff_id:staffId
                        },    // the _token:token is for Laravel
                        success: function(dataRetFromPHP) {
                            window.location = './job_combination_main?jobId='+jobId+'&staffId='+staffId+'&staffRemoveOK=true';
                        },
                        error: function(err) {
                            window.location = './job_combination_staff_selected?jobId='+jobId+'&staffId='+staffId+'&staffRemoveOK=false';
                        }
                    });
                }
			}
		</script>
	@endsection
}
@endif

