@extends('layouts.home_page_base')

@section('goback')
	<a class="text-primary" href="{{route('terminal_main')}}" style="margin-right: 10px;">Back</a>
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
					$page_head = "<h2 class=\"text-muted pl-2\">Terminals Searched Results (by ";
					if ($key == 'trmnl_name') {
						$page_head .= "Terminal Name)</h2>";
					} else if ($key == 'trmnl_city') {
						$page_head .= "City)</h2>";
					} else if ($key == 'trmnl_province') {
						$page_head .= "Province)</h2>";
					} else if ($key == 'trmnl_country') {
						$page_head .= "Country)</h2>";
					} else if ($key == 'trmnl_area') {
						$page_head .= "Area)</h2>";
					}
					echo $page_head;
				?>
            </div>
            <div class="col">
				<div class="input-group">
				  <input type="text" class="form-control" aria-label="Text input with dropdown button" id="trmnl_search_input">
				  <div class="input-group-append">
					<button class="bt btn-info ml-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Search</button>
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
			$trmnls = \App\Models\Terminal::where($key, $value_parm)->orderBy('trmnl_name', session('sort_order', 'asc'))->get();
		} else {
			$trmnls = \App\Models\Terminal::where($key, $value_parm)->orderBy('trmnl_name', $sortOrder)->get();
		}
		
		// Title Line
		$outContents = "<div class=\"container mw-100\">";
        $outContents .= "<div class=\"row bg-info text-white fw-bold\">";
			$outContents .= "<div class=\"col-2 align-middle\">";
				$sortParms = "?".$key."=".$value_parm."&sort_key_terminal=trmnl_name&sort_time=".time();
				$outContents .= "<a href=\"terminal_condition_selected".$sortParms."\">";
				$outContents .= "Terminal";
				if ($sort_icon == 'asc') {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-up-square\"></a></i>";
				} else {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-down-square\"></a></i>";
				}
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-3\">";
				$outContents .= "Address";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2\">";
				$outContents .= "City";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "Province";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2\">";
				$outContents .= "Country";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2\">";
				$outContents .= "Area";
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