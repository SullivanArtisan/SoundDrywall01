@extends('layouts.home_page_base')

@section('goback')
	<a class="text-primary" href="{{route('home_page')}}" style="margin-right: 10px;">Back</a>
@show

@section('function_page')
<?php
	if (isset($_GET['display_filter'])) {
		$display_filter = $_GET['display_filter'];
	} else {
		$display_filter = 'active';
	}
	?>
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
                                // if ($project->proj_total_active_jobs > 0 && ($project->proj_jobs_complete == $project->proj_total_active_jobs )) {
                                //     continue;
                                // }
								$tagTail.= "<option value=".$project->id.">";
                            }
                            $tagTail.= "</datalist>";
                            echo $tagHead."placeholder=\"\" value=\"\"".$tagTail;
                        ?>
                        </div>
                    </div>
                </form>
            </div>
			<div class="col mt-3 ml-2">
				<label>Display Filter:</label>
					<input type="radio" class="ml-3 mr-1" id="rdo_proj_active" name="for_display_filter" onclick="RdoSelected(this.id)" checked><label>Active Only</label>
					<input type="radio" class="ml-3 mr-1" id="rdo_proj_completed" name="for_display_filter" onclick="RdoSelected(this.id)"><label>Completed Only</label>
					<input type="radio" class="ml-3 mr-1" id="rdo_proj_canceled" name="for_display_filter" onclick="RdoSelected(this.id)"><label>Canceled Only</label>
					<input type="radio" class="ml-3 mr-1" id="rdo_proj_all" name="for_display_filter" onclick="RdoSelected(this.id)"><label>All</label>
				<label></label>
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
			if ($display_filter == 'active') {
				$jobs = \App\Models\Job::orderBy($_GET['sort_key_job'], session('sort_order', 'asc'))->where('job_status', '<>', 'COMPLETED')->where('job_status', '<>', 'CANCELED')->where('job_status', '<>', 'DELETED')->paginate(10)->withQueryString();
			} else if ($display_filter == 'completed') {
				$jobs = \App\Models\Job::orderBy($_GET['sort_key_job'], session('sort_order', 'asc'))->where('job_status', 'COMPLETED')->paginate(10)->withQueryString();
			} else if ($display_filter == 'canceled') {
				$jobs = \App\Models\Job::orderBy($_GET['sort_key_job'], session('sort_order', 'asc'))->where('job_status', 'CANCELED')->paginate(10)->withQueryString();
			} else {
				$jobs = \App\Models\Job::orderBy($_GET['sort_key_job'], session('sort_order', 'asc'))->where('job_status', '<>', 'DELETED')->paginate(10)->withQueryString();
			}
			session(['sort_key_job' => 'job_name']);
		} else {
			if ($display_filter == 'active') {
				$jobs = \App\Models\Job::orderBy($sortKey, $sortOrder)->where('job_status', '<>', 'COMPLETED')->where('job_status', '<>', 'CANCELED')->where('job_status', '<>', 'DELETED')->paginate(10)->withQueryString();
			} else if ($display_filter == 'completed') {
				$jobs = \App\Models\Job::orderBy($sortKey, $sortOrder)->where('job_status', 'COMPLETED')->paginate(10)->withQueryString();
			} else if ($display_filter == 'canceled') {
				$jobs = \App\Models\Job::orderBy($sortKey, $sortOrder)->where('job_status', 'CANCELED')->paginate(10)->withQueryString();
			} else {
				$jobs = \App\Models\Job::orderBy($sortKey, $sortOrder)->where('job_status', '<>', 'DELETED')->paginate(10)->withQueryString();
			}
		}

		// Title Line
		$outContents = "<div class=\"container mw-100\">";
        $outContents .= "<div class=\"row bg-info text-white fw-bold\">";
			$outContents .= "<div class=\"col-2\">";
				$sortParms = "?display_filter=".$display_filter."&sort_key_job=job_name&sort_time=".time();
				$outContents .= "<a href=\"job_main".$sortParms."\">";
				$outContents .= "Task Name";
				if ($sort_icon == 'asc') {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-up-square\"></a></i>";
				} else {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-down-square\"></a></i>";
				}
				$outContents .= "</div>";
			$outContents .= "<div class=\"col-2 align-middle\">";
				$sortParms = "?display_filter=".$display_filter."&sort_key_job=job_type&sort_time=".time();
				$outContents .= "<a href=\"job_main".$sortParms."\">";
				$outContents .= "Task Type";
				if ($sort_icon == 'asc') {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-up-square\"></a></i>";
				} else {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-down-square\"></a></i>";
				}
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
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "Due Date";
			$outContents .= "</div>";
		$outContents .= "</div><hr class=\"m-1\"/>";
		{{echo $outContents;}}
		
		// Body Lines
		foreach ($jobs as $job) {
			if (Auth::user()->role != 'ADMINISTRATOR') {
				$associations = \App\Models\JobDispatch::where('jobdsp_job_id', $job->id)->where('jobdsp_status', '<>', 'DELETED')->where('jobdsp_status', '<>', 'CANCELED')->get();
				$other_superintendent_num = 0;
				foreach ($associations as $association) {
					$one_staff = \App\Models\Staff::where('id', $association->jobdsp_staff_id)->first();
					if ($one_staff) {
						if (($one_staff->role == 'SUPERINTENDENT') && ($one_staff->id != Auth::user()->id)) {
							$other_superintendent_num++;
						}
					} else {
						Log::Info(Auth::user()->id.' failed to access the staff '.$association->jobdsp_staff_id.'\'s object for job '.$job->id.' while listing available jobs');
					}
				}
				//if (!$one_association || ($superintendent_num > 0)) {
				if ($other_superintendent_num > 0) {
					continue;
				}
			}

            $outContents = "<div class=\"row\">";
				$outContents .= "<div class=\"col-2\">";
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
                $outContents .= "<div class=\"col-1\">";
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
	window.onload = function() {
		var displayFilter = {!!json_encode($display_filter)!!};

		if (displayFilter == 'active') {
			document.getElementById('rdo_proj_active').checked = true;
		} else if (displayFilter == 'completed') {
			document.getElementById('rdo_proj_completed').checked = true;
		} else if (displayFilter == 'canceled') {
			document.getElementById('rdo_proj_canceled').checked = true;
		} else {
			document.getElementById('rdo_proj_all').checked = true;
		}
	}
	
	function RdoSelected(elmId) {
		var currentUrl = window.location.href;
		var x = currentUrl.search('=');
		var y = currentUrl.search('&');
		var newUrl = currentUrl;
		if (x > -1 && y > -1) {
			if (elmId == 'rdo_proj_active') {
				newUrl = currentUrl.substring(0, x+1) + 'active' + currentUrl.substring(y, currentUrl.length-1);
			} else if (elmId == 'rdo_proj_completed') {
				newUrl = currentUrl.substring(0, x+1) + 'completed' + currentUrl.substring(y, currentUrl.length-1);
			} else if (elmId == 'rdo_proj_canceled') {
				newUrl = currentUrl.substring(0, x+1) + 'canceled' + currentUrl.substring(y, currentUrl.length-1);
			} else {
				newUrl = currentUrl.substring(0, x+1) + 'all' + currentUrl.substring(y, currentUrl.length-1);
			}
		} else {
			newUrl = currentUrl.substring(0, x+1) + elmId.substring(9, elmId.length);
			console.log('newUrl2 = '+newUrl);
		}

		window.location = newUrl;
	}

	function doAddJob() {
        event.preventDefault();
		projId = document.getElementById('projidinput').value;
		if (projId.length == 0) {
			alert('Please select the target project first befor you add a new task to it.');
		} else {
			window.location='./job_add?projIdFromAllJobs='+projId;
        }
	}
</script>