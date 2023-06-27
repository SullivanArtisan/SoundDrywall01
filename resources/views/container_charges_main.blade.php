@extends('layouts.home_page_base')

@section('goback')
<?php
	if (isset($_GET['bookingTab'])) {
		$booking_tab = $_GET['bookingTab'];
	} else {
		$booking_tab = '';
	}

    $surcharges_count = 0;
    if (isset($_GET['selJobId'])) {		// Enter this page from booking_selected.blade
        $booking = \App\Models\Booking::where('id', $_GET['selJobId'])->first();
        $container = \App\Models\Container::where('id', $_GET['cntnrId'])->where('cntnr_status', '<>', 'deleted')->first();
        $surcharges = \App\Models\ContainerSurcharge::orderBy('cntnrsurchrg_type')->where('cntnrsurchrg_cntnr_id', $container->id)->get();
        $cntnr_job_no = $booking->bk_job_no;
        $customerAcc = \App\Models\CstmAccountPrice::where('cstm_account_no', $booking->bk_cstm_account_no)->where('cstm_account_from', $booking->bk_pickup_cmpny_zone)->where('cstm_account_to', $booking->bk_delivery_cmpny_zone)->first();
        $totalCharge = $customerAcc->cstm_account_charge;
        $containerCharge = $totalCharge;

        if (isset($_GET['surchargeId'])) {
            $selSurcharge = \App\Models\ContainerSurcharge::where('id', $_GET['surchargeId'])->first();
            $parmSurchargeId = $selSurcharge->id;
        } else {
            $parmSurchargeId = 0;
        }

        $refreshUrlWithoutSurchargeId = route('container_charges_main', ['cntnrId'=>$container->id, 'cntnrJobNo'=>$container->cntnr_job_no, 'prevPage'=>'booking_selected', 'selJobId'=>$booking->id]);
    } else {
        $id = '';
        $cntnr_job_no = "";
    }
    $outContents = "<a class=\"text-primary\" href=\"".route('container_selected', ['cntnrId='.$container->id, 'cntnrJobNo='.$container->cntnr_job_no, 'prevPage=booking_selected', 'selJobId='.$booking->id])."\" style=\"margin-right: 10px;\">Back</a>";
    echo $outContents;
