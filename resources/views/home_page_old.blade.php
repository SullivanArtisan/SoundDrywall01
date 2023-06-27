<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Sound Drywall</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Hero-Clean-images.css">
</head>

<body>
    <div class="container py-4 py-xl-5" style="background: linear-gradient(#70c950, white), var(--bs-teal);">
        <div class="row gy-4 gy-md-0" style="height: 250px;">
            <div class="col-md-6" style="height: 250px;">
                <div style="height: 250px;"><img class="rounded img-fluid w-100 fit-cover" style="max-height: 100%;max-width: 100%;" src="assets/img/SoundDrywall.jpg"></div>
            </div>
            <div class="col-md-6 d-md-flex align-items-md-center" style="height: 250px;">
                <div style="max-width: 350px;margin-left: 65px;height: 250px;">
                    <h2 class="text-uppercase fw-bold" style="width: 355px;height: 40.172px;margin-bottom: 0px;">Harbourlink</h2>
                    <h2 class="text-uppercase fw-bold" style="width: 355px;height: 40px;margin-bottom: 0;">COntrol &amp;</h2>
                    <h2 class="text-uppercase fw-bold" style="width: 355px;height: 40px;margin-bottom: 0;">management</h2>
                    <h2 class="text-uppercase fw-bold" style="width: 355px;height: 40px;margin-bottom: 0;">system</h2>
					<div class="row" style="margin-top:50px; margin-left:200px">
						<form method="POST" action="{{ route('logout') }}" style="cursor: pointer">
							@csrf

							<a style="margin-right: 10px; text-decoration:underline;"  class="text-warning"
								onclick="event.preventDefault(); this.closest('form').submit();">
								<i></i>
								{{ __('Log Out') }}
							</a>
						</form>
					</div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <header style="height: 22px;background: var(--bs-blue);"></header>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Control</h4>
                        <p class="card-text">The functions in this group are good for H/L control options</p><a class="card-link" href="#" style="margin: 0px;margin-right: 20px;">Active Jobs</a><a class="card-link" href="#" style="margin-right: 20px;">Enter New Job</a><a class="card-link" href="#" style="margin-right: 20px;">Display Map</a><a class="card-link" href="#" style="margin-right: 20px;">Display Chassis Locations</a><a class="card-link" href="#" style="margin-right: 20px;">View Last Job</a><a class="card-link" href="#" style="margin-right: 20px;">View By Job Number</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <header style="height: 22px;background: var(--bs-blue);"></header>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Administration</h4>
                        <p class="card-text">The functions in this group are good for an Administrator's options</p>
                        <div class="row">
                            <div class="col">
								<a href="#" style="margin-right: 36px;">Customer File</a><a href="#" style="margin-right: 36px;">Driver File</a><a href="#" style="margin-right: 36px;">Invoicing</a><a href="#" style="margin-right: 36px;">Driver Pay</a><a href="#" style="margin-right: 36px;">Steamship Line DB</a><a href="#" style="margin-right: 36px;">Address DB</a>
								<a href="{{route('system_user_main_old')}}" style="margin-right: 36px;">System Users</a>
							</div>
                        </div>
                        <div class="row">
                            <div class="col"><a href="#" style="margin-right: 36px;">Zones</a><a href="#" style="margin-right: 36px;">Power Units</a><a href="#" style="margin-right: 36px;">Accessorial Charges</a><a href="#" style="margin-right: 36px;">Chassis List</a><a href="#" style="margin-right: 36px;">Reports</a><a href="#" style="margin-right: 36px;">Security Levels</a><a href="#" style="margin-right: 36px;">System Settings</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <header style="height: 22px;background: var(--bs-blue);"></header>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">TCEF</h4>
                        <p class="card-text">The functions in this group are good for TCEF options</p><a class="card-link" href="#" style="margin-right: 36px;margin-left: 0px;">Enter CBSA Job</a><a class="card-link" href="#" style="margin-right: 36px;margin-left: 0px;">View CBSA Jobs</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <header style="height: 22px;background: var(--bs-blue);"></header>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Sales Ledger</h4>
                        <p class="card-text">Nullam id dolor id nibh ultricies vehicula ut id elit. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus.</p><a class="card-link" href="#" style="margin-right: 36px;">View Sales Ledger</a><a class="card-link" href="#" style="margin-right: 36px;">Import Payments File</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>