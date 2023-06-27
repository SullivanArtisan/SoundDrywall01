	<div class="row">
		<div class="col"><label class="col-form-label">Social Insurance No.:&nbsp;</label></div>
		<div class="col">
            <?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_sin\" name=\"dvr_sin\" value=\"".$dbTable->dvr_sin."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_sin\" name=\"dvr_sin\">";
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">Pay Set Amount:&nbsp;</label></div>
		<div class="col">
            <?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"number\" step=\"any\" id=\"dvr_pay_set_amount\" name=\"dvr_pay_set_amount\" value=\"".$dbTable->dvr_pay_set_amount."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"number\" step=\"any\" id=\"dvr_pay_set_amount\" name=\"dvr_pay_set_amount\">";
				}
			?>
		</div>
	</div>
	<div class="row">
        <div class="col"><label class="col-form-label">Exclude From Pay Run:&nbsp;</label></div>
		<div class="col">
			<?php
				$tagHead = "<input style=\"margin-top:3%\" type=\"checkbox\" id=\"dvr_exclude_from_pay_run\" name=\"dvr_exclude_from_pay_run\" ";
				$tagTail = ">";
				if(isset($dbTable)) {
					if($dbTable->dvr_exclude_from_pay_run) {
						echo $tagHead."checked".$tagTail;
					} else {
						echo $tagHead.$tagTail;
					}
				} else {
					echo $tagHead.$tagTail;
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">Include In Print Run:&nbsp;</label></div>
		<div class="col">
			<?php
				$tagHead = "<input style=\"margin-top:3%\" type=\"checkbox\" id=\"dvr_include_in_print_run\" name=\"dvr_include_in_print_run\" ";
				$tagTail = ">";
				if(isset($dbTable)) {
					if($dbTable->dvr_include_in_print_run) {
						echo $tagHead."checked".$tagTail;
					} else {
						echo $tagHead.$tagTail;
					}
				} else {
					echo $tagHead.$tagTail;
				}
			?>
		</div>
	</div>
	<div class="row">
        <div class="col"><label class="col-form-label">Email Invoices (PDF Format):&nbsp;</label></div>
		<div class="col">
			<?php
				$tagHead = "<input style=\"margin-top:3%\" type=\"checkbox\" id=\"dvr_email_invoices\" name=\"dvr_email_invoices\" ";
				$tagTail = ">";
				if(isset($dbTable)) {
					if($dbTable->dvr_email_invoices) {
						echo $tagHead."checked".$tagTail;
					} else {
						echo $tagHead.$tagTail;
					}
				} else {
					echo $tagHead.$tagTail;
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">Add Tax To Pay Sheet:&nbsp;</label></div>
		<div class="col">
			<?php
				$tagHead = "<input style=\"margin-top:3%\" type=\"checkbox\" id=\"dvr_add_tax_to_pay_sheet\" name=\"dvr_add_tax_to_pay_sheet\" ";
				$tagTail = ">";
				if(isset($dbTable)) {
					if($dbTable->dvr_add_tax_to_pay_sheet) {
						echo $tagHead."checked".$tagTail;
					} else {
						echo $tagHead.$tagTail;
					}
				} else {
					echo $tagHead.$tagTail;
				}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Driver Pay Type:&nbsp;</label></div>
		<div class="col">
            <?php
				if(isset($dbTable)) {
					//echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_paye_type\" name=\"dvr_paye_type\" value=\"".$dbTable->dvr_paye_type."\">";
                    echo "<input list=\"dvr_paye_type\" name=\"dvr_paye_type\" id=\"driverPayTypeInput\" class=\"form-control mt-1 my-text-height\" value=\"".$dbTable->dvr_paye_type."\">";
				} else {
					//echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_paye_type\" name=\"dvr_paye_type\">";
                    echo "<input list=\"dvr_paye_type\" name=\"dvr_paye_type\" id=\"driverPayTypeInput\" class=\"form-control mt-1 my-text-height\">";
				}
			?>
            <datalist id="dvr_paye_type">
            <option value="Trip">
            <option value="Hourly">
            <option value="Subhauler Trip">
            <option value="Milage Hourly">
            <option value="Owner Operator Trip">
            </datalist>
		</div>
		<div class="col"><label class="col-form-label">Ledger Code:&nbsp;</label></div>
		<div class="col">
            <?php
				if(isset($dbTable)) {
					//echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_ledger_code\" name=\"dvr_ledger_code\" value=\"".$dbTable->dvr_ledger_code."\">";
                    echo "<input list=\"dvr_ledger_code\" name=\"dvr_ledger_code\" id=\"dvrLedgerCodeInput\" class=\"form-control mt-1 my-text-height\" value=\"".$dbTable->dvr_ledger_code."\">";
				} else {
					//echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_ledger_code\" name=\"dvr_ledger_code\">";
                    echo "<input list=\"dvr_ledger_code\" name=\"dvr_ledger_code\" id=\"dvrLedgerCodeInput\" class=\"form-control mt-1 my-text-height\">";
				}
			?>
            <datalist id="dvr_ledger_code">
            <option value="50001000/Local">
            <option value="50004000/Highway">
            <option value="51001000/Company Trip">
            <option value="50002000/Subhauler">
            <option value="50005000/Subhauler">
            </datalist>
		</div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Hourly Rate:&nbsp;</label></div>
		<div class="col">
            <?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"number\" step=\"any\" id=\"dvr_hourly_rate\" name=\"dvr_hourly_rate\" value=\"".$dbTable->dvr_hourly_rate."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"number\" step=\"any\" id=\"dvr_hourly_rate\" name=\"dvr_hourly_rate\">";
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">Hourly Safe Driving Premium:&nbsp;</label></div>
		<div class="col">
            <?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"number\" step=\"any\" id=\"dvr_safe_driving_premium\" name=\"dvr_safe_driving_premium\" value=\"".$dbTable->dvr_safe_driving_premium."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"number\" step=\"any\" id=\"dvr_safe_driving_premium\" name=\"dvr_safe_driving_premium\">";
				}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Hourly Clean NSC Premium:&nbsp;</label></div>
		<div class="col">
            <?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"number\" step=\"any\" id=\"dvr_clean_nsc_premium\" name=\"dvr_clean_nsc_premium\" value=\"".$dbTable->dvr_clean_nsc_premium."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"number\" step=\"any\" id=\"dvr_clean_nsc_premium\" name=\"dvr_clean_nsc_premium\">";
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">&nbsp;</label></div>
		<div class="col"><input type="hidden" class="form-control mt-1 my-text-height" type="text"></div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Mileage Rate:&nbsp;</label></div>
		<div class="col">
            <?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"number\" step=\"any\" id=\"dvr_milage_rate\" name=\"dvr_milage_rate\" value=\"".$dbTable->dvr_milage_rate."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"number\" step=\"any\" id=\"dvr_milage_rate\" name=\"dvr_milage_rate\">";
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">Mileage Safe Driving Premium:&nbsp;</label></div>
		<div class="col">
            <?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"number\" step=\"any\" id=\"dvr_safe_driving_premium2\" name=\"dvr_safe_driving_premium2\" value=\"".$dbTable->dvr_safe_driving_premium2."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"number\" step=\"any\" id=\"dvr_safe_driving_premium2\" name=\"dvr_safe_driving_premium2\">";
				}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Mileage Clean NSC Premium:&nbsp;</label></div>
		<div class="col">
            <?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"number\" step=\"any\" id=\"dvr_clean_nsc_premium2\" name=\"dvr_clean_nsc_premium2\" value=\"".$dbTable->dvr_clean_nsc_premium2."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"number\" step=\"any\" id=\"dvr_clean_nsc_premium2\" name=\"dvr_clean_nsc_premium2\">";
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">&nbsp;</label></div>
		<div class="col"><input type="hidden" class="form-control mt-1 my-text-height" type="text"></div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Overtime Rate:&nbsp;</label></div>
		<div class="col">
            <?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"number\" step=\"any\" id=\"dvr_ot_rate\" name=\"dvr_ot_rate\" value=\"".$dbTable->dvr_ot_rate."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"number\" step=\"any\" id=\"dvr_ot_rate\" name=\"dvr_ot_rate\">";
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">Stat Holiday Rate:&nbsp;</label></div>
		<div class="col">
            <?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"number\" step=\"any\" id=\"dvr_stat_holiday_rate\" name=\"dvr_stat_holiday_rate\" value=\"".$dbTable->dvr_stat_holiday_rate."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"number\" step=\"any\" id=\"dvr_stat_holiday_rate\" name=\"dvr_stat_holiday_rate\">";
				}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">Maximum Standard Hours P/Week:&nbsp;</label></div>
		<div class="col">
            <?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"number\" step=\"any\" id=\"dvr_max_standard_hous_perweek\" name=\"dvr_max_standard_hous_perweek\" value=\"".$dbTable->dvr_max_standard_hous_perweek."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"number\" step=\"any\" id=\"dvr_max_standard_hous_perweek\" name=\"dvr_max_standard_hous_perweek\">";
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">&nbsp;</label></div>
		<div class="col"><input type="hidden" class="form-control mt-1 my-text-height" type="text"></div>
	</div>
	<div class="row">
		<div class="col"><label class="col-form-label">WCB No.:&nbsp;</label></div>
		<div class="col">
            <?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_wcb_no\" name=\"dvr_wcb_no\" value=\"".$dbTable->dvr_wcb_no."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_wcb_no\" name=\"dvr_wcb_no\">";
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">Vendor Code:&nbsp;</label></div>
		<div class="col">
            <?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_vendor_code\" name=\"dvr_vendor_code\" value=\"".$dbTable->dvr_vendor_code."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_vendor_code\" name=\"dvr_vendor_code\">";
				}
			?>
		</div>
	</div>
