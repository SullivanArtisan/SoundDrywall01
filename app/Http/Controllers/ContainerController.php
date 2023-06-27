<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Helper\MyHelper;
use Illuminate\Http\Request;
use App\Models\Container;
use App\Models\Booking;
use App\Models\Movement;
use App\Models\Driver;

class ContainerController extends Controller
{
    // Update the booking job's status
    public static function UpdateBookingStatus($booking) {
        $containers = Container::where('cntnr_job_no', $booking->bk_job_no)->get();
        
        $total_cntnrs = 0;
        $sent_cntnrs  = 0;
        $completed_cntnrs  = 0;
        foreach ($containers as $container) {
            if ($container->cntnr_status == MyHelper::CntnrCreatedStaus()) {
                $total_cntnrs++;
            } else if ($container->cntnr_status == MyHelper::CntnrSentStaus() || $container->cntnr_status == MyHelper::CntnrDispatchedStaus()) {
                $total_cntnrs++;
                $sent_cntnrs++;
            } else if ($container->cntnr_status == MyHelper::CntnrCompletedStaus()) {
                $total_cntnrs++;
                $completed_cntnrs++;
            }
        }

        if ($sent_cntnrs == 0) {
            // do nothing
        } else if ($completed_cntnrs > 0) { 
            $booking->bk_status = $completed_cntnrs."/".$total_cntnrs." ".MyHelper::BkCompletedStaus();
        } else if ($sent_cntnrs < $total_cntnrs) { 
            $booking->bk_status = $sent_cntnrs."/".$total_cntnrs." Sent";
        } else if ($sent_cntnrs == $total_cntnrs) {
            $booking->bk_status = "0/".$total_cntnrs." ".MyHelper::BkCompletedStaus();
        } else {
            // don't know yet
        }

        $booking->save();
    } 
 
    // Assign the container to the driver
    public static function AssignContainerToDriver($driverId, $cntnrId) {
        $driver = Driver::where('id', $driverId)->first();
        $container = Container::where('id', $cntnrId)->first();
        
        $container->cntnr_dvr_no        = $driver->dvr_no;
        $container->cntnr_pwr_unit_no_1 = $driver->dvr_pwr_unit_no_1;
        $container->cntnr_pwr_unit_no_2 = $driver->dvr_pwr_unit_no_2;
        $container->cntnr_status        = MyHelper::CntnrDispatchedStaus();
        $saved = $container->save();
		
		if(!$saved) {
			return redirect()->route('op_result.dispatch')->with('status', ' <span style="color:red">Container has NOT been dipatched!</span>');
		} else {
            return redirect()->route('op_result.dispatch', ['cntnrId'=>$cntnrId])->with('status', 'The container,  <span style="font-weight:bold;font-style:italic;color:blue">'.$container->cntnr_name.'</span>, has been dipatched to the driver '.$driver->dvr_no.' successfully. An email has also been sent him/her!');
        }
    } 
 
    public function add(Request $request)
    {
		$container = new Container;
		$container->cntnr_job_no        = $request->cntnr_job_no;
		$container->cntnr_name          = $request->cntnr_name;
		$container->cntnr_goods_desc    = $request->cntnr_goods_desc;
		$container->cntnr_status        = MyHelper::CntnrCreatedStaus();
		$saved = $container->save();
		
		$booking = Booking::where('bk_job_no', $request->cntnr_job_no)->first();
        $totalContainers = $booking->bk_total_containers;

        // Because the 'add' function is triggered by the Ajax function directly of the "Add this Container" button instead of the normal form's POST method through web.php's route,
        // the page's redirection in the following conditions is useless. 
        // In fact, the page's redirection is controlled in the callback function of Ajax function in the "Add this Container" button
        if(!$saved) {
            // return redirect()->route('booking_add', ['bookingResult'=>' <span style="color:red">(Failed to add the new container!)</span>', 'bookingTab'=>'containerinfo-tab', 'id'=>$booking->id]);
        } else {
            $totalContainers++;
            $booking->bk_total_containers = $totalContainers;
            $saved = $booking->save();
            this->UpdateBookingStatus($booking);

            $this->CreateInitialMovements($booking->id, $container->id, $container->cntnr_name, $booking->bk_job_type);
            // return view('home_page');
		}
    }

