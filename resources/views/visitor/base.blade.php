<!doctype html>
<html class="no-js" lang="zxx">

<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>{{ config('app.name') }}</title>
	<meta name="author" content="Tourm">
	<meta name="description" content="{{ config('app.name') }}">
	<meta name="keywords" content="{{ config('app.name') }}">
	<meta name="robots" content="INDEX,FOLLOW">
	<meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="{{ asset('/visitor/assets/img/favicons/ms-icon-144x144.png') }}">
	<meta name="theme-color" content="#ffffff">
	<link rel="preconnect" href="{{ asset('visitor/fonts.googleapis.com/index.html') }}">
	<link rel="preconnect" href="{{ asset('visitor/fonts.gstatic.com/index.html') }}" crossorigin>
	<link rel="preconnect" href="{{ asset('visitor/fonts.googleapis.com/index.html') }}">
	<link rel="preconnect" href="{{ asset('visitor/fonts.gstatic.com/index.html') }}" crossorigin>
	<link
		href="/fonts.googleapis.com/css2ee07.css?family=Inter:wght@100..900&amp;family=Manrope:wght@200..800&amp;family=Montez&amp;display=swap"
		rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('/visitor/assets/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/visitor/assets/css/fontawesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/visitor/assets/css/magnific-popup.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/visitor/assets/css/swiper-bundle.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/visitor/assets/css/style.css') }}">
	@yield('decor.use.head')

</head>

<body>
	<div class="magic-cursor relative z-10">
		<div class="cursor"></div>
		<div class="cursor-follower"></div>
	</div>
	{{-- <div id="preloader" class="preloader text-center"><button class="th-btn preloaderCls">Encours de chargement</button>
		<div class="preloader-inner"><img src="{{ asset('/visitor/assets/img/logo3.svg') }}" alt="" width="100"></div>
		<div id="loader" class="th-preloader">
			<div class="animation-preloader">
				<div class="txt-loading"><span preloader-text="T" class="characters">T </span><span preloader-text="O"
						class="characters">O </span><span preloader-text="U" class="characters">U </span><span preloader-text="R"
						class="characters">R </span><span preloader-text="M" class="characters">M</span></div>
			</div>
		</div>
	</div> --}}

	@include('visitor.partials.navbar')
	@yield('base.body')
	@include('visitor.partials.footer')
	<div class="scroll-top"><svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
			<path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"
				style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 307.919;">
			</path>
		</svg></div>
	@include('visitor.form.login')
	<script src="{{ asset('/visitor/assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
	<script src="{{ asset('/visitor/assets/js/swiper-bundle.min.js') }}"></script>
	<script src="{{ asset('/visitor/assets/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('/visitor/assets/js/jquery.magnific-popup.min.js') }}"></script>
	<script src="{{ asset('/visitor/assets/js/jquery.counterup.min.js') }}"></script>
	<script src="{{ asset('/visitor/assets/js/jquery-ui.min.js') }}"></script>
	<script src="{{ asset('/visitor/assets/js/imagesloaded.pkgd.min.js') }}"></script>
	<script src="{{ asset('/visitor/assets/js/isotope.pkgd.min.js') }}"></script>
	<script src="{{ asset('/visitor/assets/js/gsap.min.js') }}"></script>
	<script src="{{ asset('/visitor/assets/js/circle-progress.js') }}"></script>
	<script src="{{ asset('/visitor/assets/js/matter.min.js') }}"></script>
	<script src="{{ asset('/visitor/assets/js/matterjs-custom.js') }}"></script>
	<script src="{{ asset('/visitor/assets/js/nice-select.min.js') }}"></script>
	<script src="{{ asset('/visitor/assets/js/main.js') }}"></script>
	<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
	<script>
		document.addEventListener("contextmenu", function(event) {
			event.preventDefault();
		});
	</script>
	@stack('scripts')

</body>

</html>
