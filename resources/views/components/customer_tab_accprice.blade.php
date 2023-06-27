<?php
	use App\Models\Customer;
	use App\Models\CstmAccountPrice;
	use App\Models\Zone;
	
	$zones = Zone::all()->sortBy('zone_name');
?>

	<div class="row">
		<div class="col">
			<table class="table table-striped table-sm table-bordered my-3">
				<thead style="background: var(--bs-teal);">
					<tr>
						<th>Chassis</th>
						<th>From</th>
						<th>To</th>
						<th>Charge</th>
						<th>Job Type</th>
						<th>One Way</th>
						<th>MT Return</th>
					</tr>
				</thead>
				<tbody class="table-group-divider">
					<?php
						$id = $_GET['id'];
						if ($id) {
							$customer = Customer::where('id', $id)->first();
							$cstmPrices = CstmAccountPrice::where('cstm_account_no', $customer->cstm_account_no)->orderBy('cstm_account_from', 'asc')->get();								
							foreach ($cstmPrices as $cstmPrice) {
								echo "<tr>";
								echo "<td><a href=\"customer_accprice_selected_main?id=$cstmPrice->id\">".$cstmPrice->cstm_account_chassis."</a></td>";
								echo "<td><a href=\"customer_accprice_selected_main?id=$cstmPrice->id\">".$cstmPrice->cstm_account_from."</a></td>";
								echo "<td><a href=\"customer_accprice_selected_main?id=$cstmPrice->id\">".$cstmPrice->cstm_account_to."</td>";
								echo "<td><a href=\"customer_accprice_selected_main?id=$cstmPrice->id\">".$cstmPrice->cstm_account_charge."</td>";
								echo "<td><a href=\"customer_accprice_selected_main?id=$cstmPrice->id\">".$cstmPrice->cstm_account_job_type."</td>";
								if ($cstmPrice->cstm_account_one_way) {
									echo "<td><a href=\"customer_accprice_selected_main?id=$cstmPrice->id\">T</td>";
								} else {
									echo "<td><a href=\"customer_accprice_selected_main?id=$cstmPrice->id\">F</td>";
								}
								echo "<td><a href=\"customer_accprice_selected_main?id=$cstmPrice->id\">".$cstmPrice->cstm_account_mt_return."</td>";
								echo "</tr>";
							}
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
