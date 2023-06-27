@extends('layouts.home_page_base')

@section('goback')
	<a class="text-primary" href="{{route('home_page')}}" style="margin-right: 10px;">Back</a>
@show

@section('function_page')
	<!--
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
	-->
	
	<style>
		.nav-tabs .nav-item .nav-link {
		  background-color: #A9DFBF;
		  color: #FFF;
		  -webkit-border-top-left-radius: 10px;
		  -webkit-border-top-right-radius: 10px;
		  -moz-border-radius-topleft: 10px;
		  -moz-border-radius-topright: 10px;
		  border-top-left-radius: 10px;
		  border-top-right-radius: 10px; 
		}

		.nav-tabs .nav-item .nav-link.active {
		  background-color: #FFF;
		  color: #117A65;
		  font-weight: bold;
		  -webkit-border-top-left-radius: 10px;
		  -webkit-border-top-right-radius: 10px;
		  -moz-border-radius-topleft: 10px;
		  -moz-border-radius-topright: 10px;
		  border-top-left-radius: 10px;
		  border-top-right-radius: 10px; 
		}

		.tab-content {
		  border: 1px solid #dee2e6;
		  border-top: transparent;
		  padding: 1px;
		}

		.tab-content .tab-pane {
		  background-color: #FFF;
		  color: #A9DFBF;
		  min-height: 200px;
		  height: auto;
		  padding: 10px 14px;
		}	
	</style>

    <div>
        <div class="row m-4">
            <div>
				<h2 class="text-muted pl-2">Drivers</h2>
            </div>
            <div class="col my-auto ml-5">
				<button class="btn btn-success mr-4" type="button"><a href="{{route('driver_add')}}">Add</a></button>
			</div>
            <div class="col">
				<div class="input-group">
				  <input type="text" class="form-control" aria-label="Text input with dropdown button" id="driver_search_input">
				  <div class="input-group-append">
					<button class="btn btn-info ml-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Search</button>
					<div class="dropdown-menu">
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult('dvr_no')\" style=\"cursor: pointer;\">by Driver No.</button>");</script>
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult('dvr_name')\" style=\"cursor: pointer;\">by Driver Name</button>");</script>
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult('dvr_cell_phone')\" style=\"cursor: pointer;\">by Cell Phone</button>");</script>
					</div>
				  </div>
				</div>			
			</div>
        </div>
    </div>
	<?php
        use App\Helper\MyHelper;

		// Check if the page is refresed
		if (isset($_GET['sort_time'])) {
			if ($_GET['sort_time'] != session('sort_time', '0')) {
				session(['sort_time' => $_GET['sort_time']]);
				$needResort = true;
			}
			else {
				$needResort = false;
			}
			$sortKeyInput = $_GET['sort_key_driver'];
		} else {
			$needResort = false;
			if (!isset($_GET['page'])) {
				$sortKeyInput = session('sort_key_driver', '');
				if ($sortKeyInput == '') {
					$sortKeyInput = 'dvr_no';
				} 
			} else {
				$sortKeyInput = session('sort_key_driver', 'dvr_no');
			}
		}
			
		// Get data ordered by the user's intent
		$sort_icon = $sortOrder = session('sort_order', 'asc');
		$sortKey = session('sort_key_driver', $sortKeyInput);
		if ($needResort == true) {
			if ($sortOrder == 'asc') {
				session(['sort_order' => 'desc']);
				$sort_icon = 'desc';
			} else {
				session(['sort_order' => 'asc']);
				$sort_icon = 'asc';
			}
			$drivers = \App\Models\Driver::orderBy($_GET['sort_key_driver'], session('sort_order', 'asc'))->where('dvr_deleted', null)->orwhere('dvr_deleted', '<>', 'Y')->paginate(10);
			session(['sort_key_driver' => $sortKeyInput]);
		} else {
			$drivers = \App\Models\Driver::orderBy($sortKey, $sortOrder)->where('dvr_deleted', null)->orwhere('dvr_deleted', '<>', 'Y')->paginate(10);
		}
				
		// Title Line
		$outContents = "<div class=\"container mw-100\">";
        $outContents .= "<div class=\"row bg-info text-white fw-bold\">";
			$outContents .= "<div class=\"col-1 align-middle\">";
				$sortParms = "?sort_key_driver=dvr_no&sort_time=".time();
				$outContents .= "<a href=\"driver_main".$sortParms."\">";
				$outContents .= "DriverNo";
				if ($sortKeyInput != 'dvr_no') {
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
				$sortParms = "?sort_key_driver=dvr_name&sort_time=".time();
				$outContents .= "<a href=\"driver_main".$sortParms."\">";
				$outContents .= "Name";
				if ($sortKeyInput != 'dvr_name') {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-dash-square\"></a></i>";
				} else {
					if ($sort_icon == 'asc') {
						$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-up-square\"></a></i>";
					} else {
						$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-down-square\"></a></i>";
					}
				}
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-4\">";
				$outContents .= "Address";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2\">";
				$sortParms = "?sort_key_driver=dvr_cell_phone&sort_time=".time();
				$outContents .= "<a href=\"driver_main".$sortParms."\">";
				$outContents .= "CellPhone";
				if ($sortKeyInput != 'dvr_cell_phone') {
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
				$sortParms = "?sort_key_driver=dvr_email&sort_time=".time();
				$outContents .= "<a href=\"driver_main".$sortParms."\">";
				$outContents .= "Email";
				if ($sortKeyInput != 'dvr_email') {
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
		foreach ($drivers as $driver) {
            $outContents = "<div class=\"row\">";
                $outContents .= "<div class=\"col-1\">";
					$outContents .= "<a href=\"driver_selected?driverId=$driver->id\">";
					$outContents .= $driver->dvr_no;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-2\">";
					$outContents .= "<a href=\"driver_selected?driverId=$driver->id\">";
					$outContents .= $driver->dvr_name;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-4\">";
					$outContents .= "<a href=\"driver_selected?driverId=$driver->id\">";
					$outContents .= $driver->dvr_address.", ".$driver->dvr_city.", ".$driver->dvr_province;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-2\">";
					$outContents .= "<a href=\"driver_selected?driverId=$driver->id\">";
					$outContents .= MyHelper::GetHyphenedPhoneNo($driver->dvr_cell_phone);
					$outContents .= "</a>";
				$outContents .= "</div>";
				$outContents .= "<div class=\"col-3\">";
					$outContents .= "<a href=\"driver_selected?driverId=$driver->id\">";
					$outContents .= $driver->dvr_email;
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
		{{echo  $drivers->links(); }}
		{{echo "</row></div>"; }}
	?>
@endsection

<script>
	function GetSearchResult(search_by) {
		unit_search_value = document.getElementById('driver_search_input').value;
		if (unit_search_value) {
			param = search_by + '=' + unit_search_value;
			url = "{{ route('driver_condition_selected', '::') }}";
			url = url.replace('::', param);
			document.location.href=url;
		}
	}
</script>