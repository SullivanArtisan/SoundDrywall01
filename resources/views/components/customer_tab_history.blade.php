	<div class="row">
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<textarea readonly class=\"form-control mt-1\" rows=\"20\" id=\"cstm_other_histories\" name=\"cstm_other_histories\" placeholder=\"".$dbTable->cstm_other_histories."\"></textarea>";
				} else {
					echo "<textarea readonly class=\"form-control mt-1\" rows=\"20\" id=\"cstm_other_histories\" name=\"cstm_other_histories\"></textarea>";
				}
			?>
		</div>
	</div>
