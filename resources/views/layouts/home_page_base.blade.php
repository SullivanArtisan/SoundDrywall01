<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>TwentyTwenty Contracting Ltd's Control/Management System</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="css/style2.css">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
</head>

<body>
    <?php
	use App\Models\StaffAction;
    ?>

    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <!--
                <h3 style="font-family: Georgia; color:LightCyan">TwentyTwenty Contracting Ltd.</h3>
                -->
                <h6 style="font-family: Georgia; color:LightCyan"><?php echo date("m/d/Y l");?></h6>
            </div>

            <ul class="list-unstyled components">
				<div class="ml-2 mb-3">
					<a href="{{route('home_page')}}"><span style='font-size:25px;'>&#127968;</span>&nbsp&nbspHome</a>
				</div>
                <li class="active">
                    <a href="#controlSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Control</a>
                    <ul class="collapse list-unstyled" id="controlSubmenu">
                        <li> <a href="{{route('material_associate')}}">Material Association</a> </li>
                        <li> <a href="{{route('job_dispatch')}}">Job Dispatch</a> </li>
                    </ul>
                </li>
                <li>
                    <a href="#adminSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">DB Mgmnt</a>
                    <ul class="collapse list-unstyled" id="adminSubmenu">
                        <li> <a href="{{route('client_main')}}">Customers</a> </li>
                        <li> <a href="{{route('provider_main')}}">Providers</a> </li>
                        <li> <a href="{{route('staff_main')}}">Staffs</a> </li>
                        <li> <a href="{{route('material_main', ['display_filter'=>'active'])}}">Materials for Jobs</a> </li>
                        <!--					
                        <li> <a href="#materialsSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Materials for Jobs</a> </li>
							<ul class="collapse list-unstyled mx-4" id="materialsSubmenu">
                                <li><a href="{{route('under_construction')}}">Drywall Sheets</a></li>
                                <li><a href="{{route('under_construction')}}">Drywall Joint Compound</a></li>
                                <li><a href="{{route('under_construction')}}">Drywall Joint Tapes</a></li>
                                <li><a href="{{route('under_construction')}}">Drywall Joint Screws</a></li>
							</ul>	
                        <li> <a href="#toolsSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Tools</a> </li>
                            <ul class="collapse list-unstyled mx-4" id="toolsSubmenu">
                                <li><a href="#">Drywall Sanders</a></li>
                                <li><a href="#">Drywall Trowels</a></li>
                                <li><a href="#">Drywall Knives</a></li>
                                <li><a href="#">Drywall Saws</a></li>
                                <li><a href="#">Drywall Screw Guns</a></li>
                            </ul>
                        -->						
                    </ul>
                </li>
            </ul>

			<!--
            <ul class="list-unstyled CTAs">
                <li>
                    <a href="https://bootstrapious.com/tutorial/files/sidebar.zip" class="download">Download source</a>
                </li>
                <li>
                    <a href="https://bootstrapious.com/p/bootstrap-sidebar" class="article">Back to article</a>
                </li>
            </ul>
			-->
        </nav>

        <!-- Page Content  -->
        <div id="content">

            <nav class="row mb-2">
                <div class="container-fluid">

					<!--
                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                        <span>Toggle Sidebar</span>
                    </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>
					-->

                    <div class="row" id="navbarSupportedContent">
                        <div class="col-2">
							<div><img class="rounded" style="max-width:100%; height:auto" src="assets/img/2020.jpg"></div>
						</div>
						<div class="col-8 text-muted">
                            <div class="row" style="font-family: Georgia;">
                                <div class="col"><h2>TwentyTwenty Contracting Ltd.&nbsp&nbsp</h2></div>
                                <div class="col pt-2"><h6>(Ver. 0.1)</h6></div>
                            </div>
                            <div class="row mt-2">
                                <div>
                                    <button type="button" id="sidebarCollapse" class="btn" style="background-color:#7386D5; color:LightCyan">
                                        <span>Sidebar</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="my-2">
							@yield('goback')
                            </div>
							<form method="POST" action="{{ route('logout') }}" style="cursor: pointer">
								@csrf

								<a style="text-decoration:underline;"  class="text-warning"
									onclick="event.preventDefault(); this.closest('form').submit();">
									<i></i>
									{{ __('Log Out') }}
								</a>
							</form>
                        </div>
                    </div>
                </div>
            </nav>

			<div class="w-100 p-1"  style="background-color: #e8f5e9">
				@yield('function_page')
			</div>
			
			<!--
            <div class="line"></div>

            <h2>Lorem Ipsum Dolor</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

            <div class="line"></div>

            <h2>Lorem Ipsum Dolor</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

            <div class="line"></div>

            <h3>Lorem Ipsum Dolor</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
			-->
            <footer class="text-center text-lg-start fixed-bottom" style="margin-left: 150px; background-color:#7386D5;">
                <!-- Copyright -->
                <div class="text-center p-3 text-white">
                    © 2023 Copyright: TwentyTwenty Contracting Ltd.
                </div>
                <!-- Copyright -->
            </footer>        

        </div>
    </div>

    <!-- jQuery CDN - Slim version (=without AJAX) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#sidebar").mCustomScrollbar({
                theme: "minimal"
            });

            $('#sidebarCollapse').on('click', function () {
                $('#sidebar, #content').toggleClass('active');
                $('.collapse.in').toggleClass('in');
                $('a[aria-expanded=true]').attr('aria-expanded', 'false');
            });
        });
    </script>
</body>

</html>