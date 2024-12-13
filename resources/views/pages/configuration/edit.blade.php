@extends('base')

@section('content')
	<div class="page-wrapper">
		<!-- ============================================================== -->
		<!-- Bread crumb and right sidebar toggle -->
		<!-- ============================================================== -->
		<div class="page-breadcrumb">
			<div class="row">
				<div class="col-7 align-self-center">
					<h2 class="page-title text-truncate text-dark font-weight-medium mb-1">
						Modification de la configuration / {{ $configuration['key'] }}
					</h2>
				</div>

			</div>
		</div>
		<!-- ============================================================== -->
		<!-- End Bread crumb and right sidebar toggle -->
		<!-- ============================================================== -->
		<!-- ============================================================== -->
		<!-- Container fluid  -->
		<!-- ============================================================== -->
		<div class="container-fluid">
			<!-- ============================================================== -->
			<!-- Start Page Content -->
			<!-- ============================================================== -->
			<!-- basic table -->
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<div class="modal-body">
								<div class="text-center mt-2 mb-4">
									<a href="{{ route('admin.configuration.index') }}" class="text-success">
										<span><img class="mr-2" src="/assets/images/logo-icon.png" alt="" height="18"><img
												src="/assets/images/logo-text.png" alt="" height="18"></span>
									</a>
								</div>

								<form class="pl-3 pr-3" action="{{ route('admin.configuration.update', $configuration['id']) }}" method="POST"
									enctype="multipart/form-data">
									@csrf
									@method('PUT')
									<div class="row">
										<div class="col-lg-1 col-md-12"></div>
										<div class="col-lg-10 col-md-12">
											<div class="form-group">
												<label for="value">Valeur</label>
												<input class="form-control" type="text" name="value" id="value" placeholder=""
													value="{{ $configuration['value'] }}">
												@error('value')
													<span class="text-danger">{{ $message }}</span>
												@enderror
											</div>
										</div>
										<div class="col-lg-1 col-md-12"></div>
									</div>

									<div class="form-group text-right">
										<button class="btn btn-warning px-5" type="submit">Modifier</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
