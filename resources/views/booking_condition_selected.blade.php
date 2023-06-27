@extends('layouts.home_page_base')

@section('goback')
	<a class="text-primary" href="{{route('driver_main')}}" style="margin-right: 10px;">Back</a>
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
					$page_head = "<h2 class=\"text-muted pl-2\">Driver Searched Results (by ";
					if ($key == 'dvr_no') {
						$page_head .= "Driver No.)</h2>";
					} else if ($key == 'dvr_name') {
						$page_head .= "Driver Name)</h2>";
					} else {
						$page_head .= "Driver Cell Phone)</h2>";
					}
					echo $page_head;
				?>
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

		$drivers = \App\Models\Driver::where($key, 'LIKE', '%'.$value_parm.'%')->orderBy('dvr_no', 'asc')->get();
		
		// Title Line
		$outContents = "<div class=\"container mw-100\">";
        $outContents .= "<div class=\"row bg-info text-white fw-bold\">";
			$outContents .= "<div class=\"col-1 align-middle\">";
				$sortParms = "?sort_key_driver=dvr_no&sort_time=".time();
				$outContents .= "<a href=\"driver_main".$sortParms."\">";
				$outContents .= "DriverNo";
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
				$sortParms = "?sort_key_driver=dvr_name&sort_time=".time();
				$outContents .= "<a href=\"driver_main".$sortParms."\">";
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
				$sortParms = "?sort_key_driver=dvr_cell_phone&sort_time=".time();
				$outContents .= "<a href=\"driver_main".$sortParms."\">";
				$outContents .= "CellPhone";
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
				$sortParms = "?sort_key_driver=dvr_email&sort_time=".time();
				$outContents .= "<a href=\"driver_main".$sortParms."\">";
				$outContents .= "Email";
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
		foreach ($drivers as $driver) {
            if ($driver->dvr_deleted == 'Y' || $driver->dvr_deleted == 'y') {
                continue;
            }
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