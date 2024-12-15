<!DOCTYPE html>
<html dir="ltr">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<!-- Favicon icon -->
	<link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon.png">
	<title>{{ config('app.name') }}</title>
	<!-- Custom CSS -->
	<link href="{{ asset('dist/css/style.min.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
	<div class="main-wrapper">
		<!-- ============================================================== -->
		<!-- Preloader - style you can find in spinners.css -->
		<!-- ============================================================== -->
		<div class="preloader">
			<div class="lds-ripple">
				<div class="lds-pos"></div>
				<div class="lds-pos"></div>
			</div>
		</div>
		<!-- ============================================================== -->
		<!-- Preloader - style you can find in spinners.css -->
		<!-- ============================================================== -->
		<!-- ============================================================== -->
		<!-- Login box.scss -->
		<!-- ============================================================== -->
		
		<div class="auth-wrapper d-flex no-block justify-content-center align-items-center position-relative"
		style="background:url(/assets/images/big/auth-bg.jpg) no-repeat center center; background-size: cover">
		<div class="auth-box shadow-none">
			<div class="col-lg-12 mx-auto py-2 rounded-app col-md-12 bg-white" style="width: 100%">
				<div class="form-group text-lefth mt-4">
					<a href="{{ route('visitor.index') }}" class="btn btn-secondary px-5" type="submit"><- Acceuil</a>
				</div>
				<div class="p-3">
					<div class="text-center">
						<img src="{{ asset('assets/images/logo-icon.png') }}" alt="wrapkit">
					</div>
						<h2 class="mt-3 text-center text-dark">Inscription</h2>
						<p class="text-center py-2">Veuillez remplir les champs suivants.</p>
						<form class="mt-4" action="{{ route('admin.post.register') }}" method="POST">
							@csrf
							<div class="row">
								<div class="col-12 col-lg-6">
									<div class="form-group">
										<label for="name">Nom</label>
										<input class="form-control" name="name" id="name" required="" placeholder="" value="">
										@error('name')
											<span class="text-danger">{{ $message }}</span>
										@enderror
									</div>
								</div>

								<div class="col-12 col-lg-6">
									<div class="form-group">
										<label for="email">Email</label>
										<input class="form-control" type="email" name="email" id="email" required="" placeholder=""
											value="">
										@error('email')
											<span class="text-danger">{{ $message }}</span>
										@enderror
									</div>
								</div>

								<div class="col-12 col-lg-6">
									<div class="form-group">
										<label for="structure">Structure</label>
										<input class="form-control" name="structure" type="text" required="" id="structure"
											placeholder="" value="">
										@error('structure')
											<span class="text-danger">{{ $message }}</span>
										@enderror
									</div>
								</div>

								<div class="col-12 col-lg-6">
									<div class="form-group">
										<label for="phone_number">Téléphone</label>
										<input class="form-control" name="phone_number" type="text" required="" id="phone_number"
											placeholder="" value="">
										@error('phone_number')
											<span class="text-danger">{{ $message }}</span>
										@enderror
									</div>
								</div>

								<div class="col-12 col-lg-6">
									<div class="form-group">
										<label for="birth_date">Date de naissance</label>
										<input class="form-control" name="birth_date" type="date" required="" id="birth_date"
											placeholder="" value="">
										@error('birth_date')
											<span class="text-danger">{{ $message }}</span>
										@enderror
									</div>
								</div>

								<div class="col-12 col-lg-6">
									<div class="form-group">
										<label for="sex">Sexe</label>
										<select class="form-control" id="sex" name="sex" required="">
											<option value="M" selected>Homme</option>
											<option value="F">Femme</option>
										</select>
										@error('sex')
											<span class="text-danger">{{ $message }}</span>
										@enderror
									</div>
								</div>

								<div class="col-lg-12">
									<div class="form-group">
										<label for="password">Mot de passe</label>
										<input class="form-control" name="password" type="password" required="" id="password" placeholder=""
											value="">
										@error('password')
											<span class="text-danger">{{ $message }}</span>
										@enderror
									</div>
								</div>

								<div class="col-lg-12 mt-4 text-center">
									<button type="submit" class="btn btn-block btn-dark">Inscription</button>
								</div>
								<div class="col-lg-12 mt-4 text-center">
									<p>Déjà inscrit?. <a href="{{ route('admin.login') }}">Connectez-vous</a></p>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- ============================================================== -->
		<!-- Login box.scss -->
		<!-- ============================================================== -->
	</div>
	<!-- ============================================================== -->
	<!-- All Required js -->
	<!-- ============================================================== -->
	<script src="/assets/libs/jquery/dist/jquery.min.js "></script>
	<!-- Bootstrap tether Core JavaScript -->
	<script src="/assets/libs/popper.js/dist/umd/popper.min.js "></script>
	<script src="/assets/libs/bootstrap/dist/js/bootstrap.min.js "></script>
	<!-- ============================================================== -->
	<!-- This page plugin js -->
	<!-- ============================================================== -->
	<script>
		$(".preloader ").fadeOut();
	</script>
</body>

</html>
