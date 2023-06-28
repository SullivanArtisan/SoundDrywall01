@extends('layouts.home_page_base')

@section('goback')
	<a class="text-primary" href="{{route('staff_main')}}" style="margin-right: 10px;">Back</a>
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
					$page_head = "<h2 class=\"text-muted pl-2\">Staffs Searched Results (by ";
					if ($key == 'id') {
						$page_head .= "Staff Id)</h2>";
					} else if ($key == 'l_name') {
						$page_head .= "Staff Last Name)</h2>";
					} else if ($key == 'email') {
						$page_head .= "Staff Email)</h2>";
					}
					echo $page_head;
				?>
            </div>
            <div class="col">
				<div class="input-group">
				  <input type="text" class="form-control" aria-label="Text input with dropdown button" id="staff_search_input">
				  <div class="input-group-append">
					<button class="btn btn-info ml-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Search</button>
					<div class="dropdown-menu">
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult('id')\" style=\"cursor: pointer;\">by Staff Id</button>");</script>
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult('name')\" style=\"cursor: pointer;\">by Staff Last Name</button>");</script>
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult('email')\" style=\"cursor: pointer;\">by Staff Email</button>");</script>
					</div>
				  </div>
				</div>			
			</div>
        </div>
    </div>
	<?php
		$staffs = \App\Models\Staff::where($key, $value_parm)->get();
		
		// Title Line
		$outContents = "<div class=\"container mw-100\">";
        $outContents .= "<div class=\"row bg-info text-white fw-bold\">";
            $outContents .= "<div class=\"col-3 align-middle\">";
                $outContents .= "First Name";
            $outContents .= "</div>";
			$outContents .= "<div class=\"col-3 align-middle\">";
				$outContents .= "First Name";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-3\">";
				$outContents .= "Email";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-3\">";
				$outContents .= "Mobile Phone";
			$outContents .= "</div>";
		$outContents .= "</div><hr class=\"m-1\"/>";
		{{echo $outContents;}}
		
		// Body Lines
		foreach ($staffs as $staff) {
            $outContents = "<div class=\"row\">";
				$outContents .= "<div class=\"col-3\">";
					$outContents .= "<a href=\"staff_selected?id=$staff->id\">";
					$outContents .= $staff->f_name;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-3\">";
					$outContents .= "<a href=\"staff_selected?id=$staff->id\">";
					$outContents .= $staff->l_name;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-3\">";
					$outContents .= "<a href=\"staff_selected?id=$staff->id\">";
					$outContents .= $staff->email;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-3\">";
					$outContents .= "<a href=\"staff_selected?id=$staff->id\">";
					$outContents .= $staff->mobile_phone;
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
		staff_search_value = document.getElementById('staff_search_input').value;
		if (staff_search_value) {
			param = search_by + '=' + staff_search_value;
			url = "{{ route('staff_condition_selected', '::') }}";
			url = url.replace('::', param);
			document.location.href=url;
		}
	}
</script>