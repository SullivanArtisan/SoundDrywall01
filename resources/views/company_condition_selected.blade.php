@extends('layouts.home_page_base')

@section('goback')
	<a class="text-primary" href="{{route('company_main')}}" style="margin-right: 10px;">Back</a>
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
					$page_head = "<h2 class=\"text-muted pl-2\">Companies Addresses Searched Results</h2>";
					echo $page_head;
				?>
            </div>
            <div class="col">
				<div class="input-group">
				  <input type="text" class="form-control" aria-label="Text input with dropdown button" id="company_search_input">
                  <div class="input-group-append">
                    <button class="btn btn-info ml-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Search</button>
                    <div class="dropdown-menu">
                        <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult('cmpny_name')\" style=\"cursor: pointer;\">by Company Name</button>");</script>
                        <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult('cmpny_address')\" style=\"cursor: pointer;\">by Company Address</button>");</script>
                        <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult('cmpny_city')\" style=\"cursor: pointer;\">by City</button>");</script>
                        <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult('cmpny_postcode')\" style=\"cursor: pointer;\">by Post Code</button>");</script>
                    </div>
                  </div>
                  <!--
                  <button class="btn btn-info ml-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="GetSearchResult('cmpny_name')">Search</button>
                  -->
                </div>			
			</div>
        </div>
    </div>
	<?php
        //Log::info("key = ".$key."; value = ".$value_parm);
        $companies = \App\Models\Company::where($key, 'LIKE', '%'.$value_parm.'%')->orderBy('cmpny_name', 'asc')->get();

        // Title Line
		$outContents = "<div class=\"container mw-100\">";
        $outContents .= "<div class=\"row bg-info text-white fw-bold\">";
			$outContents .= "<div class=\"col align-middle\">";
				$outContents .= "Company Name";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col align-middle\">";
				$outContents .= "Street Address";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col align-middle\">";
				$outContents .= "City";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col align-middle\">";
				$outContents .= "Province";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col align-middle\">";
				$outContents .= "Post Code";
			$outContents .= "</div>";
		$outContents .= "</div><hr class=\"m-2\"/>";
		{{echo $outContents;}}
		
		// Body Lines
		foreach ($companies as $company) {
            if ($company->cmpny_deleted == 'Y' || $company->cmpny_deleted == 'y') {
                continue;
            }
            $outContents = "<div class=\"row\">";
            $outContents .= "<div class=\"col\">";
            $outContents .= "<a href=\"company_selected?id=$company->id\">";
            $outContents .= $company->cmpny_name;
            $outContents .= "</a>";
            $outContents .= "</div>";
            $outContents .= "<div class=\"col\">";
            $outContents .= "<a href=\"company_selected?id=$company->id\">";
            $outContents .= $company->cmpny_address;
            $outContents .= "</a>";
            $outContents .= "</div>";
            $outContents .= "<div class=\"col\">";
            $outContents .= "<a href=\"company_selected?id=$company->id\">";
            $outContents .= $company->cmpny_city;
            $outContents .= "</a>";
            $outContents .= "</div>";
            $outContents .= "<div class=\"col\">";
            $outContents .= "<a href=\"company_selected?id=$company->id\">";
            $outContents .= $company->cmpny_province;
            $outContents .= "</a>";
            $outContents .= "</div>";
            $outContents .= "<div class=\"col\">";
            $outContents .= "<a href=\"company_selected?id=$company->id\">";
            $outContents .= $company->cmpny_postcode;
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
		company_search_value = document.getElementById('company_search_input').value;
		if (company_search_value) {
			param = search_by + '=' + company_search_value;
			url = "{{ route('company_condition_selected', '::') }}";
			url = url.replace('::', param);
			document.location.href=url;
		}
	}
</script>