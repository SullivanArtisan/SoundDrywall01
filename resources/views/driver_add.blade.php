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

@section('function_page')
	<div>
		<h2 class="text-muted pl-2 mb-2">Add a New Driver</h2>
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
			<form method="post" action="{{route('op_result.driver_add')}}">
				@csrf
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active " id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="true">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="generalinfo-tab" data-toggle="tab" href="#generalinfo" role="tab" aria-controls="generalinfo" aria-selected="false">GeneralInfo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="license-tab" data-toggle="tab" href="#license" role="tab" aria-controls="license" aria-selected="false">License</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="payinfo-tab" data-toggle="tab" href="#payinfo" role="tab" aria-controls="payinfo" aria-selected="false">PayInfo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="notes-tab" data-toggle="tab" href="#notes" role="tab" aria-controls="notes" aria-selected="false">Notes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="changelogs-tab" data-toggle="tab" href="#changelogs" role="tab" aria-controls="changelogs" aria-selected="false">ChangeLogs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="history-tab" data-toggle="tab" href="#history" role="tab" aria-controls="history" aria-selected="false">History</a>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                        @include('components.driver_tab_contact')
                    </div>
                    <div class="tab-pane fade" id="generalinfo" role="tabpanel" aria-labelledby="generalinfo-tab">
                        @include('components.driver_tab_generalinfo')
                    </div>
                    <div class="tab-pane fade" id="license" role="tabpanel" aria-labelledby="license-tab">
                        @include('components.driver_tab_license')
                    </div>
                    <div class="tab-pane fade" id="payinfo" role="tabpanel" aria-labelledby="payinfo-tab">
                        @include('components.driver_tab_payinfo')
                    </div>
                    <div class="tab-pane fade" id="notes" role="tabpanel" aria-labelledby="notes-tab">
                        @include('components.driver_tab_notes')
                    </div>
                    <div class="tab-pane fade" id="changelogs" role="tabpanel" aria-labelledby="changelogs-tab">
                        @include('components.driver_tab_changelogs')
                    </div>
                    <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
                        @include('components.driver_tab_history')
                    </div>
                </div>
				<div class="row my-3">
					<div class="w-25"></div>
					<div class="col">
						<div class="row">
							<button class="btn btn-success mx-4" type="submit">Save</button>
							<button class="btn btn-secondary mx-3" type="button"><a href="{{route('driver_main')}}">Cancel</a></button>
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
