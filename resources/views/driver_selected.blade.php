<?php
	use App\Models\Driver;
?>

@extends('layouts.home_page_base')
<style>
.my-text-height {height:75%;}
</style>

@section('goback')
	<a class="text-primary" href="{{route('driver_main')}}" style="margin-right: 10px;">Back</a>
@show

<?php
	$id = $_GET['driverId'];
	if ($id) {
		$driver = Driver::where('id', $id)->first();
		// $cstmDispatch = CstmDispatch::where('cstm_account_no', $customer->cstm_account_no)->first();
		// $cstmInvoice = CstmInvoice::where('cstm_account_no', $customer->cstm_account_no)->first();
		// $cstmAllOther = CstmAllOther::where('cstm_account_no', $customer->cstm_account_no)->first();
	}
?>
	
<link rel="stylesheet" href="css/all_tabs_for_customers.css">

@if (!$id or !$driver) {
	@section('function_page')
		<div>
			<div class="row">
				<div class="col col-sm-auto">
					<h2 class="text-muted pl-2">Result of the Driver Operation</h2>
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
					<h2 class="text-muted pl-2">Driver: {{$driver->dvr_name}}</h2>
				</div>
				<div class="col-1 my-auto ml-5">
					<button class="btn btn-danger me-2" type="button"><a href="{{route('driver_delete', ['id'=>$id])}}" onclick="return myConfirmation();">Delete</a></button>
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
				<form method="post" action="{{route('op_result.driver_update', ['id'=>$id])}}">
					@csrf
					<ul class="nav nav-tabs" id="myTab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active " id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="true">Contact</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="generalinfo-tab" data-toggle="tab" href="#generalinfo" role="tab" aria-controls="generalinfo" aria-selected="false">General Info</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="license-tab" data-toggle="tab" href="#license" role="tab" aria-controls="license" aria-selected="false">License</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="payinfo-tab" data-toggle="tab" href="#payinfo" role="tab" aria-controls="payinfo" aria-selected="false">Pay Info</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="notes-tab" data-toggle="tab" href="#notes" role="tab" aria-controls="notes" aria-selected="false">Notes</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="changelogs-tab" data-toggle="tab" href="#changelogs" role="tab" aria-controls="changelogs" aria-selected="false">Change Logs</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="history-tab" data-toggle="tab" href="#history" role="tab" aria-controls="history" aria-selected="false">History</a>
						</li>
					</ul>

					<div class="tab-content" id="myTabContent">
						<div class="tab-pane fade show active" id="contact" role="tabpanel" aria-labelledby="contact-tab">
							@include('components.driver_tab_contact', ['dbTable'=>$driver])
						</div>
						<div class="tab-pane fade" id="generalinfo" role="tabpanel" aria-labelledby="generalinfo-tab">
							@include('components.driver_tab_generalinfo', ['dbTable'=>$driver])
						</div>
						<div class="tab-pane fade" id="license" role="tabpanel" aria-labelledby="license-tab">
							@include('components.driver_tab_license', ['dbTable'=>$driver])
						</div>
						<div class="tab-pane fade" id="payinfo" role="tabpanel" aria-labelledby="payinfo-tab">
							@include('components.driver_tab_payinfo', ['dbTable'=>$driver])
						</div>
						<div class="tab-pane fade" id="notes" role="tabpanel" aria-labelledby="notes-tab">
							@include('components.driver_tab_notes', ['dbTable'=>$driver])
						</div>
						<div class="tab-pane fade" id="changelogs" role="tabpanel" aria-labelledby="changelogs-tab">
							@include('components.driver_tab_changelogs', ['dbTable'=>$driver])
						</div>
						<div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
							@include('components.driver_tab_history', ['dbTable'=>$driver])
						</div>
					</div>
					<div class="row my-3">
						<div class="w-25"></div>
						<div class="col">
							<div class="row">
								<button class="btn btn-warning mx-4" type="submit">Update</button>
								<button class="btn btn-secondary mx-3" type="button"><a href="{{route('driver_main')}}">Cancel</a></button>
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
				if(!confirm("Are you sure to delete this driver?"))
				event.preventDefault();
			}
		</script>
	@endsection
}
@endif

	<?php
	?>

