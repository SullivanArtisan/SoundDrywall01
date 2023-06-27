	<!-- row 1 -->
	<div class="row">
		<div class="col"><label class="col-form-label">Birthday:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"date\" id=\"dvr_birth_date\" name=\"dvr_birth_date\" value=\"".$dbTable->dvr_birth_date."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"date\" id=\"dvr_birth_date\" name=\"dvr_birth_date\">";
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">Security:&nbsp;</label></div>
		<div class="col">
			<?php
				$tagHead = "<input style=\"margin-top:3%\" type=\"checkbox\" id=\"dvr_security\" name=\"dvr_security\" ";
				$tagTail = ">";
				if(isset($dbTable)) {
					if($dbTable->dvr_security) {
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

	<!-- row 2 -->
	<div class="row">
		<div class="col"><label class="col-form-label">Drug & Alcohol Test:&nbsp;</label></div>
		<div class="col">
			<?php
				$tagHead = "<input style=\"margin-top:3%\" type=\"checkbox\" id=\"dvr_drug_alcohol_test\" name=\"dvr_drug_alcohol_test\" ";
				$tagTail = ">";
				if(isset($dbTable)) {
					if($dbTable->dvr_drug_alcohol_test) {
						echo $tagHead."checked".$tagTail;
					} else {
						echo $tagHead.$tagTail;
					}
				} else {
					echo $tagHead.$tagTail;
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">Road Test:&nbsp;</label></div>
		<div class="col">
			<?php
				$tagHead = "<input style=\"margin-top:3%\" type=\"checkbox\" id=\"dvr_road_test\" name=\"dvr_road_test\" ";
				$tagTail = ">";
				if(isset($dbTable)) {
					if($dbTable->dvr_road_test) {
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

	<!-- row 3 -->
	<div class="row">
		<div class="col"><label class="col-form-label">Driver License No.:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_license_no\" name=\"dvr_license_no\" value=\"".$dbTable->dvr_license_no."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_license_no\" name=\"dvr_license_no\">";
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">License Province:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_license_province\" name=\"dvr_license_province\" value=\"".$dbTable->dvr_license_province."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_license_province\" name=\"dvr_license_province\">";
				}
			?>
		</div>
	</div>

	<!-- row 4 -->
	<div class="row">
		<div class="col"><label class="col-form-label">Driver License Expiry Date:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"date\" id=\"dvr_license_exp_date\" name=\"dvr_license_exp_date\" value=\"".$dbTable->dvr_license_exp_date."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"date\" id=\"dvr_license_exp_date\" name=\"dvr_license_exp_date\">";
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">&nbsp;</label></div>
		<div class="col"><input type="hidden" class="form-control mt-1 my-text-height" type="text"></div>
	</div>

	<!-- row 5 -->
	<div class="row">
		<div class="col"><label class="col-form-label">Abstract Expiry Date:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"date\" id=\"dvr_abstract_exp_date\" name=\"dvr_abstract_exp_date\" value=\"".$dbTable->dvr_abstract_exp_date."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"date\" id=\"dvr_abstract_exp_date\" name=\"dvr_abstract_exp_date\">";
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">TDG Expiry Date:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"date\" id=\"dvr_tdg_exp_date\" name=\"dvr_tdg_exp_date\" value=\"".$dbTable->dvr_tdg_exp_date."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"date\" id=\"dvr_tdg_exp_date\" name=\"dvr_tdg_exp_date\">";
				}
			?>
		</div>
	</div>

	<!-- row 6 -->
	<div class="row">
		<div class="col"><label class="col-form-label">Port Pass:&nbsp;</label></div>
		<div class="col">
			<?php
				$tagHead = "<input style=\"margin-top:3%\" type=\"checkbox\" id=\"dvr_port_pass\" name=\"dvr_port_pass\" ";
				$tagTail = ">";
				if(isset($dbTable)) {
					if($dbTable->dvr_port_pass) {
						echo $tagHead."checked".$tagTail;
					} else {
						echo $tagHead.$tagTail;
					}
				} else {
					echo $tagHead.$tagTail;
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">&nbsp;</label></div>
		<div class="col"><input type="hidden" class="form-control mt-1 my-text-height" type="text"></div>
	</div>

	<!-- row 7 -->
	<div class="row">
        <div class="col"><label class="col-form-label">Port Pass No.:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_port_pass_no\" name=\"dvr_port_pass_no\" value=\"".$dbTable->dvr_port_pass_no."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_port_pass_no\" name=\"dvr_port_pass_no\">";
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">Port Pass Expiry Date:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"date\" id=\"dvr_port_pass_exp_date\" name=\"dvr_port_pass_exp_date\" value=\"".$dbTable->dvr_port_pass_exp_date."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"date\" id=\"dvr_port_pass_exp_date\" name=\"dvr_port_pass_exp_date\">";
				}
			?>
		</div>
	</div>

	<!-- row 8 -->
	<div class="row">
		<div class="col"><label class="col-form-label">Twic Card:&nbsp;</label></div>
		<div class="col">
			<?php
				$tagHead = "<input style=\"margin-top:3%\" type=\"checkbox\" id=\"dvr_twic_card\" name=\"dvr_twic_card\" ";
				$tagTail = ">";
				if(isset($dbTable)) {
					if($dbTable->dvr_twic_card) {
						echo $tagHead."checked".$tagTail;
					} else {
						echo $tagHead.$tagTail;
					}
				} else {
					echo $tagHead.$tagTail;
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">&nbsp;</label></div>
		<div class="col"><input type="hidden" class="form-control mt-1 my-text-height" type="text"></div>
	</div>

	<!-- row 9 -->
	<div class="row">
        <div class="col"><label class="col-form-label">Twic Card No.:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_twic_card_no\" name=\"dvr_twic_card_no\" value=\"".$dbTable->dvr_twic_card_no."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_twic_card_no\" name=\"dvr_twic_card_no\">";
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">Twic Card Expiry Date:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"date\" id=\"dvr_twic_card_exp_date\" name=\"dvr_twic_card_exp_date\" value=\"".$dbTable->dvr_twic_card_exp_date."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"date\" id=\"dvr_twic_card_exp_date\" name=\"dvr_twic_card_exp_date\">";
				}
			?>
		</div>
	</div>
	
	<!-- row 10 -->
	<div class="row">
		<div class="col"><label class="col-form-label">Fast Pass:&nbsp;</label></div>
		<div class="col">
			<?php
				$tagHead = "<input style=\"margin-top:3%\" type=\"checkbox\" id=\"dvr_fast_pass\" name=\"dvr_fast_pass\" ";
				$tagTail = ">";
				if(isset($dbTable)) {
					if($dbTable->dvr_fast_pass) {
						echo $tagHead."checked".$tagTail;
					} else {
						echo $tagHead.$tagTail;
					}
				} else {
					echo $tagHead.$tagTail;
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">&nbsp;</label></div>
		<div class="col"><input type="hidden" class="form-control mt-1 my-text-height" type="text"></div>
	</div>

	<!-- row 11 -->
	<div class="row">
        <div class="col"><label class="col-form-label">Fast Pass No.:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_fast_pass_no\" name=\"dvr_fast_pass_no\" value=\"".$dbTable->dvr_fast_pass_no."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_fast_pass_no\" name=\"dvr_fast_pass_no\">";
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">Fast Pass Expiry Date:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"date\" id=\"dvr_fast_pass_exp_date\" name=\"dvr_fast_pass_exp_date\" value=\"".$dbTable->dvr_fast_pass_exp_date."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"date\" id=\"dvr_fast_pass_exp_date\" name=\"dvr_fast_pass_exp_date\">";
				}
			?>
		</div>
	</div>
	
	
	<!-- row 12 -->
	<div class="row">
		<div class="col"><label class="col-form-label">TLS License:&nbsp;</label></div>
		<div class="col">
			<?php
				$tagHead = "<input style=\"margin-top:3%\" type=\"checkbox\" id=\"dvr_tls_license\" name=\"dvr_tls_license\" ";
				$tagTail = ">";
				if(isset($dbTable)) {
					if($dbTable->dvr_tls_license) {
						echo $tagHead."checked".$tagTail;
					} else {
						echo $tagHead.$tagTail;
					}
				} else {
					echo $tagHead.$tagTail;
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">&nbsp;</label></div>
		<div class="col"><input type="hidden" class="form-control mt-1 my-text-height" type="text"></div>
	</div>

	<!-- row 13 -->
	<div class="row">
        <div class="col"><label class="col-form-label">TLS License No.:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_tls_license_no\" name=\"dvr_tls_license_no\" value=\"".$dbTable->dvr_tls_license_no."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"text\" id=\"dvr_tls_license_no\" name=\"dvr_tls_license_no\">";
				}
			?>
		</div>
		<div class="col"><label class="col-form-label">TLS License Expiry Date:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"date\" id=\"dvr_tls_license_exp_date\" name=\"dvr_tls_license_exp_date\" value=\"".$dbTable->dvr_tls_license_exp_date."\">";
				} else {
					echo "<input class=\"form-control mt-1 my-text-height\" type=\"date\" id=\"dvr_tls_license_exp_date\" name=\"dvr_tls_license_exp_date\">";
				}
			?>
		</div>
	</div>