    public function update(Request $request)
    {
        Log::Info("HAHAHA");
		$validated = $request->validate([
			//'cntnr_name'              => 'required',
		]);

        if (isset($request->id)) {
            $id = $request->id;
        }
        if (isset($request->prevPage)) {
            $prevPage = $request->prevPage;
        }
        if (isset($request->selJobId)) {
            $selJobId = $request->selJobId;
        }
		
		$container = Container::where('id', $id)->first();
		// $container->cntnr_job_no              = $request->cntnr_job_no;
		// $container->cntnr_booking_no               = $request->cntnr_booking_no;
		$container->cntnr_name              = $request->cntnr_name;
		$container->cntnr_size              = $request->cntnr_size;
		if ($request->cntnr_droponly == 'on') {
			$container->cntnr_droponly = 'T';
		} else {
			$container->cntnr_droponly = 'F';
		}
		$container->cntnr_goods_desc             = $request->cntnr_goods_desc;
		$container->cntnr_ssl_release_date           = $request->cntnr_ssl_release_date;
		$container->cntnr_cstm_order_no            = $request->cntnr_cstm_order_no;
		$container->cntnr_cstm_release_date        = $request->cntnr_cstm_release_date;
		$container->cntnr_cstm_release_time         = $request->cntnr_cstm_release_time;
		$container->cntnr_trmnl_lfd            = $request->cntnr_trmnl_lfd;
		$container->cntnr_ssl_lfd   = $request->cntnr_ssl_lfd;
		$container->cntnr_mt_lfd       = $request->cntnr_mt_lfd;
		$container->cntnr_mt_release_no      = $request->cntnr_mt_release_no;
		$container->cntnr_empty_return_trmnl     = $request->cntnr_empty_return_trmnl;
		$container->cntnr_ssl    = $request->cntnr_ssl;
		$container->cntnr_seal_no    = $request->cntnr_seal_no;
		$container->cntnr_cargo_weight    = $request->cntnr_cargo_weight;
		if ($request->cntnr_weight_unit == 'Kgs') {
			$container->cntnr_weight_unit = 0;
		} else {
			$container->cntnr_weight_unit = 1;
		}
		$container->cntnr_chassis_type    = $request->cntnr_chassis_type;
		$container->cntnr_chassis_id    = $request->cntnr_chassis_id;

		$saved = $container->save();
		
		if(!$saved) {
			return redirect()->route('op_result.container')->with('status', ' <span style="color:red">Data has NOT been updated!</span>');
		} else {
            $booking = Booking::where('bk_job_no', $container->cntnr_job_no)->first();
            $this->UpdateBookingStatus($booking);
            if (!isset($request->prevPage)) {
                return redirect()->route('op_result.container', ['id'=>$request->id])->with('status', 'The container,  <span style="font-weight:bold;font-style:italic;color:blue">'.$container->cntnr_name.'</span>, has been updated successfully.');
            } else {
                return redirect()->route('op_result.container', ['id'=>$request->id, 'prevPage'=>$prevPage, 'selJobId'=>$selJobId])->with('status', 'The container,  <span style="font-weight:bold;font-style:italic;color:blue">'.$container->cntnr_name.'</span>, has been updated successfully.');
            }
        }
    }

