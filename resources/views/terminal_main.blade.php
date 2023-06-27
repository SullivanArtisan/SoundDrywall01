@extends('layouts.home_page_base')

@section('goback')
	<a class="text-primary" href="{{route('home_page')}}" style="margin-right: 10px;">Back</a>
@show

@section('function_page')
    <div>
        <div class="row m-4">
            <div>
				<h2 class="text-muted pl-2">Terminals</h2>
            </div>
            <div class="col my-auto ml-5">
				<button class="btn btn-success mr-4" type="button"><a href="{{route('terminal_add')}}">Add</a></button>
			</div>
            <div class="col">
				<div class="input-group">
				  <input type="text" class="form-control" aria-label="Text input with dropdown button" id="trmnl_search_input">
				  <div class="input-group-append">
					<button class="btn btn-info ml-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Search</button>
					<div class="dropdown-menu">
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult1('trmnl_name')\" style=\"cursor: pointer;\">by Terminals Name</button>");</script>
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult1('trmnl_city')\" style=\"cursor: pointer;\">by City</button>");</script>
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult1('trmnl_province')\" style=\"cursor: pointer;\">by Province</button>");</script>
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult1('trmnl_country')\" style=\"cursor: pointer;\">by Country</button>");</script>
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult1('trmnl_area')\" style=\"cursor: pointer;\">by Area</button>");</script>
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
			$sortKeyInput = $_GET['sort_key_terminal'];
		} else {
			$needResort = false;
			if (!isset($_GET['page'])) {
				$sortKeyInput = session('sort_key_terminal', '');
				if ($sortKeyInput == '') {
					$sortKeyInput = 'trmnl_name';
				} 
			} else {
				$sortKeyInput = session('sort_key_terminal', 'trmnl_name');
			}
		}
			
		// Get data ordered by the user's intent
		$sort_icon = $sortOrder = session('sort_order', 'asc');
		$sortKey = session('sort_key_terminal', $sortKeyInput);
		if ($needResort == true) {
			if ($sortOrder == 'asc') {
				session(['sort_order' => 'desc']);
				$sort_icon = 'desc';
			} else {
				session(['sort_order' => 'asc']);
				$sort_icon = 'asc';
			}
			$trmnls = \App\Models\Terminal::orderBy($_GET['sort_key_terminal'], session('sort_order', 'asc'))->paginate(10);
			session(['sort_key_terminal' => $sortKeyInput]);
		} else {
			$trmnls = \App\Models\Terminal::orderBy($sortKey, $sortOrder)->paginate(10);
		}
		
		// Title Line
		$outContents = "<div class=\"container mw-100\">";
        $outContents .= "<div class=\"row bg-info text-white fw-bold\">";
			$outContents .= "<div class=\"col-2 align-middle\">";
				$sortParms = "?sort_key_terminal=trmnl_name&sort_time=".time();
				$outContents .= "<a href=\"terminal_main".$sortParms."\">";
				$outContents .= "Terminal";
				if ($sortKeyInput != 'trmnl_name') {
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
				$outContents .= "Address";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2\">";
				$sortParms = "?sort_key_terminal=trmnl_city&sort_time=".time();
				$outContents .= "<a href=\"terminal_main".$sortParms."\">";
				$outContents .= "City";
				if ($sortKeyInput != 'trmnl_city') {
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
				$sortParms = "?sort_key_terminal=trmnl_province&sort_time=".time();
				$outContents .= "<a href=\"terminal_main".$sortParms."\">";
				$outContents .= "Province";
				if ($sortKeyInput != 'trmnl_province') {
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
				$sortParms = "?sort_key_terminal=trmnl_country&sort_time=".time();
				$outContents .= "<a href=\"terminal_main".$sortParms."\">";
				$outContents .= "Country";
				if ($sortKeyInput != 'trmnl_country') {
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
				$sortParms = "?sort_key_terminal=trmnl_area&sort_time=".time();
				$outContents .= "<a href=\"terminal_main".$sortParms."\">";
				$outContents .= "Area";
				if ($sortKeyInput != 'trmnl_area') {
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
		foreach ($trmnls as $trmnl) {
            $outContents = "<div class=\"row\">";
                $outContents .= "<div class=\"col-2\">";
					$outContents .= "<a href=\"terminal_selected?id=$trmnl->id\">";
					$outContents .= $trmnl->trmnl_name;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-3\">";
					$outContents .= "<a href=\"terminal_selected?id=$trmnl->id\">";
					$outContents .= $trmnl->trmnl_address;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-2\">";
					$outContents .= "<a href=\"terminal_selected?id=$trmnl->id\">";
					$outContents .= $trmnl->trmnl_city;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-1\">";
					$outContents .= "<a href=\"terminal_selected?id=$trmnl->id\">";
					$outContents .= $trmnl->trmnl_province;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-2\">";
					$outContents .= "<a href=\"terminal_selected?id=$trmnl->id\">";
					$outContents .= $trmnl->trmnl_country;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-2\">";
					$outContents .= "<a href=\"terminal_selected?id=$trmnl->id\">";
					$outContents .= $trmnl->trmnl_area;
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
		{{echo  $trmnls->links(); }}
		{{echo "</row></div>"; }}
?>
@endsection

<script>
	function GetSearchResult1(search_by) {
		trmnl_search_value = document.getElementById('trmnl_search_input').value;
		if (trmnl_search_value) {
			param = search_by + '=' + trmnl_search_value;
			url = "{{ route('terminal_condition_selected', '::') }}";
			url = url.replace('::', param);
			document.location.href=url;
		}
	}
</script>