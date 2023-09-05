@extends('layouts.home_page_base')

@section('goback')
	<a class="text-primary" href="{{route('home_page')}}" style="margin-right: 10px;">Back</a>
@show

@section('function_page')
    <div>
        <div class="row m-4">
            <div>
				<h2 class="text-muted pl-2">All Staff Actions</h2>
            </div>
            <div class="col my-auto ml-5">
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
		$sortKey = session('sort_key_staffAction', 'id');
		if ($needResort == true) {
			if ($sortOrder == 'asc') {
				session(['sort_order' => 'desc']);
				$sort_icon = 'desc';
			} else {
				session(['sort_order' => 'asc']);
				$sort_icon = 'asc';
			}
			$actions = \App\Models\StaffAction::orderBy($_GET['sort_key_staffAction'], session('sort_order', 'asc'))->paginate(50)->withQueryString();
			session(['sort_key_staffAction' => 'id']);
		} else {
            $actions = \App\Models\StaffAction::orderBy($sortKey, $sortOrder)->paginate(50)->withQueryString();
		}

		// Title Line
		$outContents = "<div class=\"container mw-100\">";
        $outContents .= "<div class=\"row bg-info text-white fw-bold\">";
			$outContents .= "<div class=\"col-1\">";
				$sortParms = "?sort_key_staffAction=id&sort_time=".time();
				$outContents .= "<a href=\"all_staff_actions".$sortParms."\">";
				$outContents .= "ID";
				if ($sort_icon == 'asc') {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-up-square\"></a></i>";
				} else {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-down-square\"></a></i>";
				}
				$outContents .= "</div>";
			$outContents .= "<div class=\"col-1 align-middle\">";
				$sortParms = "?sort_key_staffAction=staff_id&sort_time=".time();
				$outContents .= "<a href=\"all_staff_actions".$sortParms."\">";
				$outContents .= "Staff ID";
				if ($sort_icon == 'asc') {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-up-square\"></a></i>";
				} else {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-down-square\"></a></i>";
				}
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2\">";
				$outContents .= "Staff Name";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-3\">";
				$outContents .= "Action";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-4\">";
				$outContents .= "Action Result";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1 align-middle\">";
				$sortParms = "?sort_key_staffAction=staff_action_severity&sort_time=".time();
				$outContents .= "<a href=\"all_staff_actions".$sortParms."\">";
				$outContents .= "Severity";
				if ($sort_icon == 'asc') {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-up-square\"></a></i>";
				} else {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-down-square\"></a></i>";
				}
			$outContents .= "</div>";
		$outContents .= "</div><hr class=\"m-1\"/>";
		{{echo $outContents;}}
		
		// Body Lines
        $listed_items = 0;
		foreach ($actions as $action) {
                $listed_items++;
                if ($listed_items % 2) {
                    $bg_color = "Lavender";
                } else {
                    $bg_color = "PaleGreen";
                }
                $outContents = "<div class=\"row\">";
				$outContents .= "<div class=\"col-1\">";
					$outContents .= $action->id;
				$outContents .= "</div>";
				$outContents .= "<div class=\"col-1\">";
					$outContents .= $action->staff_id;
                $outContents .= "</div>";
                $staff = \App\Models\Staff::where('id', $action->staff_id)->where('status', '<>', 'DELETED')->first();
                $outContents .= "<div class=\"col-2\">";
                    if ($staff) {
                        $outContents .= $action->f_name.' '.$action->l_name;
                    }
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-3\">";
					$outContents .= $action->staff_action;
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-4\">";
					$outContents .= $action->staff_action_result;
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-1\">";
					$outContents .= $action->staff_action_severity;
				$outContents .= "</div>";
			$outContents .= "</div><hr class=\"m-1\"/>";
			{{ 					
				echo $outContents;;
			}}
		}
		$outContents = "</div>";
		{{echo $outContents;}}
		
		{{echo "<div class=\"col-1\"><row><p>&nbsp</p></row><row>"; }}
		{{echo  $actions->links(); }}
		{{echo "</row></div>"; }}
?>
@endsection

<script>
	window.onload = function() {
	}
</script>