@extends('layouts.home_page_base')

@section('goback')
	<a class="text-primary" href="{{route('home_page')}}" style="margin-right: 10px;">Back</a>
@show

@section('function_page')
    <div>
        <div class="row m-4">
            <div>
				<h2 class="text-muted pl-2">All Tasks</h2>
            </div>
            <div class="col my-auto ml-5">
                <form method="post" action="{{url('job_add')}}">
                    @csrf
                    <div class="row">
                        <div><button class="btn btn-success mr-4" type="submit" onclick="doAddJob()">Add a Task to Project:&nbsp;</button></div>
                        <div>
                        <?php
                            $tagHead = "<input list=\"proj_id\" name=\"proj_id\" id=\"projidinput\" onfocus=\"this.value='';\" class=\"form-control my-text-height\" ";
                            $tagTail = "><datalist id=\"proj_id\">";

                            $projects = App\Models\Project::where('proj_status', '<>', 'CANCELED')->where('proj_status', '<>', 'DELETED')->get()->sortBy('id');
                            foreach($projects as $project) {
                                if ($project->proj_total_active_jobs > 0 && ($project->proj_jobs_complete == $project->proj_total_active_jobs )) {
                                    continue;
                                }
                                $tagTail.= "<option value=".$project->id.">";
                            }
                            $tagTail.= "</datalist>";
                            echo $tagHead."placeholder=\"\" value=\"\"".$tagTail;
                        ?>
                        </div>
                    </div>
                </form>
            </div>
            <!--
            <div class="col">
				<div class="input-group">
				  <input type="text" class="form-control" aria-label="Text input with dropdown button" id="provider_search_input">
				  <div class="input-group-append">
					<button class="btn btn-info ml-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Search</button>
					<div class="dropdown-menu">
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult('id')\" style=\"cursor: pointer;\">by Provider Id</button>");</script>
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult('name')\" style=\"cursor: pointer;\">by Provider Name</button>");</script>
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult('email')\" style=\"cursor: pointer;\">by Provider Phone</button>");</script>
					</div>
				  </div>
				</div>			
			</div>
            -->
        </div>
    </div>
	<?php
		// Check if the page is refresed
		if (isset($_GET['sort_time'])) {
			if ($_GET['sort_time'] != session('sort_time', '0')) {
				session(['sort_time' => $_GET['sort_time']]);
				$needResort = true;
			}
			else {
				$needResort = false;
			}
		} else {
			$needResort = false;
		}
			
		// Get data ordered by the user's intent
		$sort_icon = $sortOrder = session('sort_order', 'asc');
		$sortKey = session('sort_key_job', 'job_name');
		if ($needResort == true) {
			if ($sortOrder == 'asc') {
				session(['sort_order' => 'desc']);
				$sort_icon = 'desc';
			} else {
				session(['sort_order' => 'asc']);
				$sort_icon = 'asc';
			}
			$jobs = \App\Models\Job::orderBy($_GET['sort_key_job'], session('sort_order', 'asc'))->where('job_status', '<>', 'CANCELED')->where('job_status', '<>', 'DELETED')->paginate(10);
			session(['sort_key_job' => 'job_name']);
		} else {
			$jobs = \App\Models\Job::orderBy($sortKey, $sortOrder)->where('job_status', '<>', 'CANCELED')->where('job_status', '<>', 'DELETED')->paginate(10);
		}

		// Title Line
		$outContents = "<div class=\"container mw-100\">";
        $outContents .= "<div class=\"row bg-info text-white fw-bold\">";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "Task Name";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2 align-middle\">";
				$outContents .= "Task Type";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2\">";
				$outContents .= "Status";
			$outContents .= "</div>";
			// $outContents .= "<div class=\"col-2\">";
			// 	$outContents .= "Address";
			// $outContents .= "</div>";
			// $outContents .= "<div class=\"col-1\">";
			// 	$outContents .= "City";
			// $outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "Crew#";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "Material#";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2\">";
				$outContents .= "Description";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2\">";
				$outContents .= "Due Date";
			$outContents .= "</div>";
		$outContents .= "</div><hr class=\"m-1\"/>";
		{{echo $outContents;}}
		
		// Body Lines
		foreach ($jobs as $job) {
			if (Auth::user()->role != 'ADMINISTRATOR') {
				$association = \App\Models\JobDispatch::where('jobdsp_job_id', $job->id)->where('jobdsp_staff_id', Auth::user()->id)->where('jobdsp_status', '<>', 'DELETED')->where('jobdsp_status', '<>', 'CANCELED')->first();
				if (!$association) {
					continue;
				}
			}

            $outContents = "<div class=\"row\">";
				$outContents .= "<div class=\"col-1\">";
					$outContents .= "<a href=\"job_selected?jobId=$job->id\">";
					$outContents .= $job->job_name;
					$outContents .= "</a>";
				$outContents .= "</div>";
				$outContents .= "<div class=\"col-2\">";
                    $outContents .= "<a href=\"job_selected?jobId=$job->id\">";
                    $outContents .= $job->job_type;
                    $outContents .= "</a>";
                $outContents .= "</div>";
                $outContents .= "<div class=\"col-2\">";
					$outContents .= "<a href=\"job_selected?jobId=$job->id\">";
					$outContents .= $job->job_status;
					$outContents .= "</a>";
				$outContents .= "</div>";
                // $outContents .= "<div class=\"col-2\">";
				// 	$outContents .= "<a href=\"job_selected?jobId=$job->id\">";
				// 	$outContents .= $job->job_address;
				// 	$outContents .= "</a>";
				// $outContents .= "</div>";
                // $outContents .= "<div class=\"col-1\">";
				// 	$outContents .= "<a href=\"job_selected?jobId=$job->id\">";
				// 	$outContents .= $job->job_city;
				// 	$outContents .= "</a>";
				// $outContents .= "</div>";
                $outContents .= "<div class=\"col-1\">";
					$outContents .= "<a href=\"job_selected?jobId=$job->id\">";
					$outContents .= $job->job_total_active_assistants;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-1\">";
					$outContents .= "<a href=\"job_selected?jobId=$job->id\">";
					$outContents .= $job->job_total_active_materials;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-2\">";
					$outContents .= "<a href=\"job_selected?jobId=$job->id\">";
					$outContents .= $job->job_desc;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-2\">";
					$outContents .= "<a href=\"job_selected?jobId=$job->id\">";
					$outContents .= $job->job_till_time;
					$outContents .= "</a>";
				$outContents .= "</div>";
			$outContents .= "</div><hr class=\"m-1\"/>";
			{{ 					
				echo $outContents;;
			}}
		}
		$outContents = "</div>";
		{{echo $outContents;}}
		
		{{echo "<div class=\"col-1\"><row><p>&nbsp</p></row><row>"; }}
		{{echo  $jobs->links(); }}
		{{echo "</row></div>"; }}
?>
@endsection

<script>
	function doAddJob() {
        event.preventDefault();
		projId = document.getElementById('projidinput').value;
		if (projId.length == 0) {
			alert('Please select the target project first befor you add a new task to it.');
		} else {
			window.location='./job_add?projId='+projId;
        }
	}
</script>