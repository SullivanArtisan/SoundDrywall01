@extends('layouts.home_page_base')

@section('goback')
	<a class="text-primary" href="{{route('home_page')}}" style="margin-right: 10px;">Back</a>
@show

@section('function_page')
    <div>
        <div class="row m-4">
            <div>
				<h4 class="text-center text-danger font-italic pl-2" style="font-family: Times New Roman;">This function is still under construction. Please come back later.</h4>
            </div>
        </div>
    </div>
@endsection
