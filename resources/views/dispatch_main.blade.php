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
        
        div.newpointer {
            cursor: pointer;
        }
	</style>

    <div>
        <div class="row m-4">
            <div class="row">
                <div>
                    <h2 class="text-muted pl-2">Containers to Dispatch</h2>
                </div>
            </div>
        </div>
        <div class="row m-4">
                <p class="font-italic">To <span class="font-weight-bold text-info">dispatch => click</span> on that container. To <span class="font-weight-bold text-info">view => double click</span> it!</p>
        </div>
    </div>
	<?php
        use App\Helper\MyHelper;

        $bookings = \App\Models\Booking::where('bk_status', 'LIKE', '%'.MyHelper::BkCompletedStaus().'%')->get();
				
		// Title Line
		$outContents = "<div class=\"container mw-100\">";
        $outContents .= "<div class=\"row bg-info text-white fw-bold\">";
			$outContents .= "<div class=\"col-1 align-middle\">";
				$outContents .= "Truck";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "Driver";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "Job No";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "Job Type";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "Container";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "Size";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "Chassis";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "Pu Loc";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "Drop Loc";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "Status";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "Pu Date";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-1\">";
				$outContents .= "Pu Time";
			$outContents .= "</div>";
		$outContents .= "</div><hr class=\"m-2\"/>";
		{{echo $outContents;}}
		
		// Body Lines
        // Log::info("containers->count: ". $containers->count());
        $prevJobNo = "";
        $cntnrCountOfThisJob = 0;
		foreach ($bookings as $booking) {
            $containers = \App\Models\Container::orderBy('cntnr_job_no', 'asc')->where('cntnr_job_no', $booking->bk_job_no)->where('cntnr_status', MyHelper::CntnrSentStaus())->get();
            $totalCntnrsOfThisJob = $booking->bk_total_containers;
            foreach ($containers as $container) {
                $movement = \App\Models\Movement::orderBy('mvmt_order', 'asc')->where('mvmt_cntnr_name', $container->cntnr_name)->first();
                if ($prevJobNo != $container->cntnr_job_no) {
                    $prevJobNo = $container->cntnr_job_no;
                    $cntnrCountOfThisJob = 0;
                }
                $cntnrCountOfThisJob++;

                $outContents = "<div id=\"".$container->id."\" class=\"newpointer row\" onclick=\"doDispatch(this)\" ondblclick=\"doCntnrDetails()\">";
                $outContents .= "<div class=\"col-1\">";
                    $outContents .= $container->cntnr_pwr_unit_no_1;
                $outContents .= "</div>";
                $outContents .= "<div class=\"col-1\">";
                    $outContents .= $container->cntnr_dvr_no;
                $outContents .= "</div>";
                $outContents .= "<div class=\"col-1\">";
                    $outContents .= $container->cntnr_job_no."-".$cntnrCountOfThisJob.'/'.$totalCntnrsOfThisJob;
                $outContents .= "</div>";
                $outContents .= "<div class=\"col-1\">";
                    $outContents .= $booking->bk_job_type;
                $outContents .= "</div>";
                $outContents .= "<div class=\"col-1\">";
                    $outContents .= $container->cntnr_name;
                $outContents .= "</div>";
                $outContents .= "<div class=\"col-1\">";
                    $outContents .= $container->cntnr_size;
                $outContents .= "</div>";
                $outContents .= "<div class=\"col-1\">";
                    $outContents .= $container->cntnr_chassis_id;
                $outContents .= "</div>";
                $outContents .= "<div class=\"col-1\">";
                    $outContents .= $booking->bk_pickup_cmpny_name;
                $outContents .= "</div>";
                $outContents .= "<div class=\"col-1\">";
                    $outContents .= $booking->bk_delivery_cmpny_name;
                $outContents .= "</div>";
                $outContents .= "<div class=\"col-1\">";
                    $outContents .= $container->cntnr_status;
                $outContents .= "</div>";
                $outContents .= "<div class=\"col-1\">";
                    if (isset($movement->mvmt_operation_date)) {
                        $outContents .= $movement->mvmt_operation_date;
                    }
                $outContents .= "</div>";
                $outContents .= "<div class=\"col-1\">";
                    if (isset($movement->mvmt_operation_time_since)) {
                        $outContents .= $movement->mvmt_operation_time_since;
                    }
                $outContents .= "</div>";
                $outContents .= "</div><hr class=\"m-1\"/>";
                {{ 					
                    echo $outContents;;
                }}
            }
        }

		$outContents = "</div>";
		{{echo $outContents;}}
	?>

    <script>
    var timer;
    var status = 1;

    function doDispatch(el) {         // click button once
        status = 1;
        rowId = el.id;
        url   = './dispatch_container?cntnrId='+rowId;
        timer = setTimeout(function(url) { 
            if (status == 1) {
                window.location = url;
            } 
        }, 500, url);        
    }

    function doCntnrDetails() {     // click button twice
        clearTimeout(timer);
        status = 0;
        alert("This function is under construction!");
    }
    </script>
@endsection
