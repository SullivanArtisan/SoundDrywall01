@extends('layouts.home_page_base')

@section('goback')
	<a class="text-primary" href="{{route('home_page')}}" style="margin-right: 10px;">Back</a>
@show

@section('function_page')
    <div>
        <div class="row m-4">
            <div>
				<h2 class="text-muted pl-2">System Users</h2>
            </div>
            <div class="col my-auto ml-5">
				<button class="btn btn-success mr-4" type="button"><a href="{{route('system_user_add')}}">Add</a></button>
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
		$sortKey = session('sort_key_user', 'name');
		if ($needResort == true) {
			if ($sortOrder == 'asc') {
				session(['sort_order' => 'desc']);
				$sort_icon = 'desc';
			} else {
				session(['sort_order' => 'asc']);
				$sort_icon = 'asc';
			}
			$users = \App\Models\User::orderBy($_GET['sort_key_user'], session('sort_order', 'asc'))->paginate(10);
			////$users = \App\Models\User::sortable([$_GET['sort_key_user'] => session('sort_order', 'asc')])->paginate(10);		// If you want to use the Kyslik\ColumnSortable package (google the instruction for installation and usage)
			session(['sort_key_user' => 'name']);
		} else {
			$users = \App\Models\User::orderBy($sortKey, $sortOrder)->paginate(10);
			////$users = \App\Models\User::sortable([$sortKey => $sortOrder])->paginate(10);				// If you want to use the Kyslik\ColumnSortable package (google the instruction for installation and usage)
		}

		// Title Line
		$outContents = "<div class=\"container mw-100\">";
        $outContents .= "<div class=\"row bg-info text-white fw-bold\">";
			$outContents .= "<div class=\"col-2 align-middle\">";
				$sortParms = "?sort_key_user=name&sort_time=".time();
				$outContents .= "<a href=\"system_user_main".$sortParms."\">";
				$outContents .= "Name";
				if ($sort_icon == 'asc') {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-up-square\"></a></i>";
				} else {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-down-square\"></a></i>";
				}
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
		
		{{echo "<div class=\"col-1\"><row><p>&nbsp</p></row><row>"; }}
		{{echo  $users->links(); }}
		{{echo "</row></div>"; }}
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