?>
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

    <div class="pb-5">
        <div class="row m-4">
            <div>
				<h2 class="text-muted pl-2">Surcharges of Container {{$container->cntnr_name}}</h2>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="row bg-info text-white fw-bold ml-2">
                    <div class="col-6">Type</div>
                    <div class="col-3">Charge</div>
                    <div class="col-3">Ledger Code</div>
                </div> 

                <?php
                    foreach ($surcharges as $surcharge) {
                        $refreshUrlWithSurchargeId = route('container_charges_main', ['cntnrId'=>$container->id, 'cntnrJobNo'=>$container->cntnr_job_no, 'prevPage'=>'booking_selected', 'selJobId'=>$booking->id, 'surchargeId'=>$surcharge->id]);
                        $outContents = "<div id=\"scid".$surcharges_count."\" name=\"".$surcharge->id."\" class=\"newpointer row ml-2\" onclick=\"doDispatch(this)\" ondblclick=\"\">";
                        $outContents .= "<div class=\"col-6\">";
                            $outContents .= "<a href=\"".$refreshUrlWithSurchargeId."\">";
                                $outContents .= $surcharge->cntnrsurchrg_type;
                            $outContents .= "</a>";
                        $outContents .= "</div>";
                        $outContents .= "<div class=\"col-3\">";
                            $tempSurcharge = ($surcharge->cntnrsurchrg_quantity * $surcharge->cntnrsurchrg_rate) + $surcharge->cntnrsurchrg_charge;
                            $totalCharge += $tempSurcharge;
                            $outContents .= "<a href=\"".$refreshUrlWithSurchargeId."\">";
                                $outContents .= $tempSurcharge;
                            $outContents .= "</a>";
                        $outContents .= "</div>";
                        $outContents .= "<div class=\"col-3\">";
                            $outContents .= "<a href=\"".$refreshUrlWithSurchargeId."\">";
                                $outContents .= $surcharge->cntnrsurchrg_ledger_code;
                            $outContents .= "</a>";
                        $outContents .= "</div>";
                        $outContents .= "</div><hr class=\"m-1\"/>";
                        {{ 					
                            echo $outContents;;
                        }}
                        $surcharges_count++;
                    }
                ?>
                <div class="row bg-secondary text-white fw-bold ml-2 mt-5">
                <div class="col">Surcharges:<span class="ml-5 text-warning">{{$surcharges_count}}</span></div>
                <div class="col">Total Charge:<span class="ml-5 text-warning">${{$totalCharge}}</span></div>
                    <div class="col">Container Rate:<span class="ml-5 text-warning">${{$containerCharge}}</span></div>
                </div> 
            </div>
            <div class="col mx-3" id="charge_details">
                <form method="post" action="{{route('op_result.container_update', ['id'=>$booking->id])}}">
                    <div class="row mx-2 mt-2">
                        <div class="col-3"><label class="col-form-label">Type:&nbsp;</label></div>
                        <div class="col-9">
                            <input list="chrg_type_li" name="chrg_type" id="chrg_type" class="form-control mt-1 my-text-height" value="{{isset($selSurcharge)?$selSurcharge->cntnrsurchrg_type:''}}">
                                <datalist id="chrg_type_li">
                                    <?php
                                        $chrge_types = \App\Models\SurchargeType::all();
                                        foreach($chrge_types as $chrge_type) {
                                            $charge_output= "<option value=".str_replace(' ', '&nbsp;', $chrge_type->srchg_type).">";
                                            echo $charge_output;
                                        }
                                    ?>
                                </datalist>
                        </div>
                    </div>
                    <div class="row mx-2">
                        <div class="col-3"><label class="col-form-label">Description:&nbsp;</label></div>
                        <div class="col-9">
                            <input class="form-control mt-1 my-text-height" type="text" id="chrg_desc" name="chrg_desc" value="{{isset($selSurcharge)?$selSurcharge->cntnrsurchrg_desc:''}}">
                        </div>
                    </div>
                    <div class="row mx-2">
                        <div class="col-3"><label class="col-form-label">3rd Party Invoice #:&nbsp;</label></div>
                        <div class="col-9">
                            <input class="form-control mt-1 my-text-height" type="text" id="chrg_3rd_pty_inv_no" name="chrg_3rd_pty_inv_no" value="{{isset($selSurcharge)?$selSurcharge->cntnrsurchrg_3rd_pty_inv_no:''}}">
                        </div>
                    </div>
                    <div class="row mx-2">
                        <div class="col-3"><label class="col-form-label">Quantity:&nbsp;</label></div>
                        <div class="col-9">
                            <input class="form-control mt-1 my-text-height" type="number" step="0.01" id="chrg_quantity" name="chrg_quantity" value="{{isset($selSurcharge)?$selSurcharge->cntnrsurchrg_quantity:''}}">
                        </div>
                    </div>
                    <div class="row mx-2">
                        <div class="col-3"><label class="col-form-label">Rate:&nbsp;</label></div>
                        <div class="col-9">
                            <input class="form-control mt-1 my-text-height" type="number" step="0.01" id="chrg_rate" name="chrg_rate" value="{{isset($selSurcharge)?$selSurcharge->cntnrsurchrg_rate:''}}">
                        </div>
                    </div>
                    <div class="row mx-2">
                        <div class="col-3"><label class="col-form-label">Charge:&nbsp;</label></div>
                        <div class="col-5">
                            <input class="form-control mt-1 my-text-height" type="number" step="0.01" id="chrg_charge" name="chrg_charge" value="{{isset($selSurcharge)?$selSurcharge->cntnrsurchrg_charge:''}}">
                        </div>
                        <div class="col-3"><label class="col-form-label">Override:&nbsp;</label></div>
                        <div class="col-1"><input type="checkbox" class="mt-3" id="chrg_override" name="chrg_override" <?php if(isset($selSurcharge) && $selSurcharge->cntnrsurchrg_override=='T') {echo "checked";}?>></div>                        
                    </div>
                    <div class="row mx-2">
                        <div class="col-3"><label class="col-form-label">Ledger Code:&nbsp;</label></div>
                        <div class="col-9">
                            <input class="form-control mt-1 my-text-height" type="text" readonly id="chrg_ledger_code" name="chrg_ledger_code" value="{{isset($selSurcharge)?$selSurcharge->cntnrsurchrg_ledger_code:''}}">
                        </div>
                    </div>
                    <div class="row my-4">
                        <div class="col">
                            <div class="row">
                                <button class="btn btn-success ml-5 mr-2" type="submit" onclick="addThisSurcharge();">Add Surcharge</button>
                                <button class="btn btn-secondary mx-2" type="submit" onclick="purgeThisSurcharge();">Clear All</button>
                                <button class="btn btn-warning mx-2" type="submit" onclick="updateThisSurcharge();">Update</button>
                                <button class="btn btn-danger mx-2" type="submit" onclick="deleteThisSurcharge();">Delete</button>
                            </div>
                        </div>
                    </div>
                </form>
			</div>
        </div>

    </div>
	<script>
        var token = "";
        var cntnrName= "";
        var cntnrId = "";
        var chargeType = "";
        var chargeDesc = "";
        var charge3rdptyInvNo = "";
        var chargeQuantity = 0;
        var chargeRate = 0;
        var chargeCharge = 0;
        var chargeOvrd = 'F';

        window.onload = function() {
            var surchargesCount = {!! json_encode($surcharges_count) !!};
            var parmSurchargeId = {!! json_encode($parmSurchargeId) !!};
            for (let idx = 0; idx < surchargesCount; idx++) {
                var elementId = "scid"+idx;
                scElement = document.getElementById(elementId);

                var elementName = scElement.getAttribute("name");
                if (elementName == parmSurchargeId) {
                    scElement.style.backgroundColor = 'lightgrey';
                } else {
                    scElement.style.backgroundColor = '';
                }
            }

            var elChgDetails = document.getElementById('charge_details');
            if (parmSurchargeId == 0) {
                elChgDetails.style.backgroundColor = 'white';
            } else {
                elChgDetails.style.backgroundColor = 'lightgrey';
            }
        }

        function prepareSurchargeDetails() {
            token = "{{ csrf_token() }}";
            cntnrName= {!!json_encode($container->cntnr_name)!!};
            cntnrId = {!!json_encode($container->id)!!};
            chargeType = document.getElementById('chrg_type').value;
            chargeDesc = document.getElementById('chrg_desc').value;
            charge3rdptyInvNo =document.getElementById('chrg_3rd_pty_inv_no').value;
            chargeQuantity = document.getElementById('chrg_quantity').value;
            chargeRate = document.getElementById('chrg_rate').value;
            chargeCharge = document.getElementById('chrg_charge').value;
            if (document.getElementById('chrg_override').checked) {
                chargeOvrd = 'T';
            }
        }

        function addThisSurcharge() {
            event.preventDefault();
            var parmSurchargeId = {!! json_encode($parmSurchargeId) !!};

            if (parmSurchargeId == 0) {
                prepareSurchargeDetails();
                chargeType = chargeType.trim();
                if (chargeType.length > 0) {
                    $.ajax({
                        url: '/container_surcharge_add',
                        type: 'POST',
                        data: {
                            _token:token, 
                            cntnrsurchrg_cntnr_id:cntnrId,
                            cntnrsurchrg_type:chargeType, 
                            cntnrsurchrg_desc:chargeDesc, 
                            cntnrsurchrg_3rd_pty_inv_no:charge3rdptyInvNo, 
                            cntnrsurchrg_quantity:chargeQuantity, 
                            cntnrsurchrg_rate:chargeRate, 
                            cntnrsurchrg_charge:chargeCharge, 
                            cntnrsurchrg_override:chargeOvrd
                        },    // the _token:token is for Laravel
                        success: function(dataRetFromPHP) {
                            alert("Surcharge is added for container"+cntnrName+" successfully!");
                            location.reload();
                        }
                    });
                } else {
                    alert("Please specify the surcharge's type.");
                }
            } else {
                alert('To add a new surcharge, please Clear All fields first then enter the new info.')
            }
        }

        function purgeThisSurcharge() {
            event.preventDefault();
            document.getElementById('chrg_type').innerHTML = "";
            document.getElementById('chrg_desc').innerHTML = "";
            document.getElementById('chrg_3rd_pty_inv_no').innerHTML = "";
            document.getElementById('chrg_quantity').innerHTML = "";
            document.getElementById('chrg_rate').innerHTML = "";
            document.getElementById('chrg_charge').innerHTML = "";
            document.getElementById('chrg_override').checked = false

            window.location = {!!json_encode($refreshUrlWithoutSurchargeId)!!};
        }

        function updateThisSurcharge() {
            event.preventDefault();
            var parmSurchargeId = {!! json_encode($parmSurchargeId) !!};

            if (parmSurchargeId > 0) {
                prepareSurchargeDetails();

                $.ajax({
                    url: '/container_surcharge_update',
                    type: 'POST',
                    data: {
                        _token:token, 
                        cntnrsurchrg_id:parmSurchargeId,
                        cntnrsurchrg_cntnr_id:cntnrId,
                        cntnrsurchrg_type:chargeType, 
                        cntnrsurchrg_desc:chargeDesc, 
                        cntnrsurchrg_3rd_pty_inv_no:charge3rdptyInvNo, 
                        cntnrsurchrg_quantity:chargeQuantity, 
                        cntnrsurchrg_rate:chargeRate, 
                        cntnrsurchrg_charge:chargeCharge, 
                        cntnrsurchrg_override:chargeOvrd
                    },    // the _token:token is for Laravel
                    success: function(dataRetFromPHP) {
                        alert("Surcharge is updated successfully!");
                        location.reload();
                    }
                });
            }
        }

        function deleteThisSurcharge() {
            event.preventDefault();
            var parmSurchargeId = {!!json_encode($parmSurchargeId)!!};
            var token = "{{ csrf_token() }}";

            if (parmSurchargeId > 0) {
				if(confirm("Are you sure to delete this surcharge?")) {
                    prepareSurchargeDetails();

                    $.ajax({
                        url: '/container_surcharge_delete',
                        type: 'POST',
                        data: {
                            _token:token, 
                            cntnrsurchrg_id:parmSurchargeId,
                        },    // the _token:token is for Laravel
                        success: function(dataRetFromPHP) {
                            alert("Surcharge is deleted successfully!");
                            window.location = {!!json_encode($refreshUrlWithoutSurchargeId)!!};
                        }
                    });
                }
            }
        }
	</script>
@endsection
