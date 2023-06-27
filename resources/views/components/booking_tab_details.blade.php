<?php
	$zones = App\Models\Zone::all()->sortBy('zone_name');
	$companies = App\Models\Company::all()->sortBy('cmpny_name');
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
			<div class="row">
				<div class="col">
					<div class="card">
          				<div class="card-body">
						  	<div class="row">
							  	<div class="col text-center"><label class="col-form-label font-weight-bold">Pickup Address:&nbsp;</label></div>
							  	<div class="col text-center"><i class="bi bi-chevron-double-left"></i><i class="bi bi-three-dots"></i><i class="bi bi-chevron-double-right"></i></div>
								<div class="col text-center"><label class="col-form-label font-weight-bold">Delivery Address:&nbsp;</label></div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">Company:&nbsp;</label><span class="text-danger">*</span></div>
								<div class="col-4">
									<!-- <input class="form-control mt-1 my-text-height" type="text" id="bk_pickup_cmpny_name" name="bk_pickup_cmpny_name" value="{{isset($booking)?$booking->bk_pickup_cmpny_name:''}}"> -->
									<input list="bk_pickup_cmpny_name_li" name="bk_pickup_cmpny_name" id="bk_pickup_cmpny_name" class="form-control mt-1 my-text-height" value="{{isset($booking)?$booking->bk_pickup_cmpny_name:''}}">
									<datalist id="bk_pickup_cmpny_name_li">
									<?php
										foreach ($companies as $company) {
											echo "<option value=\"".$company->cmpny_name."\">";
										}
									?>
									</datalist></input>
									<input type="hidden" id="original_pickup_zone" name="original_pickup_zone" value="{{isset($booking)?$booking->bk_pickup_cmpny_zone:''}}">
								</div>
								<div class="col-2"><label class="col-form-label">Company:&nbsp;</label><span class="text-danger">*</span></div>
								<div class="col-4">
									<!-- <input class="form-control mt-1 my-text-height" type="text" id="bk_delivery_cmpny_name" name="bk_delivery_cmpny_name" value="{{isset($booking)?$booking->bk_delivery_cmpny_name:''}}"> -->
									<input list="bk_delivery_cmpny_name_li" name="bk_delivery_cmpny_name" id="bk_delivery_cmpny_name" class="form-control mt-1 my-text-height" value="{{isset($booking)?$booking->bk_delivery_cmpny_name:''}}">
									<datalist id="bk_delivery_cmpny_name_li">
									<?php
										foreach ($companies as $company) {
											echo "<option value=\"".$company->cmpny_name."\">";
										}
									?>
									</datalist></input>
									<input type="hidden" id="original_delivery_zone" name="original_delivery_zone" value="{{isset($booking)?$booking->bk_delivery_cmpny_zone:''}}">
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">Address:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_pickup_cmpny_addr_1" name="bk_pickup_cmpny_addr_1" value="{{isset($booking)?$booking->bk_pickup_cmpny_addr_1:''}}">
								</div>
								<div class="col-2"><label class="col-form-label">Address:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_delivery_cmpny_addr_1" name="bk_delivery_cmpny_addr_1" value="{{isset($booking)?$booking->bk_delivery_cmpny_addr_1:''}}">
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_pickup_cmpny_addr_2" name="bk_pickup_cmpny_addr_2" value="{{isset($booking)?$booking->bk_pickup_cmpny_addr_2:''}}">
								</div>
								<div class="col-2"><label class="col-form-label">&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_delivery_cmpny_addr_2" name="bk_delivery_cmpny_addr_2" value="{{isset($booking)?$booking->bk_delivery_cmpny_addr_2:''}}">
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_pickup_cmpny_addr_3" name="bk_pickup_cmpny_addr_3" value="{{isset($booking)?$booking->bk_delivery_cmpny_addr_3:''}}">
								</div>
								<div class="col-2"><label class="col-form-label">&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_delivery_cmpny_addr_3" name="bk_delivery_cmpny_addr_3" value="{{isset($booking)?$booking->bk_delivery_cmpny_addr_3:''}}">
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">City:&nbsp;<span class="text-danger">*</span></label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_pickup_cmpny_city" name="bk_pickup_cmpny_city" value="{{isset($booking)?$booking->bk_pickup_cmpny_city:''}}">
								</div>
								<div class="col-2"><label class="col-form-label">City:&nbsp;<span class="text-danger">*</span></label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_delivery_cmpny_city" name="bk_delivery_cmpny_city" value="{{isset($booking)?$booking->bk_delivery_cmpny_city:''}}">
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">Province:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_pickup_cmpny_province" name="bk_pickup_cmpny_province" value="{{isset($booking)?$booking->bk_pickup_cmpny_province:''}}">
								</div>
								<div class="col-2"><label class="col-form-label">Province:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_delivery_cmpny_province" name="bk_delivery_cmpny_province" value="{{isset($booking)?$booking->bk_delivery_cmpny_province:''}}">
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">Postcode:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_pickup_cmpny_postcode" name="bk_pickup_cmpny_postcode" value="{{isset($booking)?$booking->bk_pickup_cmpny_postcode:''}}">
								</div>
								<div class="col-2"><label class="col-form-label">Postcode:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_delivery_cmpny_postcode" name="bk_delivery_cmpny_postcode" value="{{isset($booking)?$booking->bk_delivery_cmpny_postcode:''}}">
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">Country:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_pickup_cmpny_country" name="bk_pickup_cmpny_country" value="{{isset($booking)?$booking->bk_pickup_cmpny_country:''}}">
								</div>
								<div class="col-2"><label class="col-form-label">Country:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_delivery_cmpny_country" name="bk_delivery_cmpny_country" value="{{isset($booking)?$booking->bk_delivery_cmpny_country:''}}">
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">Movement Type:&nbsp;</label></div>
								<div class="col-4">
									<?php
									$tagHead = "<input list=\"bk_pickup_movement_type\" name=\"bk_pickup_movement_type\" id=\"bkpickupmovementtypeinput\" class=\"form-control mt-1 my-text-height\" ";
									$tagTail = "><datalist id=\"bk_pickup_movement_type\">";

									$allTypes = MyHelper::GetCommonMovementTypes();
									foreach($allTypes as $eachType) {
										$tagTail.= "<option value=".str_replace(' ', '&nbsp;', $eachType).">";
									}
									$tagTail.= "</datalist>";
									if (isset($_GET['selJobId'])) {
										echo $tagHead."placeholder=\"".$booking->bk_pickup_movement_type."\" value=\"".$booking->bk_pickup_movement_type."\"".$tagTail;
									} else {
										echo $tagHead."placeholder=\"\" value=\"\"".$tagTail;
									}
									?>
								</div>
								<div class="col-2"><label class="col-form-label">Movement Type:&nbsp;</label></div>
								<div class="col-4">
									<?php
									$tagHead = "<input list=\"bk_delivery_movement_type\" name=\"bk_delivery_movement_type\" id=\"bkdeliverymovementtypeinput\" class=\"form-control mt-1 my-text-height\" ";
									$tagTail = "><datalist id=\"bk_delivery_movement_type\">";

									$allTypes = MyHelper::GetCommonMovementTypes();
									foreach($allTypes as $eachType) {
										$tagTail.= "<option value=".str_replace(' ', '&nbsp;', $eachType).">";
									}
									$tagTail.= "</datalist>";
									if (isset($_GET['selJobId'])) {
										echo $tagHead."placeholder=\"".$booking->bk_delivery_movement_type."\" value=\"".$booking->bk_delivery_movement_type."\"".$tagTail;
									} else {
										echo $tagHead."placeholder=\"\" value=\"\"".$tagTail;
									}
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">Contact:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_pickup_cmpny_contact" name="bk_pickup_cmpny_contact" value="{{isset($booking)?$booking->bk_pickup_cmpny_contact:''}}">
								</div>
								<div class="col-2"><label class="col-form-label">Contact:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_delivery_cmpny_contact" name="bk_delivery_cmpny_contact" value="{{isset($booking)?$booking->bk_delivery_cmpny_contact:''}}">
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">Tel:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_pickup_cmpny_tel" name="bk_pickup_cmpny_tel" value="{{isset($booking)?$booking->bk_pickup_cmpny_tel:''}}">
								</div>
								<div class="col-2"><label class="col-form-label">Tel:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_delivery_cmpny_tel" name="bk_delivery_cmpny_tel" value="{{isset($booking)?$booking->bk_delivery_cmpny_tel:''}}">
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">Email:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_pickup_cmpny_email" name="bk_pickup_cmpny_email" value="{{isset($booking)?$booking->bk_pickup_cmpny_email:''}}">
								</div>
								<div class="col-2"><label class="col-form-label">Email:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_delivery_cmpny_email" name="bk_delivery_cmpny_email" value="{{isset($booking)?$booking->bk_delivery_cmpny_email:''}}">
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">Remarks:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_pickup_remarks" name="bk_pickup_remarks" value="{{isset($booking)?$booking->bk_pickup_remarks:''}}">
								</div>
								<div class="col-2"><label class="col-form-label">Remarks:&nbsp;</label></div>
								<div class="col-4">
									<input class="form-control mt-1 my-text-height" type="text" id="bk_delivery_remarks" name="bk_delivery_remarks" value="{{isset($booking)?$booking->bk_delivery_remarks:''}}">
								</div>
							</div>
							<div class="row">
								<div class="col-2"><label class="col-form-label">Pricing Zone:&nbsp;<span class="text-danger">*</span></label></div>
								<div class="col-4">
									<!-- <input class="form-control mt-1 my-text-height" type="text" id="bk_pickup_cmpny_zone" name="bk_pickup_cmpny_zone" value="{{isset($booking)?$booking->bk_pickup_cmpny_zone:''}}"> -->
									<input list="bk_pickup_cmpny_zone_li" name="bk_pickup_cmpny_zone" id="bk_pickup_cmpny_zone" class="form-control mt-1 my-text-height" value="{{isset($booking)?$booking->bk_pickup_cmpny_zone:''}}">
									<datalist id="bk_pickup_cmpny_zone_li">
									<?php
										foreach ($zones as $zone) {
											echo "<option value=\"".$zone->zone_name."\">";
										}
									?>
									</datalist></input>
								</div>
								<div class="col-2"><label class="col-form-label">Pricing Zone:&nbsp;<span class="text-danger">*</span></label></div>
								<div class="col-4">
									<!-- <input class="form-control mt-1 my-text-height" type="text" id="bk_delivery_cmpny_zone" name="bk_delivery_cmpny_zone" value="{{isset($booking)?$booking->bk_delivery_cmpny_zone:''}}"> -->
									<input list="bk_delivery_cmpny_zone_li" name="bk_delivery_cmpny_zone" id="bk_delivery_cmpny_zone" class="form-control mt-1 my-text-height" value="{{isset($booking)?$booking->bk_delivery_cmpny_zone:''}}">
									<datalist id="bk_delivery_cmpny_zone_li">
									<?php
										foreach ($zones as $zone) {
											echo "<option value=\"".$zone->zone_name."\">";
										}
									?>
									</datalist></input>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-4">
			<div class="card">
          		<div class="card-body">
				  	<div class="row">
						<div class="col-4"><label class="col-form-label">Booked By:&nbsp;</label></div>
						<div class="col-8">
							<input class="form-control mt-1 my-text-height" type="text" id="bk_booker_name" name="bk_booker_name" value="{{isset($booking)?$booking->bk_booker_name:''}}">
						</div>
					</div>
					<div class="row">
						<div class="col-4"><label class="col-form-label">Booker's Tel:&nbsp;</label></div>
						<div class="col-8">
							<input class="form-control mt-1 my-text-height" type="text" id="bk_booker_tel" name="bk_booker_tel" value="{{isset($booking)?$booking->bk_booker_tel:''}}">
						</div>
					</div>
					<div class="row">
						<div class="col-4"><label class="col-form-label">Booker's Email:&nbsp;</label></div>
						<div class="col-8">
							<input class="form-control mt-1 my-text-height" type="text" id="bk_booker_email" name="bk_booker_email" value="{{isset($booking)?$booking->bk_booker_email:''}}">
						</div>
					</div>
					<div class="row">
						<div class="col-4"><label class="col-form-label">Customer Order #:&nbsp;</label></div>
						<div class="col-8">
							<input class="form-control mt-1 my-text-height" type="text" id="bk_cstm_order_no" name="bk_cstm_order_no" value="{{isset($booking)?$booking->bk_cstm_order_no:''}}">
						</div>
					</div>
					<div class="row">
						<div class="col-4"><label class="col-form-label">Booking #:&nbsp;</label></div>
						<div class="col-8">
							<input class="form-control mt-1 my-text-height" type="text" id="bk_booking_no" name="bk_booking_no" value="{{isset($booking)?$booking->bk_booking_no:''}}">
						</div>
					</div>
					<div class="row">
						<div class="col-4"><label class="col-form-label">Goods Desc:&nbsp;</label></div>
						<div class="col-8">
							<input class="form-control mt-1 my-text-height" type="text" id="bk_goods_desc" name="bk_goods_desc" value="{{isset($booking)?$booking->bk_goods_desc:''}}">
						</div>
					</div>
					<div class="row">
						<div class="col-4"><label class="col-form-label">Goods Desc:&nbsp;</label></div>
						<div class="col-8">
							<input class="form-control mt-1 my-text-height" type="text" id="bk_goods_desc" name="bk_goods_desc" value="{{isset($booking)?$booking->bk_goods_desc:''}}">
						</div>
					</div>
					<div class="row">
						<div class="col-4"><label class="col-form-label">Cargo Weight:&nbsp;</label></div>
						<div class="col-4">
							<input class="form-control mt-1 my-text-height" type="text" id="bk_cargo_weight" name="bk_cargo_weight" value="{{isset($booking)?$booking->bk_cargo_weight:''}}">
						</div>
						<div class="col-4">
							<?php
							$tagHead = "<input list=\"bk_weight_unit\" name=\"bk_weight_unit\" id=\"bkweightunitinput\" class=\"form-control mt-1 my-text-height\" ";
							$tagTail = "><datalist id=\"bk_weight_unit\">";
							$tagTail.= "<option value=\"Kgs\">";
							$tagTail.= "<option value=\"Lbs\">";
							$tagTail.= "</datalist>";
							if (isset($_GET['selJobId'])) {
								echo $tagHead."placeholder=\"".$booking->bk_weight_unit."\" value=\"".$booking->bk_weight_unit."\"".$tagTail;
							} else {
								echo $tagHead."placeholder=\"\" value=\"\"".$tagTail;
							}
					?>
						</div>
					</div>
					<div class="row">
						<div class="col-4"><label class="col-form-label">Invoice Group Number:&nbsp;</label></div>
						<div class="col-8">
							<input class="form-control mt-1 my-text-height" type="text" id="bk_invoice_group_no" name="bk_invoice_group_no" value="{{isset($booking)?$booking->bk_invoice_group_no:''}}">
						</div>
					</div>
				</div>
			</div>
			<div class="card mt-2">
          		<div class="card-body">
				  	<div class="row ml-1">
						<div><label class="col-form-label">Internal Notes:&nbsp;</label></div>
					</div>
					<div class="row">
						<div class="col-12">
							<textarea class="form-control mt-1 my-text-height" id="bk_internal_notes" name="bk_internal_notes" value="{{isset($booking)?$booking->bk_internal_notes:''}}"></textarea>
						</div>
					</div>
					<div class="row ml-1 mt-1">
						<div><label class="col-form-label">Driver's Notes:&nbsp(Goes to PDA on each leg of job)</label></div>
					</div>
					<div class="row">
						<div class="col-12">
							<textarea class="form-control mt-1 my-text-height" id="bk_driver_notes" name="bk_driver_notes" value="{{isset($booking)?$booking->bk_driver_notes:''}}"></textarea>
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
