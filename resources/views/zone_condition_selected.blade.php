@extends('layouts.home_page_base')

@section('goback')
	<a class="text-primary" href="{{route('zone_main')}}" style="margin-right: 10px;">Back</a>
@show

<?php
	$url_components = parse_url($_SERVER['REQUEST_URI']);
	parse_str($url_components['query'], $params);
	$key = array_keys($params)[0];
	$value_parm = $params[$key];
?>

@section('function_page')
    <div>
        <div class="row m-4">
            <div>
				<?php
					$page_head = "<h2 class=\"text-muted pl-2\">Zones Searched Results (by ";
					if ($key == 'zone_name') {
						$page_head .= "Zone Name)</h2>";
					} else if ($key == 'zone_group') {
						$page_head .= "Zone Group)</h2>";
					} else if ($key == 'zone_fsc_deduction') {
						$page_head .= "Zone FSC Deduction %)</h2>";
					}
					echo $page_head;
				?>
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
		} else {
			$needResort = false;
		}
			
		$sort_icon = $sortOrder = session('sort_order', 'asc');
		if ($needResort == true) {
			if ($sortOrder == 'asc') {
				session(['sort_order' => 'desc']);
				$sort_icon = 'desc';
			} else {
				session(['sort_order' => 'asc']);
				$sort_icon = 'asc';
			}
			$zones = \App\Models\Zone::where($key, $value_parm)->orderBy('zone_name', session('sort_order', 'asc'))->get();
		} else {
			$zones = \App\Models\Zone::where($key, $value_parm)->orderBy('zone_name', $sortOrder)->get();
		}
		
		// Title Line
		$outContents = "<div class=\"container mw-100\">";
        $outContents .= "<div class=\"row bg-info text-white fw-bold\">";
			$outContents .= "<div class=\"col-3 align-middle\">";
				$sortParms = "?".$key."=".$value_parm."&sort_key_zone=zone_name&sort_time=".time();
				$outContents .= "<a href=\"zone_condition_selected".$sortParms."\">";
				$outContents .= "Zone";
				if ($sort_icon == 'asc') {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-up-square\"></a></i>";
				} else {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-down-square\"></a></i>";
				}
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2\">";
				$outContents .= "Group";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-5\">";
				$outContents .= "Description";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2\">";
				$outContents .= "FSC Deduction %";
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