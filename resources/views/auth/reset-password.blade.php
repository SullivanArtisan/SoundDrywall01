<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
		<title>Rt Password - SoundDrywall</title>
		<link rel="stylesheet" href="../../../assets/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
		<link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
	</head>
	<body class="bg-gradient-primary">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-9 col-lg-12 col-xl-10">
					<div class="card shadow-lg o-hidden border-0 my-5">
						<div class="card-body p-0">
							<div class="row">
								<div class="col-lg-6 d-none d-lg-flex">
									<div class="flex-grow-1 bg-login-image" style="background-image: url(&quot;../../../assets/img/dogs/image10.jpeg&quot;);"></div>
								</div>
								<div class="col-lg-6" style="font-family: Arial, Helvetica, sans-serif;">
									<div class="p-5">
										<x-slot name="logo">
											<a href="/">
												<x-application-logo class="w-20 h-20 fill-current text-gray-500" />
											</a>
										</x-slot>

										<!-- Validation Errors -->
										<x-auth-validation-errors class="mb-4" :errors="$errors" />

										<form method="POST" action="{{ route('password.update') }}">
											@csrf

											<!-- Password Reset Token -->
											<input type="hidden" name="token" value="{{ $request->route('token') }}">

											<!-- Email Address -->
											<div>
												<x-label for="email" :value="__('Email:')" />

												<x-input id="email" class="block mx-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus />
											</div>

											<!-- Password -->
											<div class="mt-4">
												<x-label for="password" :value="__('Password:')" />

												<x-input id="password" class="block mx-1 w-full" type="password" name="password" required />
											</div>

											<!-- Confirm Password -->
											<div class="mt-4">
												<x-label for="password_confirmation" :value="__('Confirm Password:')" />

												<x-input id="password_confirmation" class="block mx-1 w-full"
																	type="password"
																	name="password_confirmation" required />
											</div>

											<div class="flex items-center justify-end mt-5">
												<button class="btn btn-primary d-block w-100">
													{{ __('Reset Password') }}
												</button>
											</div>
										</form>
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
