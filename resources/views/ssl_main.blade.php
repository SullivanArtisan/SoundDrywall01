@extends('layouts.home_page_base')

@section('goback')
	<a class="text-primary" href="{{route('home_page')}}" style="margin-right: 10px;">Back</a>
@show

@section('function_page')
    <div>
        <div class="row m-4">
            <div>
				<h2 class="text-muted pl-2">Steamshp Lines</h2>
            </div>
            <div class="col my-auto ml-5">
				<button class="btn btn-success mr-4" type="button"><a href="{{route('ssl_add')}}">Add</a></button>
			</div>
            <div class="col">
				<div class="input-group">
				  <input type="text" class="form-control" aria-label="Text input with dropdown button" id="ssl_search_input">
                  <button class="btn btn-info ml-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="GetSearchResult('ssl_name')">Search</button>
				</div>			
			</div>
        </div>
    </div>
	<?php
		$ssls = \App\Models\SteamShipLine::orderBy('ssl_name', 'asc')->where('deleted', null)->orwhere('deleted', '<>', 'Y')->paginate(10);
		
		// Title Line
		$outContents = "<div class=\"container mw-100\">";
        $outContents .= "<div class=\"row bg-info text-white fw-bold\">";
			$outContents .= "<div class=\"col-3 align-middle\">";
				$outContents .= "SSL Name";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-3 align-middle\">";
				$outContents .= "SSL Description";
			$outContents .= "</div>";
		$outContents .= "</div><hr class=\"m-2\"/>";
		{{echo $outContents;}}
		
		// Body Lines
		foreach ($ssls as $ssl) {
            $outContents = "<div class=\"row\">";
                $outContents .= "<div class=\"col-3\">";
                $outContents .= "<a href=\"ssl_selected?id=$ssl->id\">";
				$outContents .= $ssl->ssl_name;
                $outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-3\">";
                $outContents .= "<a href=\"ssl_selected?id=$ssl->id\">";
				$outContents .= $ssl->ssl_description;
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
		{{echo  $ssls->links(); }}
		{{echo "</row></div>"; }}
?>
@endsection

<script>
	function GetSearchResult(search_by) {
		ssl_search_value = document.getElementById('ssl_search_input').value;
		if (ssl_search_value) {
			param = search_by + '=' + ssl_search_value;
			url = "{{ route('ssl_condition_selected', '::') }}";
			url = url.replace('::', param);
			document.location.href=url;
		}
	}
</script>