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
	<div class="sidemenu-wrapper sidemenu-info">
		<div class="sidemenu-content"><button class="closeButton sideMenuCls"><i class="far fa-times"></i></button>
			<div class="widget">
				<div class="th-widget-about">
					<div class="about-logo"><a href="home-travel.html"><img src="/visitor/assets/img/logo2.svg" alt="Tourm" width="100"></a>
					</div>
					<p class="about-text">Rapidiously myocardinate cross-platform intellectual capital model.
						Appropriately create
						interactive infrastructures</p>
					<div class="th-social"><a href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i></a>
						<a href="https://www.twitter.com/"><i class="fab fa-twitter"></i></a> <a href="https://www.linkedin.com/"><i
								class="fab fa-linkedin-in"></i></a> <a href="https://www.whatsapp.com/"><i class="fab fa-whatsapp"></i></a>
					</div>
				</div>
			</div>
			<div class="widget">
				<h3 class="widget_title">Recent Posts</h3>
				<div class="recent-post-wrap">
					<div class="recent-post">
						<div class="media-img"><a href="blog-details.html"><img src="/visitor/assets/img/blog/recent-post-1-1.jpg"
									alt="Blog Image"></a></div>
						<div class="media-body">
							<div class="recent-post-meta"><a href="blog.html"><i class="far fa-calendar"></i>24 Jun ,
									2024</a></div>
							<h4 class="post-title"><a class="text-inherit" href="blog-details.html">Where Vision
									Meets Concrete
									Reality</a></h4>
						</div>
					</div>
					<div class="recent-post">
						<div class="media-img"><a href="blog-details.html"><img src="/visitor/assets/img/blog/recent-post-1-2.jpg"
									alt="Blog Image"></a></div>
						<div class="media-body">
							<div class="recent-post-meta"><a href="blog.html"><i class="far fa-calendar"></i>22 Jun ,
									2024</a></div>
							<h4 class="post-title"><a class="text-inherit" href="blog-details.html">Raising the Bar
									in Construction.</a>
							</h4>
						</div>
					</div>
				</div>
			</div>
			<div class="widget">
				<h3 class="widget_title">Get In Touch</h3>
				<div class="th-widget-contact">
					<div class="info-box_text">
						<div class="icon"><img src="/visitor/assets/img/icon/phone.svg" alt="img"></div>
						<div class="details">
							<p><a href="tel:+01234567890" class="info-box_link">+01 234 567 890</a></p>
							<p><a href="tel:+09876543210" class="info-box_link">+09 876 543 210</a></p>
						</div>
					</div>
					<div class="info-box_text">
						<div class="icon"><img src="/visitor/assets/img/icon/envelope.svg" alt="img"></div>
						<div class="details">
							<p><a href="mailto:mailinfo00@tourm.com" class="info-box_link">mailinfo00@tourm.com</a>
							</p>
							<p><a href="mailto:support24@tourm.com" class="info-box_link">support24@tourm.com</a></p>
						</div>
					</div>
					<div class="info-box_text">
						<div class="icon"><img src="/visitor/assets/img/icon/location-dot.svg" alt="img">
						</div>
						<div class="details">
							<p>789 Inner Lane, Holy park, California, USA</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="popup-search-box"><button class="searchClose"><i class="fal fa-times"></i></button>
		<form action="#"><input type="text" placeholder="What are you looking for?"> <button type="submit"><i
					class="fal fa-search"></i></button></form>
	</div>

	@include('visitor.partials.navbar')
	@yield('base.body')
	@include('visitor.partials.footer')
	<div class="scroll-top"><svg class="progress-circle svg-content" width="100%" height="100%"
			viewBox="-1 -1 102 102">
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
	@stack('scripts')

</body>

</html>
