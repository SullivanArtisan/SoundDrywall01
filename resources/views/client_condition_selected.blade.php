@extends('layouts.home_page_base')

@section('goback')
	<a class="text-primary" href="{{route('client_main')}}" style="margin-right: 10px;">Back</a>
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
					$page_head = "<h2 class=\"text-muted pl-2\">Clients Searched Results (by ";
					if ($key == 'id') {
						$page_head .= "Client Id)</h2>";
					} else if ($key == 'clnt_name') {
						$page_head .= "Client Name)</h2>";
					} else if ($key == 'phone') {
						$page_head .= "Client Phone)</h2>";
					}
					echo $page_head;
				?>
            </div>
            <div class="col">
				<div class="input-group">
				  <input type="text" class="form-control" aria-label="Text input with dropdown button" id="client_search_input">
				  <div class="input-group-append">
					<button class="btn btn-info ml-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Search</button>
					<div class="dropdown-menu">
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult('id')\" style=\"cursor: pointer;\">by Client Id</button>");</script>
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult('clnt_name')\" style=\"cursor: pointer;\">by Client Name</button>");</script>
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult('email')\" style=\"cursor: pointer;\">by Client Phone</button>");</script>
					</div>
				  </div>
				</div>			
			</div>
        </div>
    </div>
	<?php
		$clients = \App\Models\Client::where($key, $value_parm)->get();
		
		// Title Line
		$outContents = "<div class=\"container mw-100\">";
        $outContents .= "<div class=\"row bg-info text-white fw-bold\">";
            $outContents .= "<div class=\"col-3 align-middle\">";
                $outContents .= "Client Name";
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
		foreach ($clients as $client) {
            $outContents = "<div class=\"row\">";
				$outContents .= "<div class=\"col-3\">";
					$outContents .= "<a href=\"client_selected?id=$client->id\">";
					$outContents .= $client->clnt_name;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-3\">";
					$outContents .= "<a href=\"client_selected?id=$client->id\">";
					$outContents .= $client->clnt_city;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-3\">";
					$outContents .= "<a href=\"client_selected?id=$client->id\">";
					$outContents .= $client->clnt_contact;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-3\">";
					$outContents .= "<a href=\"client_selected?id=$client->id\">";
					$outContents .= $client->clnt_phone;
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
		client_search_value = document.getElementById('client_search_input').value;
		if (client_search_value) {
			param = search_by + '=' + client_search_value;
			url = "{{ route('client_condition_selected', '::') }}";
			url = url.replace('::', param);
			document.location.href=url;
		}
	}
</script>