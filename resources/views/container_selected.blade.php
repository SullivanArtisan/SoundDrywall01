<?php
	use App\Models\Container;
	use App\Models\Booking;
?>

@extends('layouts.home_page_base')
<style>
.my-text-height {height:75%;}
</style>

<?php
	$id = $_GET['cntnrId'];
	if ($id) {
		$container = Container::where('id', $id)->first();
		$booking = Booking::where('bk_job_no', $container->cntnr_job_no)->first();
    }

    if (isset($_GET['prevPage'])) {
        $prevPage = $_GET['prevPage'];
        $retParam = ['id'=>$id, 'prevPage'=>$prevPage, 'selJobId'=>$_GET['selJobId']];
    }
?>

@section('goback')
    <?php
        if (!isset($_GET['prevPage'])) {
            $toThisLink = "<a class=\"text-primary\" href=\"".route('booking_add', ['bookingTab'=>'containerinfo-tab', 'id'=>$booking->id])."\" style=\"margin-right: 10px;\">Back</a>";
        } else {
            $toThisLink = "<a class=\"text-primary\" href=\"".route($prevPage, ['selJobId'=>$_GET['selJobId']])."\" style=\"margin-right: 10px;\">Back</a>";
        }
        echo $toThisLink;
    ?>
@show

@if (!$id or !$container) {
	@section('function_page')
		<div>
			<div class="row">
				<div class="col col-sm-auto">
					<h2 class="text-muted pl-2">Result of the Container Operation</h2>
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
					<h2 class="text-muted pl-2">Container: {{$container->cntnr_name}} (Status: {{$container->cntnr_status}})</h2>
				</div>
				<div class="col ml-5">
					<button class="btn btn-danger" type="button"><a href="{{route('container_delete', ['id'=>$id])}}" onclick="return myConfirmation();">Delete</a></button>
					<button class="btn btn-primary ml-4" type="button"><a href="{{route('container_charges_main', ['cntnrId'=>$id, 'cntnrJobNo'=>$container->cntnr_job_no, 'prevPage'=>'booking_selected', 'selJobId'=>$booking->id])}}">Edit Surcharges</a></button>
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
			<div class="row">
				<div class="col">
                    @if (!isset($prevPage))
					<form method="post" action="{{route('op_result.container_update', ['id'=>$id])}}">
                    @else
					<form method="post" action="{{route('op_result.container_update', $retParam)}}">
                    @endif
						@csrf
						<div class="row mx-2">
							<div class="col-2"><label class="col-form-label">Container:&nbsp;</label></div>
							<div class="col-4"><input class="form-control mt-1 my-text-height" type="text" name="cntnr_name" value="{{$container->cntnr_name}}"></div>
							<div class="col-2"><label class="col-form-label">Goods' Desc.:&nbsp;</label></div>
                            <div class="col-4">
                                <input list="cntnr_goods_desc" name="cntnr_goods_desc" id="cntnrGoodsDescInput" class="form-control mt-1 my-text-height" value="{{$container->cntnr_goods_desc}}">
                                <datalist id="cntnr_goods_desc">
                                    <option value="General Freight">
                                    <option value="Dangourous Goods">
                                    <option value="Refrigerated Goods">
                                    <option value="High Value Goods">
                                </datalist>
                            </div>
                        </div>
						<div class="row mx-2">
							<div class="col-2"><label class="col-form-label">Container Size:&nbsp;</label></div>
                            <div class="col-4">
                                <input list="cntnr_size" name="cntnr_size" id="cntnrSizeInput" class="form-control mt-1 my-text-height" value="{{$container->cntnr_size}}">
                                <datalist id="cntnr_size">
                                    <option value="100 ft">
                                    <option value="150 ft">
                                    <option value="200 ft">
                                    <option value="250 ft">
                                </datalist>
                            </div>
                            <div class="col-2"><label class="col-form-label">Drop Only:&nbsp;</label></div>
                            <div class="col-4">
                                @if ($container->cntnr_droponly == 'T')
                                <input style="margin-top:3%" type="checkbox" id="cntnr_droponly" name="cntnr_droponly" checked>
                                @else
                                <input style="margin-top:3%" type="checkbox" id="cntnr_droponly" name="cntnr_droponly">
                                @endif
                            </div>
                        </div>
                        <div class="row mx-2">
                            <div class="col-2"><label class="col-form-label">Customs Release Date:&nbsp;</label></div>
                            <div class="col-4">
                                <input class=form-control mt-1 my-text-height type=date id=cntnr_cstm_release_date name=cntnr_cstm_release_date value="{{$container->cntnr_cstm_release_date}}">
                            </div>
                            <div class="col-2"><label class="col-form-label">Customs Release Time:&nbsp;</label></div>
                            <div class="col-4">
                                <input class=form-control mt-1 my-text-height type=time id=cntnr_cstm_release_time name=cntnr_cstm_release_time value="{{$container->cntnr_cstm_release_time}}">
                            </div>
                        </div>
                        <div class="row mx-2">
                            <div class="col-2"><label class="col-form-label">SSL Release Date:&nbsp;</label></div>
                            <div class="col-4">
                                <input class=form-control mt-1 my-text-height type=date id=cntnr_ssl_release_date name=cntnr_ssl_release_date value="{{$container->cntnr_ssl_release_date}}">
                            </div>
                            <div class="col-2"><label class="col-form-label">SSL Last Free Date:&nbsp;</label></div>
                            <div class="col-4">
                                <input class=form-control mt-1 my-text-height type=date id=cntnr_ssl_lfd name=cntnr_ssl_lfd value="{{$container->cntnr_ssl_lfd}}">
                            </div>
                        </div>
                        <div class="row mx-2">
                            <div class="col-2"><label class="col-form-label">Terminal Last Free Date:&nbsp;</label></div>
                            <div class="col-4">
                                <input class=form-control mt-1 my-text-height type=date id=cntnr_trmnl_lfd name=cntnr_trmnl_lfd>
                            </div>
                            <div class="col-2"><label class="col-form-label">&nbsp;</label></div>
                            <div class="col-4"><input type="hidden" class="form-control mt-1 my-text-height" type="text"></div>
                        </div>
                        <div class="row mx-2">
                            <div class="col-2"><label class="col-form-label">Cargo Weight:&nbsp;</label></div>
                            <div class="col-4">
                                <input class=form-control mt-1 my-text-height type=text id=cntnr_cargo_weight name=cntnr_cargo_weight value="{{$container->cntnr_cargo_weight}}">
                            </div>
                            <div class="col-1">
                                <?php
                                $tagHead = "<input list=\"cntnr_weight_unit\" name=\"cntnr_weight_unit\" id=\"cntnrweightunitinput\" class=\"form-control mt-1 my-text-height\" ";
                                $tagTail = "><datalist id=\"cntnr_weight_unit\">";
                                $tagTail.= "<option value=\"Kgs\">";
                                $tagTail.= "<option value=\"Lbs\">";
                                $tagTail.= "</datalist>";
                                if ($container->cntnr_weight_unit == 0) {
                                    echo $tagHead."placeholder=\"Kgs\" value=\"Kgs\"".$tagTail;
                                } else {
                                    echo $tagHead."placeholder=\"Lbs\" value=\"Lbs\"".$tagTail;
                                }
                                ?>
                            </div>
                            <div class="col-5"><input type="hidden" class="form-control mt-1 my-text-height" type="text"></div>
                        </div>
                        <div class="row mx-2">
                            <div class="col-2"><label class="col-form-label">Steamship Line:&nbsp;</label></div>
                            <div class="col-4">
                                <input list="cntnr_ssl" name="cntnr_ssl" id="cntnr_ssl_li" class="form-control mt-1 my-text-height" value="{{$container->cntnr_ssl}}">
                                    <datalist id="cntnr_ssl">
                                        <option value="AAAA">
                                        <option value="BBBB">
                                        <option value="CCCC">
                                    </datalist>
                                </input>
                            </div>
                            <div class="col-2"><label class="col-form-label">Chassis:&nbsp;</label></div>
                            <div class="col-4">
                                <input list="cntnr_chassis_type" name="cntnr_chassis_type" id="cntnr_chassis_type_li" class="form-control mt-1 my-text-height" value="{{$container->cntnr_chassis_type}}">
                                    <datalist id="cntnr_chassis_type">
                                        <option value="AAAA">
                                        <option value="BBBB">
                                        <option value="CCCC">
                                    </datalist>
                                </input>
                            </div>
                        </div>
                        <div class="row mx-2">
                            <div class="col-2"><label class="col-form-label">Empty Return Depot:&nbsp;</label></div>
                            <div class="col-4">
                                <input list="cntnr_empty_return_trmnl" name="cntnr_empty_return_trmnl" id="cntnr_empty_return_trmnl_li" class="form-control mt-1 my-text-height" value="{{$container->cntnr_empty_return_trmnl}}">
                                    <datalist id="cntnr_empty_return_trmnl">
                                        <option value="AAAA">
                                        <option value="BBBB">
                                        <option value="CCCC">
                                    </datalist>
                                </input>
                            </div>
                            <div class="col-2"><label class="col-form-label">MT Last Free Date:&nbsp;</label></div>
                            <div class="col-4">
                                <input class=form-control mt-1 my-text-height type=date id=cntnr_mt_lfd name=cntnr_mt_lfd value="{{$container->cntnr_mt_lfd}}">
                            </div>
                        </div>
                        <div class="row mx-2">
                            <div class="col-2"><label class="col-form-label">Seal Number:&nbsp;</label></div>
                            <div class="col-4">
                                <input class=form-control mt-1 my-text-height type=text id=cntnr_seal_no name=cntnr_seal_no value="{{$container->cntnr_seal_no}}">
                            </div>
                            <div class="col-2"><label class="col-form-label">Customer Order Number:&nbsp;</label></div>
                            <div class="col-4">
                                <input class=form-control mt-1 my-text-height type=text id=cntnr_cstm_order_no name=cntnr_cstm_order_no value="{{$container->cntnr_cstm_order_no}}">
                            </div>
                        </div>
                        <div class="row mx-2">
                            <div class="col-2"><label class="col-form-label">Booking Number:&nbsp;</label></div>
                            <div class="col-4">
                                <input class=form-control mt-1 my-text-height type=text id=cntnr_job_no name=cntnr_job_no value="{{$container->cntnr_job_no}}">
                            </div>
                            <div class="col-2"><label class="col-form-label">&nbsp;</label></div>
                            <div class="col-4"><input type="hidden" class="form-control mt-1 my-text-height" type="text"></div>
                        </div>
					    <div class="row my-3">
							<div class="w-25"></div>
							<div class="col">
								<div class="row">
									<button class="btn btn-warning mx-4" type="submit">Update</button>
                                    <?php
                                        if (!isset($_GET['prevPage'])) {
                                            $toThisLink = "<button class=\"btn btn-secondary mx-3\" type=\"button\"><a href=\"".route('booking_add', ['bookingTab'=>'containerinfo-tab', 'id'=>$booking->id])."\">Cancel</a></button>";
                                        } else {
                                            $toThisLink = "<button class=\"btn btn-secondary mx-3\" type=\"button\"><a href=\"".route($_GET['prevPage'], ['selJobId'=>$_GET['selJobId']])."\">Cancel</a></button>";
                                        }
                                        echo $toThisLink;
                                    ?>
								</div>
							</div>
							<div class="col"></div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<script>
		</script>
		
		<script>
			function myConfirmation() {
				if(!confirm("Are you sure to delete this container?"))
				event.preventDefault();
			}
		</script>
	@endsection
}
@endif

	<?php
	?>

