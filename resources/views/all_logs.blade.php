@extends('layouts.home_page_base')

@section('goback')
	<a class="text-primary" href="{{route('home_page')}}" style="margin-right: 10px;">Back</a>
@show

@section('function_page')
    <div>
        <div class="row m-4">
            <div>
				<h2 class="text-muted pl-2">Result of Laravel.log</h2>
            </div>
            <div class="col my-auto ml-5">
            </div>
        </div>
    </div>
	<?php
        $path = "../storage/logs/";
        if (!copy($path."laravel.log", $path."copy_of_laravel.log")) {
            Log::Info("Woops, failed to copy laravel.log!");
        } else {
            $logfile = file($path."laravel.log");
            $logfile = array_reverse($logfile);
            if (count($logfile) > 0) {
                foreach($logfile as $lf){
                    echo $lf."<br />";
                }
            } else {
                Log::Info("The file laravel.log is empty!");
            }
        }
    ?>
@endsection

<script>
	window.onload = function() {
	}
</script>