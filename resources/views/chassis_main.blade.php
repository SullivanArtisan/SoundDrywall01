@extends('layouts.home_page_base')

@section('goback')
	<a class="text-primary" href="{{route('home_page')}}" style="margin-right: 10px;">Back</a>
@show

@section('function_page')
    <div>
        <div class="row m-4">
            <div>
				<h2 class="text-muted pl-2">Chassis</h2>
            </div>
            <div class="col my-auto ml-5">
				<button class="btn btn-success mr-4" type="button"><a href="{{route('chassis_add')}}">Add</a></button>
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
		// Check if the page is refresed
		if (isset($_GET['sort_time'])) {
			if ($_GET['sort_time'] != session('sort_time', '0')) {
				session(['sort_time' => $_GET['sort_time']]);
				$needResort = true;
			}
			else {
				$needResort = false;
			}
			$sortKeyInput = $_GET['sort_key_chassis'];
		} else {
			$needResort = false;
			if (!isset($_GET['page'])) {
				$sortKeyInput = session('sort_key_chassis', '');
				if ($sortKeyInput == '') {
					$sortKeyInput = 'code';
				} 
			} else {
				$sortKeyInput = session('sort_key_chassis', 'code');
			}
		}
			
		// Get data ordered by the user's intent
		$sort_icon = $sortOrder = session('sort_order', 'asc');
		$sortKey = session('sort_key_chassis', $sortKeyInput);
		if ($needResort == true) {
			if ($sortOrder == 'asc') {
				session(['sort_order' => 'desc']);
				$sort_icon = 'desc';
			} else {
				session(['sort_order' => 'asc']);
				$sort_icon = 'asc';
			}
			$chassis = \App\Models\Chassis::orderBy($_GET['sort_key_chassis'], session('sort_order', 'asc'))->where('deleted', null)->orwhere('deleted', '<>', 'Y')->paginate(10);
			session(['sort_key_chassis' => $sortKeyInput]);
		} else {
			$chassis = \App\Models\Chassis::orderBy($sortKey, $sortOrder)->where('deleted', null)->orwhere('deleted', '<>', 'Y')->paginate(10);
		}
		
		// Title Line
		$outContents = "<div class=\"container mw-100\">";
        $outContents .= "<div class=\"row bg-info text-white fw-bold\">";
			$outContents .= "<div class=\"col-3 align-middle\">";
				$sortParms = "?sort_key_chassis=code&sort_time=".time();
				$outContents .= "<a href=\"chassis_main".$sortParms."\">";
				$outContents .= "Chassis Number";
				if ($sortKeyInput != 'code') {
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
				$sortParms = "?sort_key_chassis=driver&sort_time=".time();
				$outContents .= "<a href=\"chassis_main".$sortParms."\">";
				$outContents .= "Driver";
				if ($sortKeyInput != 'driver') {
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
				$sortParms = "?sort_key_chassis=lastdriver&sort_time=".time();
				$outContents .= "<a href=\"chassis_main".$sortParms."\">";
				$outContents .= "Last Driver";
				if ($sortKeyInput != 'lastdriver') {
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
				$sortParms = "?sort_key_chassis=vin&sort_time=".time();
				$outContents .= "<a href=\"chassis_main".$sortParms."\">";
				$outContents .= "VIN";
				if ($sortKeyInput != 'vin') {
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
		foreach ($chassis as $single_chassis) {
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
		
		{{echo "<div class=\"col-1\"><row><p>&nbsp</p></row><row>"; }}
		{{echo  $chassis->links(); }}
		{{echo "</row></div>"; }}
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