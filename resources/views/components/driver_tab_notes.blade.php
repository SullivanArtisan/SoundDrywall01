	<div class="row">
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<textarea class=\"form-control mt-1\" rows=\"250\" id=\"dvr_notes\" name=\"dvr_notes\" placeholder=\"".$dbTable->dvr_notes."\">".$dbTable->dvr_notes."</textarea>";
				} else {
					echo "<textarea class=\"form-control mt-1\" rows=\"250\" id=\"dvr_notes\" name=\"dvr_notes\"></textarea>";
				}
			?>
		</div>
	</div>
