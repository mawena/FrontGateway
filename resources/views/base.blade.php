<!DOCTYPE html>
<html dir="ltr" lang="fr">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<!-- Favicon icon -->
	<link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon.png">
	<title>Pecorator</title>
	<!-- This page plugin CSS -->
	<link href="{{ asset('/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
	<!-- Custom CSS -->
	<link href="/dist/css/style.min.css" rel="stylesheet">
	<link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
</head>

<body>
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
	<!-- Main wrapper - style you can find in pages.scss -->
	<!-- ============================================================== -->
	<div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
		data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
		<!-- ============================================================== -->
		<!-- Topbar header - style you can find in pages.scss -->
		<!-- ============================================================== -->
		<header class="topbar" data-navbarbg="skin6">
			<nav class="navbar top-navbar navbar-expand-md">
				<div class="navbar-header" data-logobg="skin6">
					<!-- This is for the sidebar toggle which is visible on mobile only -->
					<a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
							class="ti-menu ti-close"></i></a>
					<!-- ============================================================== -->
					<!-- Logo -->
					<!-- ============================================================== -->
					<div class="navbar-brand">
						<!-- Logo icon -->
						<a href="/admin">
							<b class="logo-icon">
								<!-- Dark Logo icon -->
								<img src="/assets/images/logo-icon.png" alt="homepage" class="dark-logo" width="100" />
								<!-- Light Logo icon -->
								<img src="/assets/images/logo-icon.png" alt="homepage" class="light-logo" width="100" />
							</b>
						</a>
					</div>
				</div>
				<!-- ============================================================== -->
				<!-- End Logo -->
				<!-- ============================================================== -->
				<div class="navbar-collapse collapse" id="navbarSupportedContent">
					<!-- ============================================================== -->
					<!-- toggle and nav items -->
					<!-- ============================================================== -->
					<ul class="navbar-nav float-left mr-auto ml-3 pl-1">
						<!-- ============================================================== -->
						<!-- create new -->
						<!-- ============================================================== -->
					</ul>
					<!-- ============================================================== -->
					<!-- Right side toggle and nav items -->
					<!-- ============================================================== -->
					<ul class="navbar-nav float-right">
						<!-- ============================================================== -->
						<!-- User profile and search -->
						<!-- ============================================================== -->
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown" aria-haspopup="true"
								aria-expanded="false">
								<img src="/storage/{{ session('userData')['picture_path'] }}" alt="user" class="rounded-circle"
									width="40">
								<span class="ml-2 d-none d-lg-inline-block"><span>Bonjour,</span> <span
										class="text-dark">{{ session('userData')['name'] }}</span> <i data-feather="chevron-down"
										class="svg-icon"></i></span>
							</a>
							<div class="dropdown-menu dropdown-menu-right user-dd animated flipInY p-0">
								<form action="{{ route('admin.logout') }}" method="POST" class="p-0 w-100" style="display:inline-block;">
									@csrf
									@method('DELETE')
									<button type="submit" class="dropdown-item text-danger m-0 w-100">
										<i data-feather="power" class="svg-icon mr-2 ml-1"></i>
										Deconnexion
									</button>
								</form>
							</div>
						</li>
						<!-- ============================================================== -->
						<!-- User profile and search -->
						<!-- ============================================================== -->
					</ul>
				</div>
			</nav>
		</header>
		<!-- ============================================================== -->
		<!-- End Topbar header -->
		<!-- ============================================================== -->
		<!-- ============================================================== -->
		<!-- Left Sidebar - style you can find in sidebar.scss  -->
		<!-- ============================================================== -->
		<aside class="left-sidebar" data-sidebarbg="skin6">
			<!-- Sidebar scroll-->
			<div class="scroll-sidebar" data-sidebarbg="skin6">
				<!-- Sidebar navigation-->
				<nav class="sidebar-nav">
					<ul id="sidebarnav">
						@can(['read'], 'configuration', session('userData'))
							<li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="/admin/configuration"
									aria-expanded="false"><i data-feather="settings" class="feather-icon"></i><span
										class="hide-menu">Configurations</span></a></li>
						@endcan
						@can(['read'], 'payment', session('userData'))
							<li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="/admin/payment" aria-expanded="false"><i
										data-feather="dollar-sign" class="feather-icon"></i><span class="hide-menu">Achats</span></a></li>
						@endcan
						@can(['read'], 'supervisor', session('userData'))
							<li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="/admin/user" aria-expanded="false"><i
										data-feather="users" class="feather-icon"></i><span class="hide-menu">BackOfficiers</span></a></li>
						@endcan
						@can(['read'], 'promoter', session('userData'))
							<li class="sidebar-item">
								<a class="sidebar-link sidebar-link" href="/admin/promoter" aria-expanded="false"><i data-feather="users"
										class="feather-icon"></i><span class="hide-menu">Promoteurs</span></a>
							</li>
						@endcan
						@can(['read'], 'event', session('userData'))
							<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-19468"></li>
							<li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false"><i
										data-feather="calendar" class="feather-icon"></i><span class="hide-menu">Evenements</span></a>
								<ul aria-expanded="false" class="collapse  first-level base-level-line">
									<li class="sidebar-item"><a href="/admin/event?validation=pending" class="sidebar-link"><span
												class="hide-menu"> En attente
											</span></a>
									</li>
									<li class="sidebar-item"><a href="/admin/event?validation=validated" class="sidebar-link"><span
												class="hide-menu">Validés
											</span></a>
									</li>
									<li class="sidebar-item"><a href="/admin/event?validation=rejected" class="sidebar-link"><span
												class="hide-menu">Rejetés
											</span></a>
									</li>
								</ul>
							</li>
						@endcan
						@can(['read'], 'decor', session('userData'))
							<li class="sidebar-item">
								<a class="sidebar-link sidebar-link" href="/admin/decor" aria-expanded="false"><i data-feather="image"
										class="feather-icon"></i><span class="hide-menu">Décors</span></a>
							</li>
						@endcan
					</ul>
				</nav>
				<!-- End Sidebar navigation -->
			</div>
			<!-- End Sidebar scroll-->
		</aside>
		<!-- ============================================================== -->
		<!-- End Left Sidebar - style you can find in sidebar.scss  -->
		<!-- ============================================================== -->
		<!-- ============================================================== -->
		<!-- Page wrapper  -->
		<!-- ============================================================== -->
		@yield('content')
		<!-- ============================================================== -->
		<!-- End Page wrapper  -->
		<!-- ============================================================== -->
	</div>
	<!-- ============================================================== -->
	<!-- End Wrapper -->
	<!-- ============================================================== -->
	<!-- End Wrapper -->
	<!-- ============================================================== -->
	<!-- All Jquery -->
	<!-- ============================================================== -->
	<script src="{{ asset('/assets/libs/jquery/dist/jquery.min.js') }}"></script>
	<!-- Bootstrap tether Core JavaScript -->
	<script src="{{ asset('/assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
	<script src="{{ asset('/assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
	<!-- apps -->
	<!-- apps -->
	<script src="{{ asset('/dist/js/app-style-switcher.js') }}"></script>
	<script src="{{ asset('/dist/js/feather.min.js') }}"></script>
	<!-- slimscrollbar scrollbar JavaScript -->
	<script src="{{ asset('/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
	<script src="{{ asset('/assets/extra-libs/sparkline/sparkline.js') }}"></script>
	<!--Wave Effects -->
	<!-- themejs -->
	<!--Menu sidebar -->
	<script src="{{ asset('/dist/js/sidebarmenu.js') }}"></script>
	<!--Custom JavaScript -->
	<script src="{{ asset('/dist/js/custom.min.js') }}"></script>
	<!--This page plugins -->
	<script src="{{ asset('/assets/extra-libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('/dist/js/pages/datatable/datatable-basic.init.js') }}"></script>
</body>

</html>
