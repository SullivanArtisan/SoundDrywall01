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

    $staff_id = $_GET['staffId'];
    $msg_to_show = "";
    $association_workinghours_total = 0;
	if ($job_id && $staff_id) {
        $job = Job::where('id', $job_id)->first();
        $staff = Staff::where('id', $staff_id)->first();
        $association = JobDispatch::where('jobdsp_job_id', $job_id)->where('jobdsp_staff_id', $staff_id)->where('jobdsp_status', '<>', 'COMPLETED')->where('jobdsp_status', '<>', 'DELETED')->where('jobdsp_status', '<>', 'CANCELED')->first();
        if (!$association) {
            Log::Info('Staff '.Auth::user()->id.' failed to asccess the JobDispatch object for job '.$job_id.' and staff '.$staff_id.' while entering job_combination_staff_selected page.');
        } else {
            $association_workinghours_total = $association->jobdsp_workinghours_total;
        }
	}

    if (isset($_GET['msgToStaffOK'])) {
        $result = $_GET['msgToStaffOK'];
        if ($result=='true' && $staff_id) {
            $msg_to_show = 'Message sent to staff '.$staff->f_name.' '.$staff->l_name.' successfully.';
            Log::Info($msg_to_show);
        }
    }
?>

@extends('layouts.home_page_base')
<style>
.my-text-height {height:75%;}
</style>

@section('goback')
    @if ($from_project == 'true')
	<a class="text-primary" href="{{route('job_combination_main', ['jobIdFromProj'=>$job_id])}}" style="margin-right: 10px;">Back</a>
    @else
	<a class="text-primary" href="{{route('job_combination_main', ['jobId'=>$job_id])}}" style="margin-right: 10px;">Back</a>
    @endif
@show

