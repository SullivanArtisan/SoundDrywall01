	<div class="row">
	<div class="col">
			<?php
				// echo "<div class=\"col-md-11 mb-4\">";
				// 	echo "<p>HOHOHO</p>";
				// 	echo "<p>HAHAHA</p>";
				// echo "</div>";
				if(isset($dbTable)) {
					echo "<textarea readonly readonly class=\"form-control mt-1\" rows=\"500\" id=\"dvr_history\" name=\"dvr_history\" placeholder=\"".$dbTable->dvr_history."\"></textarea>";
				} else {
					echo "<textarea readonly readonly class=\"form-control mt-1\" rows=\"500\" id=\"dvr_history\" name=\"dvr_history\"></textarea>";
				}
			?>
		</div>
		<?php
		// <div class="col">
		// 	<ul class="nav nav-tabs" id="myTab" role="tablist">
		// 		<li class="nav-item">
		// 			<a class="nav-link active " id="movement-tab" data-toggle="tab" href="#movement" role="tab" aria-controls="movement" aria-selected="true">Movements</a>
		// 		</li>
		// 		<li class="nav-item">
		// 			<a class="nav-link" id="charge-tab" data-toggle="tab" href="#charge" role="tab" aria-controls="charge" aria-selected="false">Charges</a>
		// 		</li>
		// 		<li class="nav-item">
		// 			<a class="nav-link" id="customform-tab" data-toggle="tab" href="#customform" role="tab" aria-controls="customform" aria-selected="false">Customs Forms</a>
		// 		</li>
		// 	</ul>
		// 	<div class="tab-content" id="myTabContent">
		// 		<div class="tab-pane fade show active" id="movement" role="tabpanel" aria-labelledby="movement-tab">
		// 			@include('components.driver_tab_movement', ['dbTable'=>$driver])
		// 		</div>
		// 		<div class="tab-pane fade" id="charge" role="tabpanel" aria-labelledby="charge-tab">
		// 			@include('components.driver_tab_charge', ['dbTable'=>$driver])
		// 		</div>
		// 		<div class="tab-pane fade" id="customform" role="tabpanel" aria-labelledby="customform-tab">
		// 			@include('components.driver_tab_customform', ['dbTable'=>$driver])
		// 		</div>
		// 	</div>
		// </div>
		?>
	</div>
