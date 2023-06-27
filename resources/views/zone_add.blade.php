<?php
	use App\Models\PowerUnit;
	use Illuminate\Support\Facades\Session;
?>

@extends('layouts.home_page_base')
<style>
.my-text-height {height:75%;}
</style>

@section('goback')
	<a class="text-primary" href="{{route('zone_main')}}" style="margin-right: 10px;">Back</a>
@show

@section('function_page')
	<div>
		<h2 class="text-muted pl-2 mb-2">Add a New Zone</h2>
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
        <div class="row">
            <div class="col">
                <form method="post" action="{{route('op_result.zone_add')}}">
					@csrf
                    <div class="row">
                        <div class="col"><label class="col-form-label">Zone Name:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="zone_name" name="zone_name"></div>
                        <div class="col"><label class="col-form-label">Zone Group:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="text" id="zone_group" name="zone_group"></div>
                    </div>
                    <div class="row">
                        <div class="col"><label class="col-form-label">Zone Description:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1v" type="text" id="zone_description" name="zone_description"></div>
                        <div class="col"><label class="col-form-label">FSC Deduction %:&nbsp;</label></div>
                        <div class="col"><input class="form-control mt-1 my-text-height" type="number" id="zone_fsc_deduction" name="zone_fsc_deduction"></div>
                    </div>
                    <div class="row my-3">
                        <div class="w-25"></div>
                        <div class="col">
							<div class="row">
								<button class="btn btn-success mx-4" type="submit">Save</button>
								<button class="btn btn-secondary mx-3" type="button"><a href="{{route('zone_main')}}">Cancel</a></button>
							</div>
						</div>
                        <div class="col"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
	
	<script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.0/dist/js.cookie.min.js"></script>
@endsection
