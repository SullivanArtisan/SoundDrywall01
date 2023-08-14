<?php
	use App\Models\Job;
	use App\Models\Material;
	use Illuminate\Support\Facades\Session;
?>

@extends('layouts.home_page_base')

@section('goback')
	<a class="text-primary" href="{{route('home_page')}}" style="margin-right: 10px;">Back</a>
@show

<?php
	if (isset($_GET['display_filter'])) {
		$display_filter = $_GET['display_filter'];
	} else {
		$display_filter = 'active';
	}
?>

@section('function_page')
    <div>
        <div class="row m-4">
            <div>
				<h2 class="text-muted pl-2">All Materials</h2>
            </div>
            <div class="col my-auto ml-5">
				<button class="btn btn-success mr-4" type="button"><a href="{{route('material_add')}}">Add</a></button>
			</div>
			<div class="col mt-3 ml-2">
				<label>Display Filter:</label>
					<input type="radio" class="ml-3 mr-1" id="rdo_mtrl_active" name="for_display_filter" onclick="RdoSelected(this.id)" checked><label>Active Only</label>
					<input type="radio" class="ml-3 mr-1" id="rdo_mtrl_completed" name="for_display_filter" onclick="RdoSelected(this.id)"><label>Completed Only</label>
					<input type="radio" class="ml-3 mr-1" id="rdo_mtrl_canceled" name="for_display_filter" onclick="RdoSelected(this.id)"><label>Canceled Only</label>
					<input type="radio" class="ml-3 mr-1" id="rdo_mtrl_all" name="for_display_filter" onclick="RdoSelected(this.id)"><label>All</label>
				<label></label>
			</div>
            <!--
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
		$sortKey = session('sort_key_material', 'mtrl_type');
		if ($needResort == true) {
			if ($sortOrder == 'asc') {
				session(['sort_order' => 'desc']);
				$sort_icon = 'desc';
			} else {
				session(['sort_order' => 'asc']);
				$sort_icon = 'asc';
			}
			if ($display_filter == 'active') {
				$materials = \App\Models\Material::where('mtrl_status', '<>', 'COMPLETED')->where('mtrl_status', '<>', 'DELETED')->where('mtrl_status', '<>', 'CANCELED')->orderBy($_GET['sort_key_material'], session('sort_order', 'asc'))->paginate(10);
			} else if ($display_filter == 'completed') {
				$materials = \App\Models\Material::where('mtrl_status', 'COMPLETED')->orderBy($_GET['sort_key_material'], session('sort_order', 'asc'))->paginate(10);
			} else if ($display_filter == 'canceled') {
				$materials = \App\Models\Material::where('mtrl_status', 'CANCELED')->orderBy($_GET['sort_key_material'], session('sort_order', 'asc'))->paginate(10);
			} else {
				$materials = \App\Models\Material::orderBy($_GET['sort_key_material'], session('sort_order', 'asc'))->paginate(10);
			}
			session(['sort_key_material' => 'mtrl_name']);
		} else {
			if ($display_filter == 'active') {
				$materials = \App\Models\Material::where('mtrl_status', '<>', 'COMPLETED')->where('mtrl_status', '<>', 'DELETED')->where('mtrl_status', '<>', 'CANCELED')->orderBy($sortKey, $sortOrder)->paginate(10);
			} else if ($display_filter == 'completed') {
				$materials = \App\Models\Material::where('mtrl_status', 'COMPLETED')->orderBy($sortKey, $sortOrder)->paginate(10);
			} else if ($display_filter == 'canceled') {
				$materials = \App\Models\Material::where('mtrl_status', 'CANCELED')->orderBy($sortKey, $sortOrder)->paginate(10);
			} else {
				$materials = \App\Models\Material::orderBy($sortKey, $sortOrder)->paginate(10);
			}
		}

		// Title Line
		$outContents = "<div class=\"container mw-100\">";
        $outContents .= "<div class=\"row bg-info text-white fw-bold\">";
			$outContents .= "<div class=\"col-2 align-middle\">";
				$sortParms = "?display_filter=".$display_filter."&sort_key_material=mtrl_name&sort_time=".time();
				$outContents .= "<a href=\"material_main".$sortParms."\">";
				$outContents .= "Name";
				if ($sort_icon == 'asc') {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-up-square\"></a></i>";
				} else {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-down-square\"></a></i>";
				}
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-3 align-middle\">";
				$sortParms = "?display_filter=".$display_filter."&sort_key_material=mtrl_type&sort_time=".time();
				$outContents .= "<a href=\"material_main".$sortParms."\">";
				$outContents .= "Type";
				if ($sort_icon == 'asc') {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-up-square\"></a></i>";
				} else {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-down-square\"></a></i>";
				}
			$outContents .= "</div>";
            $outContents .= "<div class=\"col-1\">";
				$outContents .= "Model";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "for Task";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "Size";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2\">";
				$outContents .= "Original Amount";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2\">";
				$outContents .= "Left Amount";
			$outContents .= "</div>";
		$outContents .= "</div><hr class=\"m-1\"/>";
		{{echo $outContents;}}
		
		// Body Lines
		foreach ($materials as $material) {
            $outContents = "<div class=\"row\">";
				$outContents .= "<div class=\"col-2\">";
					$outContents .= "<a href=\"material_selected?id=$material->id\">";
					$outContents .= $material->mtrl_name;
					$outContents .= "</a>";
				$outContents .= "</div>";
				$outContents .= "<div class=\"col-3\">";
					$outContents .= "<a href=\"material_selected?id=$material->id\">";
					$outContents .= $material->mtrl_type;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-1\">";
					$outContents .= "<a href=\"material_selected?id=$material->id\">";
					$outContents .= $material->mtrl_model;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-1\">";
					$outContents .= "<a href=\"material_selected?id=$material->id\">";
					$selJob = Job::where('id', $material->mtrl_job_id)->first();
                    if ($selJob) {
                        $outContents .= $selJob->job_name;
                    }
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-1\">";
					$outContents .= "<a href=\"material_selected?id=$material->id\">";
					$outContents .= $material->mtrl_size;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-2\">";
					$outContents .= "<a href=\"material_selected?id=$material->id\">";
					$outContents .= $material->mtrl_amount;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-2\">";
					$outContents .= "<a href=\"material_selected?id=$material->id\">";
					$outContents .= $material->mtrl_amount_left;
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
		{{echo  $materials->links(); }}
		{{echo "</row></div>"; }}
?>
@endsection


<script>
	window.onload = function() {
		var displayFilter = {!!json_encode($display_filter)!!};

		if (displayFilter == 'active') {
			document.getElementById('rdo_mtrl_active').checked = true;
		} else if (displayFilter == 'completed') {
			document.getElementById('rdo_mtrl_completed').checked = true;
		} else if (displayFilter == 'canceled') {
			document.getElementById('rdo_mtrl_canceled').checked = true;
		} else {
			document.getElementById('rdo_mtrl_all').checked = true;
		}
	}
	
	function RdoSelected(elmId) {
		var currentUrl = window.location.href;
		var x = currentUrl.search('=');
		var y = currentUrl.search('&');
		var newUrl = currentUrl;
		if (x > -1 && y > -1) {
			if (elmId == 'rdo_mtrl_active') {
				newUrl = currentUrl.substring(0, x+1) + 'active' + currentUrl.substring(y, currentUrl.length-1);
			} else if (elmId == 'rdo_mtrl_completed') {
				newUrl = currentUrl.substring(0, x+1) + 'completed' + currentUrl.substring(y, currentUrl.length-1);
			} else if (elmId == 'rdo_mtrl_canceled') {
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
