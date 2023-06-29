
<?php

	if (isset($_GET['bookingTab'])) {
		$booking_tab = $_GET['bookingTab'];
	} else {
		$booking_tab = '';
	}

	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		$booking = \App\Models\Booking::where('id', $id)->first();
		$containers = \App\Models\Container::where('cntnr_job_no', $booking->bk_job_no)->where('cntnr_status', '<>', 'deleted')->get();
		$cntnr_job_no = $booking->bk_job_no;
		//$containers = \App\Models\Container::where('cntnr_job_no', 'LIKE', 'ML%')->orderBy('cntnr_job_no', 'asc')->distinct()->get(['cntnr_job_no']);
	} else {
		if (isset($_GET['selJobId'])) {		// Enter this page from booking_selected.blade
			$containers = \App\Models\Container::where('cntnr_job_no', $booking->bk_job_no)->where('cntnr_status', '<>', 'deleted')->get();
			$cntnr_job_no = $booking->bk_job_no;
		} else {
			$id = '';
			$containers = [];
			$cntnr_job_no = "";
		}
	}


	// Title Line
	$outContents = "<div class=\"container mw-100\">";
	$outContents .= "<div class=\"row bg-info text-white fw-bold mb-2\">";
		$outContents .= "<div class=\"col-2 mt-1 align-middle\">";
			$outContents .= "Container ID";
		$outContents .= "</div>";
		$outContents .= "<div class=\"col-2 mt-1 align-middle\">";
			$outContents .= "Status";
		$outContents .= "</div>";
		$outContents .= "<div class=\"col-2 mt-1 align-middle\">";
			$outContents .= "Size";
		$outContents .= "</div>";
		$outContents .= "<div class=\"col-2 mt-1 align-middle\">";
			$outContents .= "Chassis Type";
		$outContents .= "</div>";
		$outContents .= "<div class=\"col-2 mt-1 align-middle\">";
			$outContents .= "Total Movements";
		$outContents .= "</div>";
		$outContents .= "<div class=\"col-2 align-middle\">";
			$outContents .= "Movements";
			//$outContents .= "<button class=\"btn btn-secondary mx-3\" type=\"button\"><a href=\"".route('booking_main')."\">Process Movements</a></button>";
		$outContents .= "</div>";
	$outContents .= "</div>";
	echo $outContents;

	// Body Lines
	$selected_container	 = "";
	$selected_containers = array();
	$listed_containers = 0;
	foreach ($containers as $container) {
		$selected_container = $container->id;
		$listed_containers++;
		if ($listed_containers % 2) {
			$outContents = "<div class=\"row\" style=\"background-color:Lavender\">";
		} else {
			$outContents = "<div class=\"row\" style=\"background-color:PaleGreen\">";
		}
			$outContents .= "<div class=\"col-2\">";
				if (!isset($_GET['selJobId'])) {
					$outContents .= "<a href=\"".route('container_selected', ['cntnrId='.$container->id, 'cntnrJobNo='.$container->cntnr_job_no])."\">";
				} else {
					$outContents .= "<a href=\"".route('container_selected', ['cntnrId='.$container->id, 'cntnrJobNo='.$container->cntnr_job_no, 'prevPage=booking_selected', 'selJobId='.$booking->id])."\">";
				}
				$outContents .= $container->cntnr_name;
				$outContents .= "</a>";
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2\">";
				$outContents .= $container->cntnr_status;
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2\">";
				$outContents .= $container->cntnr_size;
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2\">";
				$outContents .= $container->cntnr_chassis_type;
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2\">";
				//$outContents .= $container->cntnr_job_no;
			$outContents .= "</div>";
			$outContents .= "<div class=\"col-2\">";
				$outContents .= "<button class=\"btn btn-secondary btn-sm my-1\" type=\"button\"><a href=\"".route('movements_selected', ['cntnrId'=>$container->id])."\">Edit Movements</a></button>";
			$outContents .= "</div>";
		$outContents .= "</div>";
		echo $outContents;
	}
	?>

	<?php
	$outContents = "</div>";
	echo $outContents;
	?>

	<div class="card my-4">
		<div class="card-body">
			<div class="row">
				<h5 class="card-title ml-2">New Container</h5>
			</div>
			<div class="row">
				<div class="col-2"><label class="col-form-label">Container:&nbsp;</label></div>
				<div class="col-4">
					<input class=form-control mt-1 my-text-height type=text id=cntnr_name name=cntnr_name>
				</div>
				<div class="col-2"><label class="col-form-label">Goods Desc:&nbsp;</label></div>
				<div class="col-4">
					<input class=form-control mt-1 my-text-height type=text id=cntnr_goods_desc name=cntnr_goods_desc>
				</div>
			</div>
			<div class="row">
				<div class="col-2"><label class="col-form-label">Container Size:&nbsp;</label></div>
				<div class="col-4">
					<input list="cntnr_size" name="cntnr_size" id="cntnr_size_li" class="form-control mt-1 my-text-height">
						<datalist id="cntnr_size">
							<option value="AAAA">
							<option value="BBBB">
							<option value="CCCC">
						</datalist>
					</input>
				</div>
				<div class="col-2"><label class="col-form-label">Drop Only:&nbsp;</label></div>
				<div class="col-4">
					<input type=checkbox style=margin-top:3% id="cntnr_drop_only" name="cntnr_drop_only">
				</div>
			</div>
			<div class="row">
				<div class="col-2"><label class="col-form-label">Customs Release Date:&nbsp;</label></div>
				<div class="col-4">
					<input class=form-control mt-1 my-text-height type=date id=cntnr_cstm_release_date name=cntnr_cstm_release_date>
				</div>
				<div class="col-2"><label class="col-form-label">Customs Release Time:&nbsp;</label></div>
				<div class="col-4">
					<input class=form-control mt-1 my-text-height type=time id=cntnr_cstm_release_time name=cntnr_cstm_release_time>
				</div>
			</div>
			<div class="row">
				<div class="col-2"><label class="col-form-label">SSL Release Date:&nbsp;</label></div>
				<div class="col-4">
					<input class=form-control mt-1 my-text-height type=date id=cntnr_ssl_release_date name=cntnr_ssl_release_date>
				</div>
				<div class="col-2"><label class="col-form-label">SSL Last Free Date:&nbsp;</label></div>
				<div class="col-4">
					<input class=form-control mt-1 my-text-height type=date id=cntnr_ssl_lfd name=cntnr_ssl_lfd>
				</div>
			</div>
			<div class="row">
				<div class="col-2"><label class="col-form-label">Terminal Last Free Date:&nbsp;</label></div>
				<div class="col-4">
					<input class=form-control mt-1 my-text-height type=date id=cntnr_trmnl_lfd name=cntnr_trmnl_lfd>
				</div>
				<div class="col-2"><label class="col-form-label">&nbsp;</label></div>
				<div class="col-4"><input type="hidden" class="form-control mt-1 my-text-height" type="text"></div>
			</div>
			<div class="row">
				<div class="col-2"><label class="col-form-label">Cargo Weight:&nbsp;</label></div>
				<div class="col-4">
					<input class=form-control mt-1 my-text-height type=text id=cntnr_cargo_weight name=cntnr_cargo_weight>
				</div>
				<div class="col-1">
					<?php
					$tagHead = "<input list=\"cntnr_weight_unit\" name=\"cntnr_weight_unit\" id=\"cntnrweightunitinput\" class=\"form-control mt-1 my-text-height\" ";
					$tagTail = "><datalist id=\"cntnr_weight_unit\">";
					$tagTail.= "<option value=\"Kgs\">";
					$tagTail.= "<option value=\"Lbs\">";
					$tagTail.= "</datalist>";
					echo $tagHead."placeholder=\"Kgs\" value=\"Kgs\"".$tagTail;
					?>
				</div>
				<div class="col-5"><input type="hidden" class="form-control mt-1 my-text-height" type="text"></div>
			</div>
			<div class="row">
				<div class="col-2"><label class="col-form-label">Steamship Line:&nbsp;</label></div>
				<div class="col-4">
					<input list="cntnr_ssl" name="cntnr_ssl" id="cntnr_ssl_li" class="form-control mt-1 my-text-height">
						<datalist id="cntnr_ssl">
							<option value="AAAA">
							<option value="BBBB">
							<option value="CCCC">
						</datalist>
					</input>
				</div>
				<div class="col-2"><label class="col-form-label">Chassis:&nbsp;</label></div>
				<div class="col-4">
					<input list="cntnr_chassis_type" name="cntnr_chassis_type" id="cntnr_chassis_type_li" class="form-control mt-1 my-text-height">
						<datalist id="cntnr_chassis_type">
							<option value="AAAA">
							<option value="BBBB">
							<option value="CCCC">
						</datalist>
					</input>
				</div>
			</div>
			<div class="row">
				<div class="col-2"><label class="col-form-label">Empty Return Depot:&nbsp;</label></div>
				<div class="col-4">
					<input list="cntnr_empty_return_trmnl" name="cntnr_empty_return_trmnl" id="cntnr_empty_return_trmnl_li" class="form-control mt-1 my-text-height">
						<datalist id="cntnr_empty_return_trmnl">
							<option value="AAAA">
							<option value="BBBB">
							<option value="CCCC">
						</datalist>
					</input>
				</div>
				<div class="col-2"><label class="col-form-label">MT Last Free Date:&nbsp;</label></div>
				<div class="col-4">
					<input class=form-control mt-1 my-text-height type=date id=cntnr_mt_lfd name=cntnr_mt_lfd>
				</div>
			</div>
			<div class="row">
				<div class="col-2"><label class="col-form-label">Seal Number:&nbsp;</label></div>
				<div class="col-4">
					<input class=form-control mt-1 my-text-height type=text id=cntnr_seal_no name=cntnr_seal_no>
				</div>
				<div class="col-2"><label class="col-form-label">Customer Order Number:&nbsp;</label></div>
				<div class="col-4">
					<input class=form-control mt-1 my-text-height type=text id=cntnr_cstm_order_no name=cntnr_cstm_order_no>
				</div>
			</div>
			<div class="row">
				<div class="col-2"><label class="col-form-label">Booking Number:&nbsp;</label></div>
				<div class="col-4">
					<input class=form-control mt-1 my-text-height type=text id=cntnr_job_no name=cntnr_job_no>
				</div>
				<div class="col-2"><button class="btn btn-primary my-1 type=button" onclick="AddNewContainer(event)">Add this Container</button></div>
				<div class="col-4"><input type="hidden" class="form-control mt-1 my-text-height" type="text"></div>
			</div>
		</div>	
	</div>	


	
	<script>
		$(document).ready(function() {
			$('.nav-tabs a').on('shown.bs.tab', function(event){		// Lock other tabs except the "Container Details" tab
				var bookingTab = {!! json_encode($booking_tab) !!};
				var id = {!! json_encode($id) !!};

				if (bookingTab == 'containerinfo-tab' && id != '') {
					document.getElementById('bookingdetail-tab').removeAttribute('class');
					document.getElementById('bookingdetail-tab').classList.add('nav-link');
					document.getElementById('containerinfo-tab').removeAttribute('class');
					document.getElementById('containerinfo-tab').classList.add('nav-link');
					document.getElementById('containerinfo-tab').classList.add('active');				// <---- active

					document.getElementById('bookingdetail-tab').setAttribute("aria-checked", false);
					document.getElementById('containerinfo-tab').setAttribute("aria-checked", true);	// <---- active

					document.getElementById('bookingdetail').removeAttribute('class');
					document.getElementById('bookingdetail').classList.add('tab-pane');
					document.getElementById('bookingdetail').classList.add('show');

					document.getElementById('containerinfo').removeAttribute('class');
					document.getElementById('containerinfo').classList.add('tab-pane');
					document.getElementById('containerinfo').classList.add('show');
					document.getElementById('containerinfo').classList.add('fade');						// <---- active
					document.getElementById('containerinfo').classList.add('active');					// <---- active
				}
			});
		});
	</script>	

	<script>
		function AddNewContainer(e) {
			e.preventDefault();
			var token = "{{ csrf_token() }}";
			var cntnr_job_no = {!! json_encode($cntnr_job_no) !!};
			var cntnr_name = document.getElementById("cntnr_name").value;
			var cntnr_goods_desc = document.getElementById("cntnr_goods_desc").value;
			$.ajax({
				url: '/container_add',
				type: 'POST',
				data: {_token:token, cntnr_job_no:cntnr_job_no, cntnr_name:cntnr_name,	cntnr_goods_desc:cntnr_goods_desc},    // the _token:token is for Laravel
				success: function(dataRetFromPHP) {
					location.href = location.href;
				}
			});
		}
	</script>