@if (!$job_id) {
	@section('function_page')
		<div>
			<div class="row">
				<div class="col col-sm-auto">
					<h2 class="text-muted pl-2">Result of the Task-Staff Combination</h2>
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
				<div class="col-5 my-auto">
					<h2 class="text-muted ">Dispatchment of: <span style="font-family: 'Times New Roman';font-weight: bold;font-style: italic; color:darkblue !important">{{$staff->f_name}} {{$staff->l_name}}</span> <span class="h6">({{$staff->role}}):</span></h2>
				</div>
                <div class="col-1 my-auto ml-2">
				    <button class="btn btn-danger me-2" type="button" onclick="return doRemoveStaff();">Remove</button>
			    </div>
                <div class="col-1 my-auto">
			    </div>
                <!--
                <div class="col-2 my-auto">
				    <button class="btn btn-success me-2" type="button" onclick="return changeStaffAssociation();">Re-dispatch this Task to: </button>
			    </div>
                <div class="col my-auto">
                    <?php
                    // $staffs = \App\Models\Staff::where('role', 'ASSISTANT')->orwhere('role', 'SUBCONTRACTOR')->orwhere('role', 'SUPERINTENDENT')->where('status', '<>', 'DELETED')->orderBy('f_name', 'asc')->get();
                    
                    // $tagHead = "<input list=\"staff_name\" name=\"staff_name\" id=\"staffnameinput\" onfocus=\"this.value='';\" class=\"form-control mt-1 my-text-height\" ";
                    // $tagTail = "><datalist id=\"staff_name\">";
                    // foreach($staffs as $single_staff) {
                    //     $tagTail.= "<option value=\"".$single_staff->f_name." ".$single_staff->l_name." (".$single_staff->role.")\">";
                    // }
                    // echo $tagHead."placeholder=\"\" value=\"\"".$tagTail;
                    ?>
                </div>
                -->
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
                <div class="row m-2">
                    <div class="col">
                        @if ($staff->role != 'SUPERINTENDENT')
                        <form method="post" action="{{url('job_combination_msg_to_staff')}}">
                            @csrf
                            <div class="row">
                                <div class="col ml-3">
                                    <div class="row"><label class="col-form-label">Message To1111 <span class="font-italic">{{$staff->f_name}} {{$staff->l_name}}</span>:&nbsp;</label></div>
                                    <div class="row"><textarea class="form-control mt-1 my-text-height" style="height: 150px; !important" type="text" row="10" id="msg_from_admin" name="msg_from_admin">{{$association->jobdsp_msg_from_admin}}</textarea></div>
                                </div>
                                <div class="col ml-3">
                                    <div class="row"><label class="col-form-label">Message From <span class="font-italic">{{$staff->f_name}} {{$staff->l_name}}</span>:&nbsp;</label></div>
                                    <div class="row"><textarea readonly class="form-control mt-1 my-text-height" style="background-color:silver; height: 150px; !important" type="text" row="10" id="msg_from_staff" name="msg_from_staff">{{$association->jobdsp_msg_from_staff}}</textarea></div>
                                    <?php 
                                        $association->jobdsp_msg_from_staff_old = $association->jobdsp_msg_from_staff; 
                                        $association->save();
                                    ?>                        
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="w-25"></div>
                                <div class="col">
                                    <div class="row">
                                        <button class="btn btn-success mx-4" type="submit" onclick="return doSendMsgToStaff();">Send</button>
                                        @if ($from_project == 'true')
                                        <button class="btn btn-secondary mx-3" type="button"><a href="{{route('job_combination_main', ['jobIdFromProj'=>$job_id])}}">Cancel</a></button>
                                        @else
                                        <button class="btn btn-secondary mx-3" type="button"><a href="{{route('job_combination_main', ['jobId'=>$job_id])}}">Cancel</a></button>
                                        @endif
                                    </div>
                                </div>
                                <div class="col"></div>
                            </div>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
		</div>
		
		<script>
            var msgToShow = {!!json_encode($msg_to_show)!!};
            var jobId = {!!json_encode($job_id)!!};
            var staffId = {!!json_encode($staff_id)!!};
            if (msgToShow.length > 0) {
                alert(msgToShow);
            }

            setTimeout(ReloadPageForJobMsg, 7500);

            function ReloadPageForJobMsg() {
                $.ajax({
                    url: '/reload_page_for_job_msg_from_staff',
                    type: 'POST',
                    data: {
                        _token:"{{ csrf_token() }}", 
                        job_id:jobId,
                        staff_id:staffId,
                    },    // the _token:token is for Laravel
                    success: function(dataRetFromPHP) {
                        setTimeout(ReloadPageForJobMsg, 7500);
                        if (document.getElementById('msg_from_staff').value != dataRetFromPHP) {
                            document.getElementById('msg_from_staff').value = dataRetFromPHP;
                            document.getElementById('msg_from_staff').style.color = 'red';
                        } else {
                            document.getElementById('msg_from_staff').value = dataRetFromPHP;
                            document.getElementById('msg_from_staff').style.color = 'white';
                        }
                    },
                    error: function(err) {
                        setTimeout(ReloadPageForJobMsg, 7500);
                    }
                });
            }

            function doSendMsgToStaff() {
                msg = document.getElementById('msg_from_admin').value;
                if (msg.length > 0) {
                    event.preventDefault();
                    var jobId = {!!json_encode($job_id)!!};
                    var staffId = {!!json_encode($staff_id)!!};
                    var fromProject = {!!json_encode($from_project)!!};
                    
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
                            if (fromProject == 'true') {
                                url   = './job_combination_staff_selected?jobIdFromProj='+jobId+'&staffId='+staffId+'&msgToStaffOK=true';
                            } else {
                                url   = './job_combination_staff_selected?jobId='+jobId+'&staffId='+staffId+'&msgToStaffOK=true';
                            }
                            window.location = url;
                        },
                        error: function(err) {
                            if (fromProject == 'true') {
                                url   = './job_combination_staff_selected?jobIdFromProj='+jobId+'&staffId='+staffId+'&msgToStaffOK=false';
                            } else {
                                url   = './job_combination_staff_selected?jobId='+jobId+'&staffId='+staffId+'&msgToStaffOK=false';
                            }
                            window.location = url;
                        }
                    });
                }
            }
            
            function doRemoveStaff() {
                let associationWorkinghoursTotal = {!!json_encode($association_workinghours_total)!!};
                if (associationWorkinghoursTotal > 0) {
                    alert('This staff\'s Total Working Hours is greater than 0.\r\n\r\nYou cannot remove him/her from this task!');
                } else {
                    if(!confirm("Continue to remove this assistant from this task?")) {
                        event.preventDefault();
                    } else {
                        var jobId = {!!json_encode($job_id)!!};
                        var staffId = {!!json_encode($staff_id)!!};
                        var fromProject = {!!json_encode($from_project)!!};

                        $.ajax({
                            url: '/job_combination_staff_remove',
                            type: 'POST',
                            data: {
                                _token:"{{ csrf_token() }}", 
                                job_id:jobId,
                                staff_id:staffId
                            },    // the _token:token is for Laravel
                            success: function(dataRetFromPHP) {
                                if (fromProject == 'true') {
                                    url   = './job_combination_main?jobId='+jobIdFromProj+'&staffId='+staffId+'&staffRemoveOK=true';
                                } else {
                                    url   = './job_combination_main?jobId='+jobId+'&staffId='+staffId+'&staffRemoveOK=true';
                                }
                                window.location = url;
                            },
                            error: function(err) {
                                if (fromProject == 'true') {
                                    url   = './job_combination_staff_selected?jobIdFromProj='+jobId+'&staffId='+staffId+'&staffRemoveOK=false';
                                } else {
                                    url   = './job_combination_staff_selected?jobId='+jobId+'&staffId='+staffId+'&staffRemoveOK=false';
                                }
                                window.location = url;
                            }
                        });
                    }
                }
			}
            
            function changeStaffAssociation() {
                newStaff = document.getElementById('staffnameinput').value;
                if (newStaff.length > 0) {
                    if(!confirm("Continue to re-dispatch this task to this staff?")) {
                        event.preventDefault();
                    } else {
                        var jobId = {!!json_encode($job_id)!!};
                        var staffId = {!!json_encode($staff_id)!!};
                        var fromProject = {!!json_encode($from_project)!!};

                        $.ajax({
                            url: '/job_combination_staff_reassociate',
                            type: 'POST',
                            data: {
                                _token:"{{ csrf_token() }}", 
                                job_id:jobId,
                                staff_id:staffId,
                                new_staff:newStaff
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
                                    url   = './job_combination_staff_selected?jobIdFromProj='+jobId;
                                } else {
                                    url   = './job_combination_staff_selected?jobId='+jobId;
                                }
                                window.location = url;
                            }
                        });
                    }
                } else {
                    alert("You have to select the new staff before you re-dispatch the task.");
                }
            }
		</script>
	@endsection
}
@endif

