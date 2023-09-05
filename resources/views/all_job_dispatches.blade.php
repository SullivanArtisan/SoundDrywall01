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
				<h2 class="text-muted pl-2">All JobDispatches</h2>
            </div>
            <div class="col my-auto ml-5">
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
		$sortKey = session('sort_key_JobDispatch', 'id');
		if ($needResort == true) {
			if ($sortOrder == 'asc') {
				session(['sort_order' => 'desc']);
				$sort_icon = 'desc';
			} else {
				session(['sort_order' => 'asc']);
				$sort_icon = 'asc';
			}
			$associations = \App\Models\JobDispatch::orderBy($_GET['sort_key_JobDispatch'], session('sort_order', 'asc'))->where('jobdsp_status', '<>', 'COMPLETED')->where('jobdsp_status', '<>', 'CANCELED')->where('jobdsp_status', '<>', 'DELETED')->paginate(10)->withQueryString();
			session(['sort_key_JobDispatch' => 'id']);
		} else {
            $associations = \App\Models\JobDispatch::orderBy($sortKey, $sortOrder)->where('jobdsp_status', '<>', 'DELETED')->paginate(10)->withQueryString();
		}

		// Title Line
		$outContents = "<div class=\"container mw-100\">";
        $outContents .= "<div class=\"row bg-info text-white fw-bold\">";
			$outContents .= "<div class=\"col-1\">";
				$sortParms = "?display_filter=".$display_filter."&sort_key_JobDispatch=id&sort_time=".time();
				$outContents .= "<a href=\"all_job_dispatches".$sortParms."\">";
				$outContents .= "ID";
				if ($sort_icon == 'asc') {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-up-square\"></a></i>";
				} else {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-down-square\"></a></i>";
				}
				$outContents .= "</div>";
			$outContents .= "<div class=\"col-2 align-middle\">";
				$sortParms = "?display_filter=".$display_filter."&sort_key_JobDispatch=jobdsp_job_name&sort_time=".time();
				$outContents .= "<a href=\"all_job_dispatches".$sortParms."\">";
				$outContents .= "Task Name";
				if ($sort_icon == 'asc') {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-up-square\"></a></i>";
				} else {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-down-square\"></a></i>";
				}
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2 align-middle\">";
				$sortParms = "?display_filter=".$display_filter."&sort_key_JobDispatch=jobdsp_staff_name&sort_time=".time();
				$outContents .= "<a href=\"all_job_dispatches".$sortParms."\">";
				$outContents .= "Staff Name";
				if ($sort_icon == 'asc') {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-up-square\"></a></i>";
				} else {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-down-square\"></a></i>";
				}
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2 align-middle\">";
				$sortParms = "?display_filter=".$display_filter."&sort_key_JobDispatch=jobdsp_status&sort_time=".time();
				$outContents .= "<a href=\"all_job_dispatches".$sortParms."\">";
				$outContents .= "Status";
				if ($sort_icon == 'asc') {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-up-square\"></a></i>";
				} else {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-down-square\"></a></i>";
				}
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2\">";
				$outContents .= "WHrLT";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "WHrToday";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "WHrTotal";
			$outContents .= "</div>";
		$outContents .= "</div><hr class=\"m-1\"/>";
		{{echo $outContents;}}
		
		// Body Lines
		foreach ($associations as $association) {
            $outContents = "<div class=\"row\">";
				$outContents .= "<div class=\"col-1\">";
					$outContents .= $association->id;
				$outContents .= "</div>";
				$outContents .= "<div class=\"col-2\">";
					$outContents .= $association->jobdsp_job_name;
                $outContents .= "</div>";
                $outContents .= "<div class=\"col-2\">";
					$outContents .= $association->jobdsp_staff_name;
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-2\">";
					$outContents .= $association->jobdsp_status;
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-2\">";
					$outContents .= $association->jobdsp_workinghours_last_time;
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-1\">";
					$outContents .= $association->jobdsp_workinghours_today;
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-1\">";
					$outContents .= $association->jobdsp_workinghours_total;
				$outContents .= "</div>";
			$outContents .= "</div><hr class=\"m-1\"/>";
			{{ 					
				echo $outContents;;
			}}
		}
		$outContents = "</div>";
		{{echo $outContents;}}
		
		{{echo "<div class=\"col-1\"><row><p>&nbsp</p></row><row>"; }}
		{{echo  $associations->links(); }}
		{{echo "</row></div>"; }}
?>
@endsection

<script>
	window.onload = function() {
	}
</script>