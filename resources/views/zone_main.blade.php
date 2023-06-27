@extends('layouts.home_page_base')

@section('goback')
	<a class="text-primary" href="{{route('home_page')}}" style="margin-right: 10px;">Back</a>
@show

@section('function_page')
    <div>
        <div class="row m-4">
            <div>
				<h2 class="text-muted pl-2">Zones</h2>
            </div>
            <div class="col my-auto ml-5">
				<button class="btn btn-success mr-4" type="button"><a href="{{route('zone_add')}}">Add</a></button>
			</div>
            <div class="col">
				<div class="input-group">
				  <input type="text" class="form-control" aria-label="Text input with dropdown button" id="zone_search_input">
				  <div class="input-group-append">
					<button class="btn btn-info ml-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Search</button>
					<div class="dropdown-menu">
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult1('zone_name')\" style=\"cursor: pointer;\">by Zone Name</button>");</script>
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult1('zone_group')\" style=\"cursor: pointer;\">by Zone Group</button>");</script>
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult1('zone_fsc_deduction')\" style=\"cursor: pointer;\">by Zone FSC Deduction</button>");</script>
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
			$sortKeyInput = $_GET['sort_key_zone'];
		} else {
			$needResort = false;
			if (!isset($_GET['page'])) {
				$sortKeyInput = session('sort_key_zone', '');
				if ($sortKeyInput == '') {
					$sortKeyInput = 'zone_name';
				} 
			} else {
				$sortKeyInput = session('sort_key_zone', 'zone_name');
			}
		}
			
		// Get data ordered by the user's intent
		$sort_icon = $sortOrder = session('sort_order', 'asc');
		$sortKey = session('sort_key_zone', $sortKeyInput);
		if ($needResort == true) {
			if ($sortOrder == 'asc') {
				session(['sort_order' => 'desc']);
				$sort_icon = 'desc';
			} else {
				session(['sort_order' => 'asc']);
				$sort_icon = 'asc';
			}
			$zones = \App\Models\Zone::orderBy($_GET['sort_key_zone'], session('sort_order', 'asc'))->paginate(10);
			session(['sort_key_zone' => $sortKeyInput]);
		} else {
			$zones = \App\Models\Zone::orderBy($sortKey, $sortOrder)->paginate(10);
		}
		
		// Title Line
		$outContents = "<div class=\"container mw-100\">";
        $outContents .= "<div class=\"row bg-info text-white fw-bold\">";
			$outContents .= "<div class=\"col-3 align-middle\">";
				$sortParms = "?sort_key_zone=zone_name&sort_time=".time();
				$outContents .= "<a href=\"zone_main".$sortParms."\">";
				$outContents .= "Zone";
				if ($sortKeyInput != 'zone_name') {
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
				$sortParms = "?sort_key_zone=zone_group&sort_time=".time();
				$outContents .= "<a href=\"zone_main".$sortParms."\">";
				$outContents .= "Group";
				if ($sortKeyInput != 'zone_group') {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-dash-square\"></a></i>";
				} else {
					if ($sort_icon == 'asc') {
						$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-up-square\"></a></i>";
					} else {
						$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-down-square\"></a></i>";
					}
				}
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-5\">";
				$outContents .= "Description";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2\">";
				$sortParms = "?sort_key_zone=zone_fsc_deduction&sort_time=".time();
				$outContents .= "<a href=\"zone_main".$sortParms."\">";
				$outContents .= "FSC Deduction %";
				if ($sortKeyInput != 'zone_fsc_deduction') {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-dash-square\"></a></i>";
				} else {
					if ($sort_icon == 'asc') {
						$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-up-square\"></a></i>";
					} else {
						$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-down-square\"></a></i>";
					}
				}
			$outContents .= "</div>";
		$outContents .= "</div><hr class=\"m-2\"/>";
		{{echo $outContents;}}
		
		// Body Lines
		foreach ($zones as $zone) {
            $outContents = "<div class=\"row\">";
                $outContents .= "<div class=\"col-3\">";
					$outContents .= "<a href=\"zone_selected?id=$zone->id\">";
					$outContents .= $zone->zone_name;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-2\">";
					$outContents .= "<a href=\"zone_selected?id=$zone->id\">";
					$outContents .= $zone->zone_group;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-5\">";
					$outContents .= "<a href=\zone_selected?id=$zone->id\">";
					$outContents .= $zone->zone_description;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-2\">";
					$outContents .= "<a href=\"zone_selected?id=$zone->id\">";
					$outContents .= $zone->zone_fsc_deduction;
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
		{{echo  $zones->links(); }}
		{{echo "</row></div>"; }}
?>
@endsection

<script>
	function GetSearchResult1(search_by) {
		zone_search_value = document.getElementById('zone_search_input').value;
		if (zone_search_value) {
			param = search_by + '=' + zone_search_value;
			url = "{{ route('zone_condition_selected', '::') }}";
			url = url.replace('::', param);
			document.location.href=url;
		}
	}
</script>