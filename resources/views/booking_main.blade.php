@extends('layouts.home_page_base')

@section('goback')
	<a class="text-primary" href="{{route('home_page')}}" style="margin-right: 10px;">Back</a>
@show

@section('function_page')
	<!--
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
	-->
	
	<style>
		.nav-tabs .nav-item .nav-link {
		  background-color: #A9DFBF;
		  color: #FFF;
		  -webkit-border-top-left-radius: 10px;
		  -webkit-border-top-right-radius: 10px;
		  -moz-border-radius-topleft: 10px;
		  -moz-border-radius-topright: 10px;
		  border-top-left-radius: 10px;
		  border-top-right-radius: 10px; 
		}

		.nav-tabs .nav-item .nav-link.active {
		  background-color: #FFF;
		  color: #117A65;
		  font-weight: bold;
		  -webkit-border-top-left-radius: 10px;
		  -webkit-border-top-right-radius: 10px;
		  -moz-border-radius-topleft: 10px;
		  -moz-border-radius-topright: 10px;
		  border-top-left-radius: 10px;
		  border-top-right-radius: 10px; 
		}

		.tab-content {
		  border: 1px solid #dee2e6;
		  border-top: transparent;
		  padding: 1px;
		}

		.tab-content .tab-pane {
		  background-color: #FFF;
		  color: #A9DFBF;
		  min-height: 200px;
		  height: auto;
		  padding: 10px 14px;
		}	
	</style>

    <div>
        <div class="row m-4">
            <div>
				<h2 class="text-muted pl-2">All Bookings</h2>
            </div>
            <div class="col my-auto ml-5">
				<button class="btn btn-success mr-4" type="button"><a href="booking_add?bookingTab=''">Add</a></button>
			</div>
        </div>
    </div>
	<?php
        use App\Helper\MyHelper;

		// Check if the page is refresed
		if (isset($_GET['sort_time'])) {
			if ($_GET['sort_time'] != session('sort_time', '0')) {
				session(['sort_time' => $_GET['sort_time']]);
				$needResort = true;
			}
			else {
				$needResort = false;
			}
			$sortKeyInput = $_GET['sort_key_booking'];
		} else {
			$needResort = false;
			if (!isset($_GET['page'])) {
				$sortKeyInput = session('sort_key_booking', '');
				if ($sortKeyInput == '') {
					$sortKeyInput = 'bk_job_no';
				} 
			} else {
				$sortKeyInput = session('sort_key_booking', 'bk_job_no');
			}
		}
			
		// Get data ordered by the user's intent
		$sort_icon = $sortOrder = session('sort_order', 'asc');
		$sortKey = session('sort_key_booking', $sortKeyInput);
		if ($needResort == true) {
			if ($sortOrder == 'asc') {
				session(['sort_order' => 'desc']);
				$sort_icon = 'desc';
			} else {
				session(['sort_order' => 'asc']);
				$sort_icon = 'asc';
			}
			$bookings = \App\Models\Booking::orderBy($_GET['sort_key_booking'], session('sort_order', 'asc'))->where('bk_status', null)->orwhere('bk_status', '<>', 'deleted')->paginate(10);
			session(['sort_key_booking' => $sortKeyInput]);
		} else {
			$bookings = \App\Models\Booking::orderBy($sortKey, $sortOrder)->where('bk_status', null)->orwhere('bk_status', '<>', 'deleted')->paginate(10);
		}
				
		// Title Line
		$outContents = "<div class=\"container mw-100\">";
        $outContents .= "<div class=\"row bg-info text-white fw-bold\">";
			$outContents .= "<div class=\"col-1 align-middle\">";
				$sortParms = "?sort_key_booking=bk_job_no&sort_time=".time();
				$outContents .= "<a href=\"booking_main".$sortParms."\">";
				$outContents .= "Job No";
				if ($sortKeyInput != 'bk_job_no') {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-dash-square\"></a></i>";
				} else {
					if ($sort_icon == 'asc') {
						$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-up-square\"></a></i>";
					} else {
						$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-down-square\"></a></i>";
					}
				}
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$sortParms = "?sort_key_booking=bk_cstm_account_no&sort_time=".time();
				$outContents .= "<a href=\"booking_main".$sortParms."\">";
				$outContents .= "Acc No";
				if ($sortKeyInput != 'bk_cstm_account_no') {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-dash-square\"></a></i>";
				} else {
					if ($sort_icon == 'asc') {
						$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-up-square\"></a></i>";
					} else {
						$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-down-square\"></a></i>";
					}
				}
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-3\">";
				$outContents .= "Customer";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$sortParms = "?sort_key_booking=bk_job_type&sort_time=".time();
				$outContents .= "<a href=\"booking_main".$sortParms."\">";
				$outContents .= "Job Type";
				if ($sortKeyInput != 'bk_job_type') {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-dash-square\"></a></i>";
				} else {
					if ($sort_icon == 'asc') {
						$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-up-square\"></a></i>";
					} else {
						$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-down-square\"></a></i>";
					}
				}
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2\">";
				$outContents .= "Start";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2\">";
				$outContents .= "Finish";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1 mt-1\">";
				$sortParms = "?sort_key_booking=bk_status&sort_time=".time();
				$outContents .= "<a href=\"booking_main".$sortParms."\">";
				$outContents .= "<small>Status</small>";
				if ($sortKeyInput != 'bk_status') {
					$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-dash-square\"></a></i>";
				} else {
					if ($sort_icon == 'asc') {
						$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-up-square\"></a></i>";
					} else {
						$outContents .= "<span class=\"ml-2\"></span><i class=\"bi bi-caret-down-square\"></a></i>";
					}
				}
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1 mt-1\">";
				$sortParms = "?sort_key_booking=bk_total_containers&sort_time=".time();
				$outContents .= "<a href=\"booking_main".$sortParms."\">";
				$outContents .= "<small>Containers</small>";
				if ($sortKeyInput != 'bk_total_containers') {
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
		foreach ($bookings as $booking) {
            $cmpny_start = \App\Models\Company::where('id', $booking->bk_pickup_cmpny_id)->get();
            $cmpny_finish = \App\Models\Company::where('id', $booking->bk_delivery_cmpny_id)->get();
			$containers = \App\Models\Container::where('cntnr_job_no', $booking->bk_job_no)->get();
            $outContents = "<div class=\"row\">";
                $outContents .= "<div class=\"col-1\">";
					$outContents .= "<a href=\"booking_selected?selJobId=$booking->id\">";
					$outContents .= $booking->bk_job_no;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-1\">";
					$outContents .= "<a href=\"booking_selected?selJobId=$booking->id\">";
					$outContents .= $booking->bk_cstm_account_no;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-3\">";
					$outContents .= "<a href=\"booking_selected?selJobId=$booking->id\">";
					$outContents .= $booking->bk_cstm_account_name;
					$outContents .= "</a>";
				$outContents .= "</div>";
                $outContents .= "<div class=\"col-1\">";
					$outContents .= "<a href=\"booking_selected?selJobId=$booking->id\">";
					$outContents .= $booking->bk_job_type;
					$outContents .= "</a>";
				$outContents .= "</div>";
				$outContents .= "<div class=\"col-2\">";
					$outContents .= "<a href=\"booking_selected?selJobId=$booking->id\">";
					$outContents .= $cmpny_start;
					$outContents .= "</a>";
				$outContents .= "</div>";
				$outContents .= "<div class=\"col-2\">";
					$outContents .= "<a href=\"booking_selected?selJobId=$booking->id\">";
					$outContents .= $cmpny_finish;
					$outContents .= "</a>";
				$outContents .= "</div>";
				$outContents .= "<div class=\"col-1\">";
					$outContents .= "<a href=\"booking_selected?selJobId=$booking->id\">";
					
					$total_cntnrs = 0;
					$sent_cntnrs  = 0;
					$outContents .= "<small>".$booking->bk_status."</small>";
					$outContents .= "</a>";
				$outContents .= "</div>";
				$outContents .= "<div class=\"col-1\">";
					$outContents .= "<a href=\"booking_selected?selJobId=$booking->id\">";
					$outContents .= "<small>".$booking->bk_total_containers."</small>";
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
		{{echo  $bookings->links(); }}
		{{echo "</row></div>"; }}
	?>
@endsection
