@extends('layouts.home_page_base')

@section('goback')
	<a class="text-primary" href="{{route('system_user_main')}}" style="margin-right: 10px;">Back</a>
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
					$page_head = "<h2 class=\"text-muted pl-2\">System Users Searched Results (by ";
					if ($key == 'id') {
						$page_head .= "User Id)</h2>";
					} else if ($key == 'name') {
						$page_head .= "User Name)</h2>";
					} else if ($key == 'email') {
						$page_head .= "User Email)</h2>";
					}
					echo $page_head;
				?>
            </div>
            <div class="col">
				<div class="input-group">
				  <input type="text" class="form-control" aria-label="Text input with dropdown button" id="user_search_input">
				  <div class="input-group-append">
					<button class="btn btn-info ml-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Search</button>
					<div class="dropdown-menu">
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult('id')\" style=\"cursor: pointer;\">by User Id</button>");</script>
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult('name')\" style=\"cursor: pointer;\">by User Name</button>");</script>
					  <script>document.write("<button class=\"dropdown-item\" onclick=\"GetSearchResult('email')\" style=\"cursor: pointer;\">by User Email</button>");</script>
					</div>
				  </div>
				</div>			
			</div>
        </div>
    </div>
	<?php
		use App\Models\UserSysDetail;
		
		$users = \App\Models\User::where($key, $value_parm)->get();
		
		// Title Line
		$outContents = "<div class=\"container mw-100\">";
        $outContents .= "<div class=\"row bg-info text-white fw-bold\">";
			$outContents .= "<div class=\"col-2 align-middle\">";
				$outContents .= "Name";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-3\">";
				$outContents .= "Email";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2\">";
				$outContents .= "Security Level";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "Docket Prefix";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "Next Docket #";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "Ops Code";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "Current Office";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "Default Office";
			$outContents .= "</div>";
		$outContents .= "</div><hr class=\"m-1\"/>";
		{{echo $outContents;}}
		
		// Body Lines
		foreach ($users as $user) {
			$userDetails = UserSysDetail::where('user_id', $user->id)->first();
            $outContents = "<div class=\"row\">";
                $outContents .= "<div class=\"col-2\">";
					$outContents .= "<a href=\"system_user_selected?id=$user->id\">";
					$outContents .= $user->name;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-3\">";
					$outContents .= "<a href=\"system_user_selected?id=$user->id\">";
					$outContents .= $user->email;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-2\">";
					$outContents .= "<a href=\"system_user_selected?id=$user->id\">";
					$outContents .= $user->security_level;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-1\">";
					$outContents .= "<a href=\"system_user_selected?id=$user->id\">";
					$outContents .= $user->docket_prefix;
					$outContents .= "</a>";
				$outContents .= "</div>";
				if ($userDetails) {
					$outContents .= "<div class=\"col-1\">";
						$outContents .= "<a href=\"system_user_selected?id=$user->id\">";
						$outContents .= $user->next_docket_number;
						$outContents .= "</a>";
					$outContents .= "</div>";
					$outContents .= "<div class=\"col-1\">";
						$outContents .= "<a href=\"system_user_selected?id=$user->id\">";
						$outContents .= $userDetails->ops_code;
						$outContents .= "</a>";
					$outContents .= "</div>";
					$outContents .= "<div class=\"col-1\">";
						$outContents .= "<a href=\"system_user_selected?id=$user->id\">";
						$outContents .= $userDetails->current_office;
						$outContents .= "</a>";
					$outContents .= "</div>";
					$outContents .= "<div class=\"col-1\">";
						$outContents .= "<a href=\"system_user_selected?id=$user->id\">";
						$outContents .= $userDetails->default_office;
						$outContents .= "</a>";
					$outContents .= "</div>";
				}
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
		user_search_value = document.getElementById('user_search_input').value;
		if (user_search_value) {
			param = search_by + '=' + user_search_value;
			url = "{{ route('system_user_condition_selected', '::') }}";
			url = url.replace('::', param);
			document.location.href=url;
		}
	}
</script>