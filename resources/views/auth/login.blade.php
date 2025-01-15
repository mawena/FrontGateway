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
				<div class="col-lg-12 mx-auto py-2 rounded-app col-md-12 bg-white" style="max-width: 500px">
					<div class="form-group text-lefth mt-4">
						<a href="{{ route('visitor.index') }}" class="btn btn-secondary px-5" type="submit"><- Acceuil</a>
					</div>
					<div class="p-3">
						<div class="text-center">
							<img src="{{ asset('assets/images/logo-icon.png') }}" alt="wrapkit" width="100">
						</div>
						<h2 class="mt-3 text-center text-dark">Connexion</h2>
						<p class="text-center py-2">Entrez vôtre email et vôtre mot de passe pour vous connecter.</p>
						<form class="mt-4" action="/admin/login" method="POST">
							@csrf
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label class="text-dark" for="email">Email</label>
										<input class="form-control" name="email" id="email" type="email"
											placeholder="Entrez vôtre mail" value="">
											@error('email')
												<span class="text-danger">{{ $message }}</span>
											@enderror
									</div>
								</div>
								<div class="col-lg-12">
									<div class="form-group">
										<label class="text-dark" for="password">Mot de passe</label>
										<input class="form-control" name="password" id="password" type="password"
											placeholder="Entrez vôtre mot de passe" value="">
											@error('password')
													<span class="text-danger">{{ $message }}</span>
											@enderror
									</div>
								</div>
								<div class="col-lg-12 mt-4 text-center">
									<button type="submit" class="btn btn-block btn-dark">Se connecter</button>
								</div>
								<div class="col-lg-12 mt-4 text-center">
									<p>Pas de compte?. <a href="{{route('admin.register')}}">Inscrivez-vous</a></p>
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