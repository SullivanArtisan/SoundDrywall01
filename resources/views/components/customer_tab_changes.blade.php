	<div class="row">
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<textarea readonly class=\"form-control mt-1\" rows=\"15\" id=\"cstm_other_changes\" name=\"cstm_other_changes\" placeholder=\"".$dbTable->cstm_other_changes."\"></textarea>";
				} else {
					echo "<textarea readonly class=\"form-control mt-1\" rows=\"15\" id=\"cstm_other_changes\" name=\"cstm_other_changes\"></textarea>";
				}
			?>
		</div>
	</div>
