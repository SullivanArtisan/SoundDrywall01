<?php
	use App\Models\Customer;
	use App\Models\CstmDispatch;
	use App\Models\CstmInvoice;
	use App\Models\CstmAccountPrice;
	use App\Models\CstmAllOther;
?>

@extends('layouts.home_page_base')
<style>
.my-text-height {height:75%;}
</style>

@section('goback')
	<a class="text-primary" href="{{route('customer_main')}}" style="margin-right: 10px;">Back</a>
@show

<?php
	$id = $_GET['id'];
	if ($id) {
		$customer = Customer::where('id', $id)->first();
		$cstmDispatch = CstmDispatch::where('cstm_account_no', $customer->cstm_account_no)->first();
		$cstmInvoice = CstmInvoice::where('cstm_account_no', $customer->cstm_account_no)->first();
		$cstmAllOther = CstmAllOther::where('cstm_account_no', $customer->cstm_account_no)->first();
	}
?>
	
<link rel="stylesheet" href="css/all_tabs_for_customers.css">

@if (!$id or !$customer or !$cstmDispatch or !$cstmInvoice or !$cstmAllOther) {
	@section('function_page')
		<div>
			<div class="row">
				<div class="col col-sm-auto">
					<h2 class="text-muted pl-2">Result of the Customer Operation</h2>
				</div>
				<div class="col"></div>
			</div>
		</div>
		
		<div class="alert alert-success m-4">
			<?php
				echo "<span style=\"color:red\">Data cannot NOT be found!</span>";
			?>
		</div>
	@endsection
}
@else {
	@section('function_page')
		<div>
			<div class="row m-4">
				<div>
					<h2 class="text-muted pl-2">Customer: {{$customer->cstm_account_name}}</h2>
				</div>
				<div class="col-1 my-auto ml-5">
					<button class="btn btn-danger me-2" type="button"><a href="{{route('customer_delete', ['id'=>$id])}}" onclick="return myConfirmation();">Delete</a></button>
				</div>
				<div class="col my-auto">
					<button class="btn btn-success me-2" type="button"><a href="{{route('customer_accprice_add', ['id'=>$id])}}">Add New Price</a></button>
				</div>
			</div>
		</div>
		<div>
			@if ($errors->any())
				<div class="alert alert-danger">
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif
			<div class="col-md-11 mb-4">
				<form method="post" action="{{route('op_result.customer_update', ['id'=>$id])}}">
					@csrf
					<ul class="nav nav-tabs" id="myTab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active " id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="true">Contact</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="dispatch-tab" data-toggle="tab" href="#dispatch" role="tab" aria-controls="dispatch" aria-selected="false">Dispatch</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="notes-tab" data-toggle="tab" href="#notes" role="tab" aria-controls="notes" aria-selected="false">Notes</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="invoice-tab" data-toggle="tab" href="#invoice" role="tab" aria-controls="invoice" aria-selected="false">Invoice</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="changes-tab" data-toggle="tab" href="#changes" role="tab" aria-controls="changes" aria-selected="false">Changes</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="control2-tab" data-toggle="tab" href="#control2" role="tab" aria-controls="control2" aria-selected="false">Control 2</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="history-tab" data-toggle="tab" href="#history" role="tab" aria-controls="history" aria-selected="false">History</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="accprices-tab" data-toggle="tab" href="#accprices" role="tab" aria-controls="accprices" aria-selected="false">Account Prices</a>
						</li>
					</ul>

					<div class="tab-content" id="myTabContent">
						<div class="tab-pane fade show active" id="contact" role="tabpanel" aria-labelledby="contact-tab">
							@include('components.customer_tab_contact', ['dbTable'=>$customer])
						</div>
						<div class="tab-pane fade" id="dispatch" role="tabpanel" aria-labelledby="dispatch-tab">
							@include('components.customer_tab_dispatch', ['dbTable'=>$cstmDispatch])
						</div>
						<div class="tab-pane fade" id="notes" role="tabpanel" aria-labelledby="notes-tab">
							@include('components.customer_tab_notes', ['dbTable'=>$cstmAllOther])
						</div>
						<div class="tab-pane fade" id="invoice" role="tabpanel" aria-labelledby="invoice-tab">
							@include('components.customer_tab_invoice', ['dbTable'=>$cstmInvoice])
						</div>
						<div class="tab-pane fade" id="changes" role="tabpanel" aria-labelledby="changes-tab">
							@include('components.customer_tab_changes')
						</div>
						<div class="tab-pane fade" id="control2" role="tabpanel" aria-labelledby="control2-tab">
							@include('components.customer_tab_control2', ['dbTable'=>$cstmAllOther])
						</div>
						<div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
							@include('components.customer_tab_history')
						</div>
						<div class="tab-pane fade" id="accprices" role="tabpanel" aria-labelledby="accprices-tab">
							@include('components.customer_tab_accprice')
						</div>
					</div>
					<div class="row my-3">
						<div class="w-25"></div>
						<div class="col">
							<div class="row">
								<button class="btn btn-warning mx-4" type="submit">Update</button>
								<button class="btn btn-secondary mx-3" type="button"><a href="{{route('customer_main')}}">Cancel</a></button>
							</div>
						</div>
						<div class="col"></div>
					</div>
				</form>
			</div>
		</div>
		<script>
		</script>
		
		<script>
			function myConfirmation() {
				if(!confirm("Are you sure to delete this customer?"))
				event.preventDefault();
			}
		</script>
	@endsection
}
@endif

	<?php
	?>

