    <div class="row">
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<textarea readonly class=\"form-control mt-1\" rows=\"500\" id=\"dvr_change_log\" name=\"dvr_change_log\" placeholder=\"".$dbTable->dvr_change_log."\"></textarea>";
				} else {
					echo "<textarea readonly class=\"form-control mt-1\" rows=\"500\" id=\"dvr_change_log\" name=\"dvr_change_log\"></textarea>";
				}
			?>
		</div>
	</div>
