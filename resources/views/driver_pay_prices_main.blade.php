@extends('layouts.home_page_base')

@section('goback')
	<a class="text-primary" href="{{route('home_page')}}" style="margin-right: 10px;">Back</a>
@show

@section('function_page')
    <div>
        <div class="row m-4">
            <div>
				<h2 class="text-muted pl-2">Driver Pay Prices</h2>
            </div>
            <div class="col my-auto ml-5">
				<button class="btn btn-success mr-4" type="button"><a href="{{route('driver_pay_prices_add')}}">Add</a></button>
			</div>
            <div class="col">
				<div class="input-group">
				  <input type="text" class="form-control" aria-label="Text input with dropdown button" id="price_search_input">
				  <div class="input-group-append">
					<button class="btn btn-info ml-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Search</button>
					<div class="dropdown-menu">
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult1('drvr_pay_price_zone_from')\" style=\"cursor: pointer;\">by Zone From</button>");</script>
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult1('drvr_pay_price_zone_to')\" style=\"cursor: pointer;\">by Zone To</button>");</script>
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
			$sortKeyInput = $_GET['sort_key_price'];
		} else {
			$needResort = false;
			if (!isset($_GET['page'])) {
				$sortKeyInput = session('sort_key_price', '');
				if ($sortKeyInput == '') {
					$sortKeyInput = 'drvr_pay_price_zone_from';
				} 
			} else {
				$sortKeyInput = session('sort_key_price', 'drvr_pay_price_zone_from');
			}
		}
			
		// Get data ordered by the user's intent
		$sort_icon = $sortOrder = session('sort_order', 'asc');
		$sortKey = session('sort_key_price', $sortKeyInput);
		if ($needResort == true) {
			if ($sortOrder == 'asc') {
				session(['sort_order' => 'desc']);
				$sort_icon = 'desc';
			} else {
				session(['sort_order' => 'asc']);
				$sort_icon = 'asc';
			}
			$prices = \App\Models\DriverPrices::orderBy($_GET['sort_key_price'], session('sort_order', 'asc'))->paginate(10);
			session(['sort_key_price' => $sortKeyInput]);
		} else {
			$prices = \App\Models\DriverPrices::orderBy($sortKey, $sortOrder)->paginate(10);
		}
		
		// Title Line
		$outContents = "<div class=\"container mw-100\">";
        $outContents .= "<div class=\"row bg-info text-white fw-bold\">";
			$outContents .= "<div class=\"col-3 align-middle\">";
				$sortParms = "?sort_key_price=drvr_pay_price_zone_from&sort_time=".time();
				$outContents .= "<a href=\"driver_pay_prices_main".$sortParms."\">";
				$outContents .= "Zone From";
				if ($sortKeyInput != 'drvr_pay_price_zone_from') {
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
				$sortParms = "?sort_key_price=drvr_pay_price_zone_to&sort_time=".time();
				$outContents .= "<a href=\"driver_pay_prices_main".$sortParms."\">";
				$outContents .= "Zone To";
				if ($sortKeyInput != 'drvr_pay_price_zone_to') {
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
				$outContents .= "Chassis";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2\">";
				$outContents .= "Job Type";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "Charge";
			$outContents .= "</div>";
		$outContents .= "</div><hr class=\"m-2\"/>";
		{{echo $outContents;}}
		
		// Body Lines
		foreach ($prices as $price) {
            $outContents = "<div class=\"row\">";
                $outContents .= "<div class=\"col-3\">";
					$outContents .= "<a href=\"driver_pay_prices_selected?id=$price->id\">";
					$outContents .= $price->drvr_pay_price_zone_from;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-3\">";
					$outContents .= "<a href=\"driver_pay_prices_selected?id=$price->id\">";
					$outContents .= $price->drvr_pay_price_zone_to;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-3\">";
					$outContents .= "<a href=\driver_pay_prices_selected?id=$price->id\">";
					$outContents .= $price->drvr_pay_price_chassis;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-2\">";
					$outContents .= "<a href=\"driver_pay_prices_selected?id=$price->id\">";
					$outContents .= $price->drvr_pay_price_job_type;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-1\">";
					$outContents .= "<a href=\"driver_pay_prices_selected?id=$price->id\">";
					$outContents .= $price->drvr_pay_price_charge;
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
		{{echo  $prices->links(); }}
		{{echo "</row></div>"; }}
?>
@endsection

<script>
	function GetSearchResult1(search_by) {
		zone_search_value = document.getElementById('price_search_input').value;
		if (zone_search_value) {
			param = search_by + '=' + zone_search_value;
			url = "{{ route('driver_pay_prices_condition_selected', '::') }}";
			url = url.replace('::', param);
			document.location.href=url;
		}
	}
</script>