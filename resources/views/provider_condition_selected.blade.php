@extends('layouts.home_page_base')

@section('goback')
	<a class="text-primary" href="{{route('provider_main')}}" style="margin-right: 10px;">Back</a>
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
					$page_head = "<h2 class=\"text-muted pl-2\">Providers Searched Results (by ";
					if ($key == 'id') {
						$page_head .= "Provider Id)</h2>";
					} else if ($key == 'name') {
						$page_head .= "Provider Name)</h2>";
					} else if ($key == 'phone') {
						$page_head .= "Provider Phone)</h2>";
					}
					echo $page_head;
				?>
            </div>
            <div class="col">
				<div class="input-group">
				  <input type="text" class="form-control" aria-label="Text input with dropdown button" id="provider_search_input">
				  <div class="input-group-append">
					<button class="btn btn-info ml-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Search</button>
					<div class="dropdown-menu">
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult('id')\" style=\"cursor: pointer;\">by Provider Id</button>");</script>
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult('name')\" style=\"cursor: pointer;\">by Provider Name</button>");</script>
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult('email')\" style=\"cursor: pointer;\">by Provider Phone</button>");</script>
					</div>
				  </div>
				</div>			
			</div>
        </div>
    </div>
	<?php
		$providers = \App\Models\Provider::where($key, $value_parm)->get();
		
		// Title Line
		$outContents = "<div class=\"container mw-100\">";
        $outContents .= "<div class=\"row bg-info text-white fw-bold\">";
            $outContents .= "<div class=\"col-3 align-middle\">";
                $outContents .= "Provider Name";
            $outContents .= "</div>";
			$outContents .= "<div class=\"col-3 align-middle\">";
				$outContents .= "City";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-3\">";
				$outContents .= "Contact";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-3\">";
				$outContents .= "Phone";
			$outContents .= "</div>";
		$outContents .= "</div><hr class=\"m-1\"/>";
		{{echo $outContents;}}
		
		// Body Lines
		foreach ($providers as $provider) {
            $outContents = "<div class=\"row\">";
				$outContents .= "<div class=\"col-3\">";
					$outContents .= "<a href=\"provider_selected?id=$provider->id\">";
					$outContents .= $provider->pvdr_name;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-3\">";
					$outContents .= "<a href=\"provider_selected?id=$provider->id\">";
					$outContents .= $provider->pvdr_city;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-3\">";
					$outContents .= "<a href=\"provider_selected?id=$provider->id\">";
					$outContents .= $provider->pvdr_contact;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-3\">";
					$outContents .= "<a href=\"provider_selected?id=$provider->id\">";
					$outContents .= $provider->pvdr_phone;
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
		provider_search_value = document.getElementById('provider_search_input').value;
		if (provider_search_value) {
			param = search_by + '=' + provider_search_value;
			url = "{{ route('provider_condition_selected', '::') }}";
			url = url.replace('::', param);
			document.location.href=url;
		}
	}
</script>