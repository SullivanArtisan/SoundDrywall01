@extends('layouts.home_page_base')

@section('goback')
	<a class="text-primary" href="{{route('home_page')}}" style="margin-right: 10px;">Back</a>
@show

@section('function_page')
    <div>
        <div class="row m-4">
            <div>
				<h2 class="text-muted pl-2">Power Units</h2>
            </div>
            <div class="col my-auto ml-5">
				<button class="btn btn-success mr-4" type="button"><a href="{{route('power_unit_add')}}">Add</a></button>
			</div>
            <div class="col">
				<div class="input-group">
				  <input type="text" class="form-control" aria-label="Text input with dropdown button" id="unit_search_input">
				  <div class="input-group-append">
					<button class="btn btn-info ml-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Search</button>
					<div class="dropdown-menu">
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult('unit_id')\" style=\"cursor: pointer;\">by Unit Id</button>");</script>
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult('plate_number')\" style=\"cursor: pointer;\">by Plate Number</button>");</script>
					</div>
				  </div>
				</div>			
			</div>
        </div>
    </div>
	<?php
		use App\Models\UserSysDetail;
		
		// Check if the page is refresed
		if (isset($_GET['sort_time'])) {
			if ($_GET['sort_time'] != session('sort_time', '0')) {
				session(['sort_time' => $_GET['sort_time']]);
				$needResort = true;
			}
			else {
				$needResort = false;
			}
			$sortKeyInput = $_GET['sort_key_unit'];
		} else {
			$needResort = false;
			if (!isset($_GET['page'])) {
				$sortKeyInput = session('sort_key_unit', '');
				if ($sortKeyInput == '') {
					$sortKeyInput = 'unit_id';
				} 
			} else {
				$sortKeyInput = session('sort_key_unit', 'unit_id');
			}
		}
			
		// Get data ordered by the user's intent
		$sort_icon = $sortOrder = session('sort_order', 'asc');
		$sortKey = session('sort_key_unit', $sortKeyInput);
		if ($needResort == true) {
			if ($sortOrder == 'asc') {
				session(['sort_order' => 'desc']);
				$sort_icon = 'desc';
			} else {
				session(['sort_order' => 'asc']);
				$sort_icon = 'asc';
			}
			$units = \App\Models\PowerUnit::orderBy($_GET['sort_key_unit'], session('sort_order', 'asc'))->paginate(10);
			session(['sort_key_unit' => $sortKeyInput]);
		} else {
			$units = \App\Models\PowerUnit::orderBy($sortKey, $sortOrder)->paginate(10);
		}
				
		// Title Line
		$outContents = "<div class=\"container mw-100\">";
        $outContents .= "<div class=\"row bg-info text-white fw-bold\">";
			$outContents .= "<div class=\"col-1 align-middle\">";
				$sortParms = "?sort_key_unit=unit_id&sort_time=".time();
				$outContents .= "<a href=\"power_unit_main".$sortParms."\">";
				$outContents .= "Unit ID";
				if ($sortKeyInput != 'unit_id') {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-dash-square\"></a></i>";
				} else {
					if ($sort_icon == 'asc') {
						$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-up-square\"></a></i>";
					} else {
						$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-down-square\"></a></i>";
					}
				}
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$sortParms = "?sort_key_unit=make&sort_time=".time();
				$outContents .= "<a href=\"power_unit_main".$sortParms."\">";
				$outContents .= "Make";
				if ($sortKeyInput != 'make') {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-dash-square\"></a></i>";
				} else {
					if ($sort_icon == 'asc') {
						$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-up-square\"></a></i>";
					} else {
						$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-down-square\"></a></i>";
					}
				}
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2\">";
				$sortParms = "?sort_key_unit=plate_number&sort_time=".time();
				$outContents .= "<a href=\"power_unit_main".$sortParms."\">";
				$outContents .= "Plate Number";
				if ($sortKeyInput != 'plate_number') {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-dash-square\"></a></i>";
				} else {
					if ($sort_icon == 'asc') {
						$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-up-square\"></a></i>";
					} else {
						$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-down-square\"></a></i>";
					}
				}
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-3\">";
				$outContents .= "VIN";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "Current Driver";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "Current Location";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "OPS Code";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "Insurance Expiry Date";
			$outContents .= "</div>";
		$outContents .= "</div><hr class=\"m-2\"/>";
		{{echo $outContents;}}
		
		// Body Lines
		foreach ($units as $unit) {
            $outContents = "<div class=\"row\">";
                $outContents .= "<div class=\"col-1\">";
					$outContents .= "<a href=\"power_unit_selected?id=$unit->id\">";
					$outContents .= $unit->unit_id;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-1\">";
					$outContents .= "<a href=\"power_unit_selected?id=$unit->id\">";
					$outContents .= $unit->make;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-2\">";
					$outContents .= "<a href=\"power_unit_selected?id=$unit->id\">";
					$outContents .= $unit->plate_number;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-3\">";
					$outContents .= "<a href=\"power_unit_selected?id=$unit->id\">";
					$outContents .= $unit->vin;
					$outContents .= "</a>";
				$outContents .= "</div>";
				$outContents .= "<div class=\"col-1\">";
					$outContents .= "<a href=\"power_unit_selected?id=$unit->id\">";
					$outContents .= $unit->current_driver;
					$outContents .= "</a>";
				$outContents .= "</div>";
				$outContents .= "<div class=\"col-1\">";
					$outContents .= "<a href=\"power_unit_selected?id=$unit->id\">";
					$outContents .= $unit->current_location;
					$outContents .= "</a>";
				$outContents .= "</div>";
				$outContents .= "<div class=\"col-1\">";
					$outContents .= "<a href=\"power_unit_selected?id=$unit->id\">";
					$outContents .= $unit->ops_code;
					$outContents .= "</a>";
				$outContents .= "</div>";
				$outContents .= "<div class=\"col-1\">";
					$outContents .= "<a href=\"power_unit_selected?id=$unit->id\">";
					$outContents .= $unit->insurance_expiry_date;
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
		{{echo  $units->links(); }}
		{{echo "</row></div>"; }}
?>
@endsection

<script>
	function GetSearchResult(search_by) {
		unit_search_value = document.getElementById('unit_search_input').value;
		if (unit_search_value) {
			param = search_by + '=' + unit_search_value;
			url = "{{ route('power_unit_condition_selected', '::') }}";
			url = url.replace('::', param);
			document.location.href=url;
		}
	}
</script>