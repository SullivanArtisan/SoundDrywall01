@extends('layouts.home_page_base')

@section('goback')
	<a class="text-primary" href="{{route('customer_main')}}" style="margin-right: 10px;">Back</a>
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
					$page_head = "<h2 class=\"text-muted pl-2\">Driver Pay Prices Searched Results (by ";
					if ($key == 'drvr_pay_price_zone_from') {
						$page_head .= "Zone From)</h2>";
					}else {
						$page_head .= "Zone To)</h2>";
					}
					echo $page_head;
				?>
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
		$prices = \App\Models\DriverPrices::where($key, $value_parm)->get();
		
		// Title Line
		$outContents = "<div class=\"container mw-100\">";
        $outContents .= "<div class=\"row bg-info text-white fw-bold\">";
			$outContents .= "<div class=\"col-3 align-middle\">";
				$sortParms = "?sort_key_price=drvr_pay_price_zone_from&sort_time=".time();
				$outContents .= "<a href=\"driver_pay_prices_main".$sortParms."\">";
				$outContents .= "Zone From";
				// if ($sortKeyInput != 'drvr_pay_price_zone_from') {
					// $outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-dash-square\"></a></i>";
				// } else {
					// if ($sort_icon == 'asc') {
						// $outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-up-square\"></a></i>";
					// } else {
						// $outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-down-square\"></a></i>";
					// }
				// }
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-3\">";
				$sortParms = "?sort_key_price=drvr_pay_price_zone_to&sort_time=".time();
				$outContents .= "<a href=\"driver_pay_prices_main".$sortParms."\">";
				$outContents .= "Zone To";
				// if ($sortKeyInput != 'drvr_pay_price_zone_to') {
					// $outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-dash-square\"></a></i>";
				// } else {
					// if ($sort_icon == 'asc') {
						// $outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-up-square\"></a></i>";
					// } else {
						// $outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-down-square\"></a></i>";
					// }
				// }
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