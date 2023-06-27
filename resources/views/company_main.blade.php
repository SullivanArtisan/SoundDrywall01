@extends('layouts.home_page_base')

@section('goback')
	<a class="text-primary" href="{{route('home_page')}}" style="margin-right: 10px;">Back</a>
@show

@section('function_page')
    <div>
        <div class="row m-4">
            <div>
				<h2 class="text-muted pl-2">Companies Addresses</h2>
            </div>
            <div class="col my-auto ml-5">
				<button class="btn btn-success mr-4" type="button"><a href="{{route('company_add')}}">Add</a></button>
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
		//$companies = \App\Models\Company::orderBy('cmpny_name', 'asc')->where('cmpny_deleted', null)->orwhere('cmpny_deleted', '<>', 'Y')->paginate(10);
        // Check if the page is refresed
        if (isset($_GET['sort_time'])) {
            if ($_GET['sort_time'] != session('sort_time', '0')) {
                session(['sort_time' => $_GET['sort_time']]);
                $needResort = true;
            }
            else {
                $needResort = false;
            }
            $sortKeyInput = $_GET['sort_key_company'];
        } else {
            $needResort = false;
            if (!isset($_GET['page'])) {
                $sortKeyInput = session('sort_key_company', '');
                if ($sortKeyInput == '') {
                    $sortKeyInput = 'cmpny_name';
                } 
            } else {
                $sortKeyInput = session('sort_key_company', 'cmpny_name');
            }
        }
            
        // Get data ordered by the user's intent
        $sort_icon = $sortOrder = session('sort_order', 'asc');
        $sortKey = session('sort_key_company', $sortKeyInput);
        if ($needResort == true) {
            if ($sortOrder == 'asc') {
                session(['sort_order' => 'desc']);
                $sort_icon = 'desc';
            } else {
                session(['sort_order' => 'asc']);
                $sort_icon = 'asc';
            }
            $companies = \App\Models\Company::orderBy($_GET['sort_key_company'], session('sort_order', 'asc'))->where('cmpny_deleted', null)->orwhere('cmpny_deleted', '<>', 'Y')->paginate(10);
            session(['sort_key_company' => $sortKeyInput]);
        } else {
            $companies = \App\Models\Company::orderBy($sortKey, $sortOrder)->where('cmpny_deleted', null)->orwhere('cmpny_deleted', '<>', 'Y')->paginate(10);
        }
                    
        
		// Title Line
		$outContents = "<div class=\"container mw-100\">";
        $outContents .= "<div class=\"row bg-info text-white fw-bold\">";
			$outContents .= "<div class=\"col align-middle\">";
				$sortParms = "?sort_key_company=cmpny_name&sort_time=".time();
				$outContents .= "<a href=\"company_main".$sortParms."\">";
				$outContents .= "Company Name";
				if ($sortKeyInput != 'cmpny_name') {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-dash-square\"></a></i>";
				} else {
					if ($sort_icon == 'asc') {
						$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-up-square\"></a></i>";
					} else {
						$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-down-square\"></a></i>";
					}
				}
            $outContents .= "</div>";
            $outContents .= "<div class=\"col align-middle\">";
				$outContents .= "Street Address";
            $outContents .= "</div>";
            $outContents .= "<div class=\"col align-middle\">";
                $sortParms = "?sort_key_company=cmpny_city&sort_time=".time();
                $outContents .= "<a href=\"company_main".$sortParms."\">";
                $outContents .= "City";
                if ($sortKeyInput != 'cmpny_city') {
                    $outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-dash-square\"></a></i>";
                } else {
                    if ($sort_icon == 'asc') {
                        $outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-up-square\"></a></i>";
                    } else {
                        $outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-down-square\"></a></i>";
                    }
                }
            $outContents .= "</div>";
			$outContents .= "<div class=\"col align-middle\">";
                $sortParms = "?sort_key_company=cmpny_province&sort_time=".time();
                $outContents .= "<a href=\"company_main".$sortParms."\">";
                $outContents .= "Province";
                if ($sortKeyInput != 'cmpny_province') {
                    $outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-dash-square\"></a></i>";
                } else {
                    if ($sort_icon == 'asc') {
                        $outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-up-square\"></a></i>";
                    } else {
                        $outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-down-square\"></a></i>";
                    }
                }
            $outContents .= "</div>";
			$outContents .= "<div class=\"col align-middle\">";
                $sortParms = "?sort_key_company=cmpny_postcode&sort_time=".time();
                $outContents .= "<a href=\"company_main".$sortParms."\">";
                $outContents .= "Post Code";
                if ($sortKeyInput != 'cmpny_postcode') {
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
		foreach ($companies as $company) {
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
		
		{{echo "<div class=\"col-1\"><row><p>&nbsp</p></row><row>"; }}
		{{echo  $companies->links(); }}
		{{echo "</row></div>"; }}
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