    private function CreateInitialMovements(String $jobId, String $cntnrId, String $cntnrName, String $jobType) {
        $jobType = str_replace("\xc2\xa0", ' ', $jobType);
        if ($jobType == MyHelper::$allJobTypes[0]) {   // Import ==> 4 movements
            $movement = new Movement;
            $movement->mvmt_bk_id    = $jobId;
            $movement->mvmt_cntnr_name  = $cntnrName;
            $movement->mvmt_name        = "J_".$jobId."_C_".$cntnrId."_M_1";
            $movement->mvmt_type        = MyHelper::$allMovementTypes[4];       // Port Pickup
            $movement->mvmt_order       = 1;
            $saved = $movement->save();

            $movement = new Movement;
            $movement->mvmt_bk_id    = $jobId;
            $movement->mvmt_cntnr_name  = $cntnrName;
            $movement->mvmt_name        = "J_".$jobId."_C_".$cntnrId."_M_2";
            $movement->mvmt_type        = MyHelper::$allMovementTypes[7];       // Customer Drop
            $movement->mvmt_order       = 2;
            $saved = $movement->save();

            $movement = new Movement;
            $movement->mvmt_bk_id    = $jobId;
            $movement->mvmt_cntnr_name  = $cntnrName;
            $movement->mvmt_name        = "J_".$jobId."_C_".$cntnrId."_M_3";
            $movement->mvmt_type        = MyHelper::$allMovementTypes[6];       // Customer Pickup
            $movement->mvmt_order       = 3;
            $saved = $movement->save();

            $movement = new Movement;
            $movement->mvmt_bk_id    = $jobId;
            $movement->mvmt_cntnr_name  = $cntnrName;
            $movement->mvmt_name        = "J_".$jobId."_C_".$cntnrId."_M_4";
            $movement->mvmt_type        = MyHelper::$allMovementTypes[15];       // Empty Drop
            $movement->mvmt_order       = 4;
            $saved = $movement->save();
        } else if ($jobType == MyHelper::$allJobTypes[1]) {   // Export ==> 4 movements
            $movement = new Movement;
            $movement->mvmt_bk_id    = $jobId;
            $movement->mvmt_cntnr_name  = $cntnrName;
            $movement->mvmt_name        = "J_".$jobId."_C_".$cntnrId."_M_1";
            $movement->mvmt_type        = MyHelper::$allMovementTypes[14];       // Empty Pickup
            $movement->mvmt_order       = 1;
            $saved = $movement->save();

            $movement = new Movement;
            $movement->mvmt_bk_id    = $jobId;
            $movement->mvmt_cntnr_name  = $cntnrName;
            $movement->mvmt_name        = "J_".$jobId."_C_".$cntnrId."_M_2";
            $movement->mvmt_type        = MyHelper::$allMovementTypes[7];       // Customer Drop
            $movement->mvmt_order       = 2;
            $saved = $movement->save();

            $movement = new Movement;
            $movement->mvmt_bk_id    = $jobId;
            $movement->mvmt_cntnr_name  = $cntnrName;
            $movement->mvmt_name        = "J_".$jobId."_C_".$cntnrId."_M_3";
            $movement->mvmt_type        = MyHelper::$allMovementTypes[6];       // Customer Pickup
            $movement->mvmt_order       = 3;
            $saved = $movement->save();

            $movement = new Movement;
            $movement->mvmt_bk_id    = $jobId;
            $movement->mvmt_cntnr_name  = $cntnrName;
            $movement->mvmt_name        = "J_".$jobId."_C_".$cntnrId."_M_4";
            $movement->mvmt_type        = MyHelper::$allMovementTypes[5];       // Port Drop
            $movement->mvmt_order       = 4;
            $saved = $movement->save();
        } else if ($jobType == MyHelper::$allJobTypes[2]) {   // Empty Repo ==> 2 movements
            $movement = new Movement;
            $movement->mvmt_bk_id    = $jobId;
            $movement->mvmt_cntnr_name  = $cntnrName;
            $movement->mvmt_name        = "J_".$jobId."_C_".$cntnrId."_M_1";
            $movement->mvmt_type        = MyHelper::$allMovementTypes[0];       // Container Pickup
            $movement->mvmt_order       = 1;
            $saved = $movement->save();

            $movement = new Movement;
            $movement->mvmt_bk_id    = $jobId;
            $movement->mvmt_cntnr_name  = $cntnrName;
            $movement->mvmt_name        = "J_".$jobId."_C_".$cntnrId."_M_2";
            $movement->mvmt_type        = MyHelper::$allMovementTypes[1];       // Container Drop
            $movement->mvmt_order       = 2;
            $saved = $movement->save();
        } else if ($jobType == MyHelper::$allJobTypes[4]) {   // Other ==> 2 movements
            $movement = new Movement;
            $movement->mvmt_bk_id    = $jobId;
            $movement->mvmt_cntnr_name  = $cntnrName;
            $movement->mvmt_name        = "J_".$jobId."_C_".$cntnrId."_M_1";
            $movement->mvmt_type        = MyHelper::$allMovementTypes[6];       // Customer Pickup
            $movement->mvmt_order       = 1;
            $saved = $movement->save();

            $movement = new Movement;
            $movement->mvmt_bk_id    = $jobId;
            $movement->mvmt_cntnr_name  = $cntnrName;
            $movement->mvmt_name        = "J_".$jobId."_C_".$cntnrId."_M_2";
            $movement->mvmt_type        = MyHelper::$allMovementTypes[5];       // Port Drop
            $movement->mvmt_order       = 2;
            $saved = $movement->save();
        } else {   // Yard Move or CBSA    ==> 2 movements 
            $movement = new Movement;
            $movement->mvmt_bk_id    = $jobId;
            $movement->mvmt_cntnr_name  = $cntnrName;
            $movement->mvmt_name        = "J_".$jobId."_C_".$cntnrId."_M_1";
            $movement->mvmt_type        = "";                                   // ?
            $movement->mvmt_order       = 1;
            $saved = $movement->save();

            $movement = new Movement;
            $movement->mvmt_bk_id    = $jobId;
            $movement->mvmt_cntnr_name  = $cntnrName;
            $movement->mvmt_name        = "J_".$jobId."_C_".$cntnrId."_M_2";
            $movement->mvmt_type        = "";                                   // ?
            $movement->mvmt_order       = 2;
            $saved = $movement->save();
        }
    }

}
