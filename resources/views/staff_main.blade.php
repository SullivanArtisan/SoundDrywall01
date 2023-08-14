@extends('layouts.home_page_base')

@section('goback')
	<a class="text-primary" href="{{route('home_page')}}" style="margin-right: 10px;">Back</a>
@show

@section('function_page')
    <div>
        <div class="row m-4">
            <div>
				<h2 class="text-muted pl-2">Staffs</h2>
            </div>
            <div class="col my-auto ml-5">
				<button class="btn btn-success mr-4" type="button"><a href="{{route('staff_add')}}">Add</a></button>
			</div>
            <div class="col">
				<div class="input-group">
				  <input type="text" class="form-control" aria-label="Text input with dropdown button" id="staff_search_input">
				  <div class="input-group-append">
					<button class="btn btn-info ml-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Search</button>
					<div class="dropdown-menu">
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult('id')\" style=\"cursor: pointer;\">by Staff Id</button>");</script>
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult('name')\" style=\"cursor: pointer;\">by Staff Last Name</button>");</script>
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult('email')\" style=\"cursor: pointer;\">by Staff Email</button>");</script>
					</div>
				  </div>
				</div>			
			</div>
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
		$sortKey = session('sort_key_staff', 'l_name');
		if ($needResort == true) {
			if ($sortOrder == 'asc') {
				session(['sort_order' => 'desc']);
				$sort_icon = 'desc';
			} else {
				session(['sort_order' => 'asc']);
				$sort_icon = 'asc';
			}
			$staffs = \App\Models\Staff::orderBy($_GET['sort_key_staff'], session('sort_order', 'asc'))->where('status', '<>', 'DELETED')->paginate(10);
			session(['sort_key_staff' => 'l_name']);
		} else {
			$staffs = \App\Models\Staff::orderBy($sortKey, $sortOrder)->where('status', '<>', 'DELETED')->paginate(10);
		}

		// Title Line
		$outContents = "<div class=\"container mw-100\">";
        $outContents .= "<div class=\"row bg-info text-white fw-bold\">";
			$outContents .= "<div class=\"col-2\">";
				$outContents .= "First Name";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2 align-middle\">";
				$sortParms = "?sort_key_staff=name&sort_time=".time();
				$outContents .= "<a href=\"staff_main".$sortParms."\">";
				$outContents .= "Last Name";
				if ($sort_icon == 'asc') {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-up-square\"></a></i>";
				} else {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-down-square\"></a></i>";
				}
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2\">";
				$outContents .= "Role";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2\">";
				$outContents .= "Dispatched Tasks";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-3\">";
				$outContents .= "Email";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "Mobile Phone";
			$outContents .= "</div>";
		$outContents .= "</div><hr class=\"m-1\"/>";
		{{echo $outContents;}}
		
		// Body Lines
		foreach ($staffs as $staff) {
            $outContents = "<div class=\"row\">";
				$outContents .= "<div class=\"col-2\">";
					$outContents .= "<a href=\"staff_selected?id=$staff->id\">";
					$outContents .= $staff->f_name;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-2\">";
					$outContents .= "<a href=\"staff_selected?id=$staff->id\">";
					$outContents .= $staff->l_name;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-2\">";
					$outContents .= "<a href=\"staff_selected?id=$staff->id\">";
					$outContents .= $staff->role;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-2\">";
					// if ($staff->assigned_job_id > 0) {
						// $selJob = \App\Models\Job::where('id', $staff->assigned_job_id)->first();
						// $outContents .= "<a href=\"staff_selected?id=$staff->id\">";
						// $outContents .= $selJob->job_name;
						// $outContents .= "</a>";
					// }
					$jobs_total = 0;
					$jobs = \App\Models\JobDispatch::all()->where('jobdsp_staff_id', $staff->id);
					if ($jobs) {
						foreach($jobs as $job) {
							$job_origin = \App\Models\Job::where('id', $job->jobdsp_job_id)->where('job_status', '<>', 'DELETED')->where('job_status', '<>', 'CANCELED')->where('job_status', '<>', 'COMPLETED')->first();
							
							if ($job_origin) {
								$jobs_total++;
							} else {
								$err_msg = "Task ID ".$job->jobdsp_job_id."'s object cannot be found from JobDispatch when counting total tasks in staff_main.blade.";
								Log::Info($err_msg);
							}
						}	
						$outContents .= $jobs_total;
					}
			$outContents .= "</div>";
                $outContents .= "<div class=\"col-3\">";
					$outContents .= "<a href=\"staff_selected?id=$staff->id\">";
					$outContents .= $staff->email;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-1\">";
					$outContents .= "<a href=\"staff_selected?id=$staff->id\">";
					$outContents .= $staff->mobile_phone;
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
		{{echo  $staffs->links(); }}
		{{echo "</row></div>"; }}
?>
@endsection

<script>
	function GetSearchResult(search_by) {
		staff_search_value = document.getElementById('staff_search_input').value;
		if (staff_search_value) {
			param = search_by + '=' + staff_search_value;
			url = "{{ route('staff_condition_selected', '::') }}";
			url = url.replace('::', param);
			document.location.href=url;
		}
	}
</script>