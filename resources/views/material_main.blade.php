<?php
	use App\Models\Job;
	use App\Models\Material;
	use Illuminate\Support\Facades\Session;
?>

@extends('layouts.home_page_base')

@section('goback')
	<a class="text-primary" href="{{route('home_page')}}" style="margin-right: 10px;">Back</a>
@show

@section('function_page')
    <div>
        <div class="row m-4">
            <div>
				<h2 class="text-muted pl-2">All Materials</h2>
            </div>
            <div class="col my-auto ml-5">
				<button class="btn btn-success mr-4" type="button"><a href="{{route('material_add')}}">Add</a></button>
			</div>
            <div class="col">
                <!--
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
                -->			
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
		$sortKey = session('sort_key_material', 'mtrl_name');
		if ($needResort == true) {
			if ($sortOrder == 'asc') {
				session(['sort_order' => 'desc']);
				$sort_icon = 'desc';
			} else {
				session(['sort_order' => 'asc']);
				$sort_icon = 'asc';
			}
			$materials = \App\Models\Material::where('mtrl_status', '<>', 'DELETED')->orderBy($_GET['sort_key_material'], session('sort_order', 'asc'))->paginate(10);
			session(['sort_key_material' => 'mtrl_name']);
		} else {
			$materials = \App\Models\Material::where('mtrl_status', '<>', 'DELETED')->orderBy($sortKey, $sortOrder)->paginate(10);
		}

		// Title Line
		$outContents = "<div class=\"container mw-100\">";
        $outContents .= "<div class=\"row bg-info text-white fw-bold\">";
			$outContents .= "<div class=\"col-3 align-middle\">";
				$sortParms = "?sort_key_material=mtrl_name&sort_time=".time();
				$outContents .= "<a href=\"material_main".$sortParms."\">";
				$outContents .= "Name";
				if ($sort_icon == 'asc') {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-up-square\"></a></i>";
				} else {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-down-square\"></a></i>";
				}
			$outContents .= "</div>";
            $outContents .= "<div class=\"col-3\">";
				$outContents .= "Type";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "for Job";
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
				$outContents .= "<div class=\"col-3\">";
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

