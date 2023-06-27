    <div class="row">
		<div class="col">
			<p>Movements are ....</p>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			$('.nav-tabs a').on('shown.bs.tab', function(event){		// Lock other tabs except the "Movement Details" tab
				var bookingTab = {!! json_encode($booking_tab) !!};
				var id = {!! json_encode($id) !!};

				if (bookingTab == 'movementinfo-tab' && id != '') {
					document.getElementById('bookingdetail-tab').removeAttribute('class');
					document.getElementById('bookingdetail-tab').classList.add('nav-link');
					document.getElementById('containerinfo-tab').removeAttribute('class');
					document.getElementById('containerinfo-tab').classList.add('nav-link');
					document.getElementById('movementinfo-tab').removeAttribute('class');
					document.getElementById('movementinfo-tab').classList.add('nav-link');
					document.getElementById('movementinfo-tab').classList.add('active');                // <---- active
					document.getElementById('dispatchinfo-tab').removeAttribute('class');
					document.getElementById('dispatchinfo-tab').classList.add('nav-link');

					document.getElementById('bookingdetail-tab').setAttribute("aria-checked", false);
					document.getElementById('containerinfo-tab').setAttribute("aria-checked", false);
					document.getElementById('movementinfo-tab').setAttribute("aria-checked", true);     // <---- active
					document.getElementById('dispatchinfo-tab').setAttribute("aria-checked", false);

					document.getElementById('bookingdetail').removeAttribute('class');
					document.getElementById('bookingdetail').classList.add('tab-pane');
					document.getElementById('bookingdetail').classList.add('show');

					document.getElementById('containerinfo').removeAttribute('class');
					document.getElementById('containerinfo').classList.add('tab-pane');
					document.getElementById('containerinfo').classList.add('show');

					document.getElementById('movementinfo').removeAttribute('class');
					document.getElementById('movementinfo').classList.add('tab-pane');
					document.getElementById('movementinfo').classList.add('show');
					document.getElementById('movementinfo').classList.add('fade');                      // <---- active
					document.getElementById('movementinfo').classList.add('active');                    // <---- active

					document.getElementById('dispatchinfo').removeAttribute('class');
					document.getElementById('dispatchinfo').classList.add('tab-pane');
					document.getElementById('dispatchinfo').classList.add('show');
				}
			});
		});
	</script>	
