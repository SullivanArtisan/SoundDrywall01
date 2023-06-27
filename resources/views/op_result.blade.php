@extends('layouts.home_page_base')

@section('goback')
	<?php
	use App\Models\Booking;
	use App\Models\Container;

	if ($oprand == "unit") {		// This is a special case for power_unit_main as there are 2 words: power and unit. I don't want to change file names for consistance reason.
			$backPath = '<a class="text-primary" href="'.route('power_unit_main').'" style="margin-right: 10px;">Back</a>';
		} else if ($oprand == "user") {	// This is another special case for system_user_main as there are 2 words: system and user. I don't want to change file names for consistance reason.
			$backPath = '<a class="text-primary" href="'.route('system_user_main').'" style="margin-right: 10px;">Back</a>';
		} else if ($oprand == "container") {	// This is another special case for container_main as the container_main not exists; I have to go to the special URL
			if (!isset($_GET['prevPage'])) {
				$container = Container::where('id', $_GET['id'])->first();
				$booking = Booking::where('bk_job_no', $container->cntnr_job_no)->first();
				$backPath = '<a class="text-primary" href="'.route('booking_add', ['bookingTab'=>'containerinfo-tab', 'id'=>$booking->id]).'" style="margin-right: 10px;">Back</a>';
			} else {
				$backPath = '<a class="text-primary" href="'.route('booking_selected', ['bookingTab'=>'containerinfo-tab', 'selJobId'=>$_GET['selJobId']]).'" style="margin-right: 10px;">Back</a>';
			}
		} else if ($oprand == "dispatch") {
			// if (!isset($_GET['cntnrId'])) {
				$backPath = '<a class="text-primary" href="'.route('dispatch_main').'" style="margin-right: 10px;">Back</a>';
			// } else {
			// 	$backPath = '<a class="text-primary" href="'.route('dispatch_container', ['cntnrId'=>$_GET['cntnrId']]).'" style="margin-right: 10px;">Back</a>';
			// }
		} else {
			$tmpPath = $oprand.'_main';
			$backPath = '<a class="text-primary" href="'.route($tmpPath).'" style="margin-right: 10px;">Back</a>';
		}
		echo $backPath;
	?>
@show


@section('function_page')
    <div>
        <div class="row">
            <div class="col col-sm-auto">
				<h2 class="text-muted pl-2">Result of the <?php echo ucfirst($oprand) ?> Operation</h2>
            </div>
            <div class="col"></div>
        </div>
    </div>
	
	@if(session('status'))
	<div class="alert alert-success">
		<?php
			$text = session('status');
			echo $text;
		?>
	</div>
	@endif
@endsection
