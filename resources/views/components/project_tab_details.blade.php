<?php
	$customers = App\Models\Customer::all()->sortBy('cstm_account_name');
?>

<div class="row">
		<div class="col-8">
			<div class="row mb-2">
				<div class="col">
					<div class="card">
          				<div class="card-body">
						  	<div class="row">
								<div class="col-2"><label class="col-form-label">Billing Account:&nbsp;</label><span class="text-danger">*</span></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_cstm_account_no" name="bk_cstm_account_no" value="{{isset($booking)?$booking->bk_cstm_account_no:''}}">
								</div>
								<div class="col-2"><label class="col-form-label">Customer:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_cstm_account_name" name="bk_cstm_account_name" value="{{isset($booking)?$booking->bk_cstm_account_name:''}}">
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">Job Type:&nbsp;</label><span class="text-danger">*</span></div>
								<div class="col-4">
									<?php
									$tagHead = "<input list=\"bk_job_type\" name=\"bk_job_type\" id=\"bkjobtypeinput\" onchange=\"JobTypeSelected()\" class=\"form-control mt-1 my-text-height\" ";
									$tagTail = "><datalist id=\"bk_job_type\">";

									$allTypes = MyHelper::GetAllJobTypes();
									foreach($allTypes as $eachType) {
										$tagTail.= "<option value=".str_replace(' ', '&nbsp;', $eachType).">";
									}
									$tagTail.= "</datalist>";
									if (isset($_GET['selJobId'])) {
										echo $tagHead."placeholder=\"".$booking->bk_job_type."\" value=\"".$booking->bk_job_type."\"".$tagTail;
									} else {
										echo $tagHead."placeholder=\"\" value=\"\"".$tagTail;
									}
									?>
								</div>
								<div class="col-2"><label class="col-form-label">OPS Code:&nbsp;</label></div>
								<div class="col-4">
									<?php
									$tagHead = "<input list=\"bk_ops_code\" name=\"bk_ops_code\" id=\"bkopscodeinput\" class=\"form-control mt-1 my-text-height\" ";
									$tagTail = "><datalist id=\"bk_ops_code\">";

									$allTypes = MyHelper::GetAllOpsCodes();
									foreach($allTypes as $eachType) {
										$tagTail.= "<option value=".str_replace(' ', '&nbsp;', $eachType).">";
									}
									$tagTail.= "</datalist>";
									if (isset($_GET['selJobId'])) {
										echo $tagHead."placeholder=\"".$booking->bk_ops_code."\" value=\"".$booking->bk_ops_code."\"".$tagTail;
									} else {
										echo $tagHead."placeholder=\"\" value=\"\"".$tagTail;
									}
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">Steamship Line:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_ssl_name" name="bk_ssl_name" value="{{isset($booking)?$booking->bk_ssl_name:''}}">
								</div>
								<div class="col-2"><label class="col-form-label">No. of Containers:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_total_containers" name="bk_total_containers" value="{{isset($booking)?$booking->bk_total_containers:''}}">
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">Terminal:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_terminal_name" name="bk_terminal_name" value="{{isset($booking)?$booking->bk_terminal_name:''}}">
								</div>
								<div class="col-2"><label class="col-form-label">Gate:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_gate" name="bk_gate" value="{{isset($booking)?$booking->bk_gate:''}}">
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">Vessel:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_vessel" name="bk_vessel" value="{{isset($booking)?$booking->bk_vessel:''}}">
								</div>
								<div class="col-2"><label class="col-form-label">Voyage:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_voyage" name="bk_voyage" value="{{isset($booking)?$booking->bk_voyage:''}}">
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">IMO No.:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_imo_no" name="bk_imo_no" value="{{isset($booking)?$booking->bk_imo_no:''}}">
								</div>
								<div class="col-2"><label class="col-form-label">&nbsp;</label></div>
								<div class="col-4"><input type="hidden" class="form-control mt-1 my-text-height" type="text"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		function JobTypeSelected() {
			selType = document.getElementById("bkjobtypeinput").value.normalize('NFKD');
			if (selType == {!! json_encode(MyHelper::$allJobTypes[0]) !!} ) {	
				// User selected "Import" job type
				document.getElementById("bkpickupmovementtypeinput").value = {!! json_encode(MyHelper::$allMovementTypes[4]) !!};		// Set pickup movement type to "Port Pickup"
				document.getElementById("bkdeliverymovementtypeinput").value = {!! json_encode(MyHelper::$allMovementTypes[7]) !!};		// Set delivery movement type to "Customer Drop"
			} else if (selType == {!! json_encode(MyHelper::$allJobTypes[1]) !!} ) {	
				// User selected "Export" job type
				document.getElementById("bkpickupmovementtypeinput").value = {!! json_encode(MyHelper::$allMovementTypes[6]) !!};		// Set pickup movement type to "Customer Pickup"
				document.getElementById("bkdeliverymovementtypeinput").value = {!! json_encode(MyHelper::$allMovementTypes[5]) !!};		// Set delivery movement type to "Port Drop"
			} else if (selType == {!! json_encode( MyHelper::$allJobTypes[2]) !!} ) {	
				// User selected "Empty Repo" job type
				document.getElementById("bkpickupmovementtypeinput").value = {!! json_encode(MyHelper::$allMovementTypes[0]) !!};		// Set pickup movement type to "Container Pickup"
				document.getElementById("bkdeliverymovementtypeinput").value = {!! json_encode(MyHelper::$allMovementTypes[1]) !!};		// Set delivery movement type to "Container Drop"
			} else if (selType == {!! json_encode(MyHelper::$allJobTypes[3]) !!} ) {	
				// User selected "Yard Move" job type
				document.getElementById("bkpickupmovementtypeinput").value = "";
				document.getElementById("bkdeliverymovementtypeinput").value = "";
			} else if (selType == {!! json_encode(MyHelper::$allJobTypes[4]) !!} ) {	
				// User selected "Other" job type
				document.getElementById("bkpickupmovementtypeinput").value = ""; 	// {!! json_encode(MyHelper::$allMovementTypes[6]) !!};		// Set pickup movement type to "Customer Pickup"
				document.getElementById("bkdeliverymovementtypeinput").value = "";	// {!! json_encode(MyHelper::$allMovementTypes[5]) !!};		// Set delivery movement type to "Port Drop"
			} else if (selType == {!! json_encode(MyHelper::$allJobTypes[5]) !!} ) {	
				// User selected "CBSA" job type
				document.getElementById("bkpickupmovementtypeinput").value = "";
				document.getElementById("bkdeliverymovementtypeinput").value = "";
			} else {
			}
		}
	</script>
