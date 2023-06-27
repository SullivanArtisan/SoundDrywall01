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
					$page_head = "<h2 class=\"text-muted pl-2\">Customer Searched Results (by ";
					if ($key == 'cstm_account_no') {
						$page_head .= "Account No)</h2>";
					} else if ($key == 'cstm_account_name') {
						$page_head .= "Customer Name)</h2>";
					} else {
						$page_head .= "City)</h2>";
					}
					echo $page_head;
				?>
            </div>
            <div class="col">
				<div class="input-group">
				  <input type="text" class="form-control" aria-label="Text input with dropdown button" id="customer_search_input">
				  <div class="input-group-append">
					<button class="btn btn-info ml-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Search</button>
					<div class="dropdown-menu">
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult('cstm_account_no')\" style=\"cursor: pointer;\">by Account No</button>");</script>
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult('cstm_account_name')\" style=\"cursor: pointer;\">by Customer Name</button>");</script>
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult('cstm_city')\" style=\"cursor: pointer;\">by City</button>");</script>
					</div>
				  </div>
				</div>			
			</div>
        </div>
    </div>
	<?php
		$customers = \App\Models\Customer::where($key, $value_parm)->orderBy('cstm_account_name', 'asc')->get();
		
		// Title Line
		$outContents = "<div class=\"container mw-100\">";
        $outContents .= "<div class=\"row bg-info text-white fw-bold\">";
			$outContents .= "<div class=\"col-1 align-middle\">";
				$sortParms = "?sort_key_customer=cstm_account_no&sort_time=".time();
				$outContents .= "<a href=\"customer_main".$sortParms."\">";
				$outContents .= "Account";
				// if ($sortKeyInput != 'cstm_account_no') {
					// $outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-dash-square\"></a></i>";
				// } else {
					// if ($sort_icon == 'asc') {
						// $outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-up-square\"></a></i>";
					// } else {
						// $outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-down-square\"></a></i>";
					// }
				// }
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2\">";
				$sortParms = "?sort_key_customer=cstm_account_name&sort_time=".time();
				$outContents .= "<a href=\"customer_main".$sortParms."\">";
				$outContents .= "Name";
				// if ($sortKeyInput != 'cstm_account_name') {
					// $outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-dash-square\"></a></i>";
				// } else {
					// if ($sort_icon == 'asc') {
						// $outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-up-square\"></a></i>";
					// } else {
						// $outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-down-square\"></a></i>";
					// }
				// }
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-4\">";
				$outContents .= "Address";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2\">";
				$sortParms = "?sort_key_customer=cstm_city&sort_time=".time();
				$outContents .= "<a href=\"customer_main".$sortParms."\">";
				$outContents .= "City";
				// if ($sortKeyInput != 'cstm_city') {
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
				$sortParms = "?sort_key_customer=cstm_contact_tel1&sort_time=".time();
				$outContents .= "<a href=\"customer_main".$sortParms."\">";
				$outContents .= "Phone";
				// if ($sortKeyInput != 'cstm_contact_tel1') {
					// $outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-dash-square\"></a></i>";
				// } else {
					// if ($sort_icon == 'asc') {
						// $outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-up-square\"></a></i>";
					// } else {
						// $outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-down-square\"></a></i>";
					// }
				// }
			$outContents .= "</div>";
		$outContents .= "</div><hr class=\"m-2\"/>";
		{{echo $outContents;}}
		
		// Body Lines
		foreach ($customers as $customer) {
			$outContents = "<div class=\"row\">";
				$outContents .= "<div class=\"col-1\">";
					$outContents .= "<a href=\"customer_selected?id=$customer->id\">";
					$outContents .= sprintf('%010d', $customer->cstm_account_no);
					$outContents .= "</a>";
				$outContents .= "</div>";
				$outContents .= "<div class=\"col-2\">";
					$outContents .= "<a href=\"customer_selected?id=$customer->id\">";
					$outContents .= $customer->cstm_account_name;
					$outContents .= "</a>";
				$outContents .= "</div>";
				$outContents .= "<div class=\"col-4\">";
					$outContents .= "<a href=\"customer_selected?id=$customer->id\">";
					$outContents .= $customer->cstm_address;
					$outContents .= "</a>";
				$outContents .= "</div>";
				$outContents .= "<div class=\"col-2\">";
					$outContents .= "<a href=\"customer_selected?id=$customer->id\">";
					$outContents .= $customer->cstm_city;
					$outContents .= "</a>";
				$outContents .= "</div>";
				$outContents .= "<div class=\"col-3\">";
					$outContents .= "<a href=\"customer_selected?id=$customer->id\">";
					$outContents .= $customer->cstm_contact_tel1;
					$outContents .= "</a>";
				$outContents .= "</div>";
			$outContents .= "</div><hr class=\"m-1\"/>";
			{{ 					
				echo $outContents;;
			}}
		}
	?>
@endsection

<script>
	function GetSearchResult(search_by) {
		unit_search_value = document.getElementById('customer_search_input').value;
		if (unit_search_value) {
			param = search_by + '=' + unit_search_value;
			url = "{{ route('customer_condition_selected', '::') }}";
			url = url.replace('::', param);
			document.location.href=url;
		}
	}
</script>