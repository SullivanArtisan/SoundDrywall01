	<div class="row">
		<div class="col-1"><label class="col-form-label">Docket Messages:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<textarea class=\"form-control mt-1\" rows=\"15\" id=\"cstm_other_docket_msgs\" name=\"cstm_other_docket_msgs\" placeholder=\"".$dbTable->cstm_other_docket_msgs."\">".$dbTable->cstm_other_docket_msgs."</textarea>";
				} else {
					echo "<textarea class=\"form-control mt-1\" rows=\"15\" id=\"cstm_other_docket_msgs\" name=\"cstm_other_docket_msgs\"></textarea>";
				}
			?>
		</div>
		<div class="col-1"><label class="col-form-label">Additional Information:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<textarea class=\"form-control mt-1\" rows=\"15\" id=\"cstm_other_additional_info\" name=\"cstm_other_additional_info\" placeholder=\"".$dbTable->cstm_other_additional_info."\">".$dbTable->cstm_other_additional_info."</textarea>";
				} else {
					echo "<textarea class=\"form-control mt-1\" rows=\"15\" id=\"cstm_other_additional_info\" name=\"cstm_other_additional_info\"></textarea>";
				}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-1"><label class="col-form-label">Control Messages:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<textarea class=\"form-control mt-1\" rows=\"15\" id=\"cstm_other_control_msgs\" name=\"cstm_other_control_msgs\" placeholder=\"".$dbTable->cstm_other_control_msgs."\">".$dbTable->cstm_other_control_msgs."</textarea>";
				} else {
					echo "<textarea class=\"form-control mt-1\" rows=\"15\" id=\"cstm_other_control_msgs\" name=\"cstm_other_control_msgs\"></textarea>";
				}
			?>
		</div>
		<div class="col-1"><label class="col-form-label">Special Instructions:&nbsp;</label></div>
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<textarea class=\"form-control mt-1\" rows=\"15\" id=\"cstm_other_special_instructions\" name=\"cstm_other_special_instructions\" placeholder=\"".$dbTable->cstm_other_special_instructions."\">".$dbTable->cstm_other_special_instructions."</textarea>";
				} else {
					echo "<textarea class=\"form-control mt-1\" rows=\"15\" id=\"cstm_other_special_instructions\" name=\"cstm_other_special_instructions\"></textarea>";
				}
			?>
		</div>
	</div>
