@extends('layouts.home_page_base')

@section('goback')
	<a class="text-primary" href="{{route('zone_main')}}" style="margin-right: 10px;">Back</a>
@show

<?php
	use App\Models\Zone;
	
	$url_components = parse_url($_SERVER['REQUEST_URI']);
	parse_str($url_components['query'], $params);
	$key = array_keys($params)[0];
	$value_parm = $params[$key];
?>

@section('function_page')
    <div>
        <div class="row m-4">
            <div>
				<h2 class="text-muted pl-2">Zones Searched Results (by Zone Group)</h2>
            </div>
            <div class="col">
				<div class="input-group">
				  <input type="text" class="form-control" aria-label="Text input with dropdown button" id="zone_search_input">
				  <div class="input-group-append">
					<button class="btn btn-info ml-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Search</button>
					<div class="dropdown-menu">
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult('zone_name')\" style=\"cursor: pointer;\">by Zone Name</button>");</script>
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult('zone_fsc_deduction')\" style=\"cursor: pointer;\">by Zone FSC Deduction %>");</script>
					</div>
				  </div>
				</div>			
			</div>
        </div>
    </div>
	<?php
		$zones = \App\Models\Zone::where('zone_group', $value_parm)->get();
		
		// Title Line
		$outContents = "<div class=\"container mw-100\">";
        $outContents .= "<div class=\"row bg-info text-white fw-bold\">";
			$outContents .= "<div class=\"col-3 align-middle\">";
				$outContents .= "Zone";
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
					$outContents .= "<a href=\"zone_selected?id=$zone->id\">";
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
	function GetSearchResult(search_by) {
		zone_search_value = document.getElementById('zone_search_input').value;
		if (zone_search_value) {
			url = '';
			if (search_by == 'zone_name') {
				url = "{{ route('zone_name_selected', ':zone_name') }}";
			} else if (search_by == 'zone_fsc_deduction') {
				url = "{{ route('zone_fsc_deduction_selected', ':zone_fsc_deduction') }}";
			}
			url = url.replace(':'+search_by, search_by+'='+zone_search_value);
			document.location.href=url;
		}
	}
</script>