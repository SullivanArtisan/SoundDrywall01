	<div class="row">
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<textarea class=\"form-control mt-1\" rows=\"15\" id=\"cstm_other_notes\" name=\"cstm_other_notes\" placeholder=\"".$dbTable->cstm_other_notes."\">".$dbTable->cstm_other_notes."</textarea>";
				} else {
					echo "<textarea class=\"form-control mt-1\" rows=\"15\" id=\"cstm_other_notes\" name=\"cstm_other_notes\"></textarea>";
				}
			?>
		</div>
	</div>
