<?php
	use App\Models\GeofenceFacility;
	use Illuminate\Support\Facades\Session;
?>

@extends('layouts.home_page_base')
<style>
.my-text-height {height:75%;}
</style>

@section('goback')
	<a class="text-primary" href="{{route('customer_main')}}" style="margin-right: 10px;">Back</a>
@show

@section('function_page')
	<div>
		<h2 class="text-muted pl-2 mb-2">Add a New Customer</h2>
	</div>
	<!--
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
	-->
	
    <link rel="stylesheet" href="css/all_tabs_for_customers.css">

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
			<form method="post" action="{{route('op_result.customer_add')}}">
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
					{{--
					<li class="nav-item">
						<a class="nav-link" id="accprices-tab" data-toggle="tab" href="#accprices" role="tab" aria-controls="accprices" aria-selected="false">Account Prices</a>
					</li>
					--}}
				</ul>

				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="contact" role="tabpanel" aria-labelledby="contact-tab">
						@include('components.customer_tab_contact')
					</div>
					<div class="tab-pane fade" id="dispatch" role="tabpanel" aria-labelledby="dispatch-tab">
						@include('components.customer_tab_dispatch')
					</div>
					<div class="tab-pane fade" id="notes" role="tabpanel" aria-labelledby="notes-tab">
						@include('components.customer_tab_notes')
					</div>
					<div class="tab-pane fade" id="invoice" role="tabpanel" aria-labelledby="invoice-tab">
						@include('components.customer_tab_invoice')
					</div>
					<div class="tab-pane fade" id="changes" role="tabpanel" aria-labelledby="changes-tab">
						@include('components.customer_tab_changes')
					</div>
					<div class="tab-pane fade" id="control2" role="tabpanel" aria-labelledby="control2-tab">
						@include('components.customer_tab_control2')
					</div>
					<div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
						@include('components.customer_tab_history')
					</div>
					{{--
					<div class="tab-pane fade" id="accprices" role="tabpanel" aria-labelledby="accprices-tab">
						@include('components.customer_tab_accprice')
					</div>
					--}}
				</div>
				<div class="row my-3">
					<div class="w-25"></div>
					<div class="col">
						<div class="row">
							<button class="btn btn-success mx-4" type="submit">Save</button>
							<button class="btn btn-secondary mx-3" type="button"><a href="{{route('customer_main')}}">Cancel</a></button>
						</div>
					</div>
					<div class="col"></div>
				</div>
			</form>
		</div>
    </div>
	
	<!--
	<script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.0/dist/js.cookie.min.js"></script>
	-->
@endsection
