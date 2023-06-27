@extends('layouts.home_page_base')

@section('goback')
	<a class="text-primary" href="{{route('chassis_main')}}" style="margin-right: 10px;">Back</a>
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
					$page_head = "<h2 class=\"text-muted pl-2\">Chassis Searched Results (by ";
					if ($key == 'code') {
						$page_head .= "Chassis Number)</h2>";
					} else if ($key == 'driver') {
						$page_head .= "Driver)</h2>";
					} else if ($key == 'vin') {
						$page_head .= "VIN)</h2>";
					}
					echo $page_head;
				?>
            </div>
            <div class="col">
				<div class="input-group">
				  <input type="text" class="form-control" aria-label="Text input with dropdown button" id="chassis_search_input">
				  <div class="input-group-append">
					<button class="btn btn-info ml-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Search</button>
					<div class="dropdown-menu">
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult('code')\" style=\"cursor: pointer;\">by Chassis Number</button>");</script>
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult('driver')\" style=\"cursor: pointer;\">by Driver</button>");</script>
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult('vin')\" style=\"cursor: pointer;\">by VIN</button>");</script>
					</div>
				  </div>
				</div>			
			</div>
        </div>
    </div>
	<?php
        $chassis = \App\Models\Chassis::where($key, 'LIKE', '%'.$value_parm.'%')->orderBy('code', 'asc')->get();
		
		// Title Line
		$outContents = "<div class=\"container mw-100\">";
        $outContents .= "<div class=\"row bg-info text-white fw-bold\">";
			$outContents .= "<div class=\"col-3 align-middle\">";
				$sortParms = "?sort_key_chassis=code&sort_time=".time();
				$outContents .= "<a href=\"chassis_main".$sortParms."\">";
				$outContents .= "Chassis Number";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-3\">";
				$sortParms = "?sort_key_chassis=driver&sort_time=".time();
				$outContents .= "<a href=\"chassis_main".$sortParms."\">";
				$outContents .= "Driver";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-3\">";
				$sortParms = "?sort_key_chassis=lastdriver&sort_time=".time();
				$outContents .= "<a href=\"chassis_main".$sortParms."\">";
				$outContents .= "Last Driver";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-3\">";
				$sortParms = "?sort_key_chassis=vin&sort_time=".time();
				$outContents .= "<a href=\"chassis_main".$sortParms."\">";
				$outContents .= "VIN";
			$outContents .= "</div>";
		$outContents .= "</div><hr class=\"m-2\"/>";
		{{echo $outContents;}}
		
		// Body Lines
		foreach ($chassis as $single_chassis) {
            if ($single_chassis->deleted == 'Y' || $single_chassis->deleted == 'y') {
                continue;
            }
            $outContents = "<div class=\"row\">";
                $outContents .= "<div class=\"col-3\">";
					$outContents .= "<a href=\"chassis_selected?id=$single_chassis->id\">";
					$outContents .= $single_chassis->code;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-3\">";
					$outContents .= "<a href=\"chassis_selected?id=$single_chassis->id\">";
					$outContents .= $single_chassis->driver;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-3\">";
					$outContents .= "<a href=\chassis_selected?id=$single_chassis->id\">";
					$outContents .= $single_chassis->lastdriver;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-3\">";
					$outContents .= "<a href=\"chassis_selected?id=$single_chassis->id\">";
					$outContents .= $single_chassis->vin;
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
		chassis_search_value = document.getElementById('chassis_search_input').value;
		if (chassis_search_value) {
			param = search_by + '=' + chassis_search_value;
			url = "{{ route('chassis_condition_selected', '::') }}";
			url = url.replace('::', param);
			document.location.href=url;
		}
	}
</script>