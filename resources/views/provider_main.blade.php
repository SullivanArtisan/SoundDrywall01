@extends('layouts.home_page_base')

@section('goback')
	<a class="text-primary" href="{{route('home_page')}}" style="margin-right: 10px;">Back</a>
@show

@section('function_page')
    <div>
        <div class="row m-4">
            <div>
				<h2 class="text-muted pl-2">Providers</h2>
            </div>
            <div class="col my-auto ml-5">
				<button class="btn btn-success mr-4" type="button"><a href="{{route('provider_add')}}">Add</a></button>
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
			
		// Get data ordered by the user's intent
		$sort_icon = $sortOrder = session('sort_order', 'asc');
		$sortKey = session('sort_key_provider', 'pvdr_name');
		if ($needResort == true) {
			if ($sortOrder == 'asc') {
				session(['sort_order' => 'desc']);
				$sort_icon = 'desc';
			} else {
				session(['sort_order' => 'asc']);
				$sort_icon = 'asc';
			}
			$providers = \App\Models\Provider::orderBy($_GET['sort_key_provider'], session('sort_order', 'asc'))->paginate(10);
			session(['sort_key_provider' => 'pvdr_name']);
		} else {
			$providers = \App\Models\Provider::orderBy($sortKey, $sortOrder)->paginate(10);
		}

		// Title Line
		$outContents = "<div class=\"container mw-100\">";
        $outContents .= "<div class=\"row bg-info text-white fw-bold\">";
			$outContents .= "<div class=\"col-3 align-middle\">";
				$sortParms = "?sort_key_provider=name&sort_time=".time();
				$outContents .= "<a href=\"provider_main".$sortParms."\">";
				$outContents .= "Provider Name";
				if ($sort_icon == 'asc') {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-up-square\"></a></i>";
				} else {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-down-square\"></a></i>";
				}
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-3\">";
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
		
		{{echo "<div class=\"col-1\"><row><p>&nbsp</p></row><row>"; }}
		{{echo  $providers->links(); }}
		{{echo "</row></div>"; }}
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