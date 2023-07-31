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
				<h2 class="text-muted pl-2">All Projects</h2>
            </div>
            <div class="col my-auto ml-5">
				<button class="btn btn-success mr-4" type="button"><a href="{{route('project_add')}}">Add</a></button>
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
		$sortKey = session('sort_key_project', 'created_at');
		if ($needResort == true) {
			if ($sortOrder == 'asc') {
				session(['sort_order' => 'desc']);
				$sort_icon = 'desc';
			} else {
				session(['sort_order' => 'asc']);
				$sort_icon = 'asc';
			}
			if ($display_filter == 'active') {
				$projects = \App\Models\Project::orderBy($_GET['sort_key_project'], session('sort_order', 'asc'))->where('proj_status', '<>', 'COMPLETED')->where('proj_status', '<>', 'CANCELED')->where('proj_status', '<>', 'DELETED')->paginate(10);
			} else if ($display_filter == 'completed') {
				$projects = \App\Models\Project::orderBy($_GET['sort_key_project'], session('sort_order', 'asc'))->where('proj_status', 'COMPLETED')->paginate(10);
			} else if ($display_filter == 'canceled') {
				$projects = \App\Models\Project::orderBy($_GET['sort_key_project'], session('sort_order', 'asc'))->where('proj_status', 'CANCELED')->paginate(10);
			} else {
				$projects = \App\Models\Project::orderBy($_GET['sort_key_project'], session('sort_order', 'asc'))->where('proj_status', '<>', 'DELETED')->paginate(10);
			}
			session(['sort_key_project' => 'created_at']);
		} else {
			if ($display_filter == 'active') {
				$projects = \App\Models\Project::orderBy($sortKey, $sortOrder)->where('proj_status', '<>', 'COMPLETED')->where('proj_status', '<>', 'CANCELED')->where('proj_status', '<>', 'DELETED')->paginate(10);
			} else if ($display_filter == 'completed') {
				$projects = \App\Models\Project::orderBy($sortKey, $sortOrder)->where('proj_status', 'COMPLETED')->paginate(10);
			} else if ($display_filter == 'canceled') {
				$projects = \App\Models\Project::orderBy($sortKey, $sortOrder)->where('proj_status', 'CANCELED')->paginate(10);
			} else {
				$projects = \App\Models\Project::orderBy($sortKey, $sortOrder)->where('proj_status', '<>', 'DELETED')->paginate(10);
			}
		}

		// Title Line
		$outContents = "<div class=\"container mw-100\">";
        $outContents .= "<div class=\"row bg-info text-white fw-bold\">";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "ID";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-3\">";
				$outContents .= "Customer Name";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "Status";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "Total Jobs";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2\">";
				$sortParms = "?display_filter=".$display_filter."&sort_key_project=created_at&sort_time=".time();
				$outContents .= "<a href=\"project_main".$sortParms."\">";
				$outContents .= "Created Time";
				if ($sort_icon == 'asc') {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-up-square\"></a></i>";
				} else {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-down-square\"></a></i>";
				}
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-4\">";
				$outContents .= "Notes";
			$outContents .= "</div>";
		$outContents .= "</div><hr class=\"m-1\"/>";
		{{echo $outContents;}}
		
		// Body Lines
		foreach ($projects as $project) {
            $v_name = "";
            $client = \App\Models\Client::where('id', $project->proj_cstmr_id)->first();
            if ($client) {
                $client_name = $client->clnt_name;
            }
            $outContents = "<div class=\"row\">";
				$outContents .= "<div class=\"col-1\">";
					$outContents .= "<a href=\"project_selected?id=$project->id\">";
					$outContents .= $project->id;
					$outContents .= "</a>";
				$outContents .= "</div>";
				$outContents .= "<div class=\"col-3\">";
					$outContents .= "<a href=\"project_selected?id=$project->id\">";
					$outContents .= $client_name;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-1\">";
					$outContents .= "<a href=\"project_selected?id=$project->id\">";
					$outContents .= $project->proj_status;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-1\">";
					$outContents .= "<a href=\"project_selected?id=$project->id\">";
					$outContents .= $project->proj_total_active_jobs;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-2\">";
					$outContents .= "<a href=\"project_selected?id=$project->id\">";
					$outContents .= $project->created_at;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-4\">";
					$outContents .= "<a href=\"project_selected?id=$project->id\">";
					$outContents .= $project->proj_notes;
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
		{{echo  $projects->links(); }}
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
		}

		window.location = newUrl;
	}
</script>
