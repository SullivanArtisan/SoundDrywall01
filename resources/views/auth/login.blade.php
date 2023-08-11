<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
		<title>Login - TwentyTwenty Contracting Ltd.</title>
		<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
		<link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
	</head>
	<body class="bg-gradient-primary">
		@if (Route::has('login'))
			<div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
			<!-- 
				@auth
					<a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Dashboard</a>
				@else
					<a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

					@if (Route::has('register'))
						<a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
					@endif
				@endauth
			</div>
			-->
		@endif
 
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-9 col-lg-12 col-xl-10">
					<div class="card shadow-lg o-hidden border-0 my-5">
						<div class="card-body p-0">
							<div class="row">
								<div class="col-lg-6 d-none d-lg-flex">
									<div class="flex-grow-1 bg-login-image" style="background-image: url(&quot;assets/img/dogs/image3.jpeg&quot;);"></div>
								</div>
								<div class="col-lg-6">
									<div class="p-5">
										<div class="text-center">
											<h4 class="text-dark mb-4"></h4>
										</div>
										<!-- Session Status -->
										<x-auth-session-status class="mb-4" :status="session('status')" />

										<!-- Validation Errors -->
										<x-auth-validation-errors class="mb-4" :errors="$errors" />
										@if (session('usr_status_error') != '')
										<div class="alert alert-danger">
											<?php
												$text = session('usr_status_error');
												echo $text;
											?>
										</div>
										@endif

										<form method="POST" action="{{ route('login') }}">
											@csrf

											<div class="mb-3"><input class="form-control form-control-user" type="email" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address..." name="email"></div>
											<div class="mb-3"><input class="form-control form-control-user" type="password" id="exampleInputPassword" placeholder="Password" name="password"></div>
											<div class="mb-3">
												<div class="custom-control custom-checkbox small">
													<div class="form-check"><input class="form-check-input custom-control-input" type="checkbox" id="formCheck-1"><label class="form-check-label custom-control-label" for="formCheck-1">Remember Me</label></div>
												</div>
											</div><button class="btn btn-primary d-block btn-user w-100" type="submit">Login</button>
											<!-- <hr><a class="btn btn-primary d-block btn-google btn-user w-100 mb-2" role="button"><i class="fab fa-google"></i>&nbsp; Login with Google</a><a class="btn btn-primary d-block btn-facebook btn-user w-100" role="button"><i class="fab fa-facebook-f"></i>&nbsp; Login with Facebook</a> -->
											<hr>
										</form>
										@if (Route::has('password.request'))
										<div class="text-center"><a class="small" href="{{ route('password.request') }}">Forgot Password?</a></div>
										@endif

										<!--
										<div class="text-center"><a class="small" href="register.html">Create an Account!</a></div>
										-->
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script src="{{asset('/bootstrap/js/bootstrap.min.js')}}"></script>
		<script src="{{asset('/js/bs-init.js')}}"></script>
		<script src="{{asset('/js/theme.js')}}"></script>
	</body>
</html>
