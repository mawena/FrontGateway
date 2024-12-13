@extends('base')

@section('content')
	<div class="page-wrapper">
		<!-- ============================================================== -->
		<!-- Bread crumb and right sidebar toggle -->
		<!-- ============================================================== -->
		<div class="page-breadcrumb">
			<div class="row">
				<div class="col-7 align-self-center">
					<h2 class="page-title text-truncate text-dark font-weight-medium mb-1">Gestion des Configurations</h2>
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
							<div class="d-flex align-items-center mb-4">
								<h4 class="card-title">
									Liste des configurations
									<span class="text-primary px-3 ml-2 py-4 border-primary">
										[ Total : {{ count($configurations) }} ]
									</span>
								</h4>
								<div class="ml-auto">
									@can(['create'], 'configuration', session('userData'))
										<button type="button" class="btn btn-primary px-4" data-toggle="modal" data-target="#signup-modal"
											id="toggle_modal">
											Nouvelle configuration
										</button>
									@endcan
								</div>
							</div>
							<div class="table-responsive">
								<table id="zero_config" class="table table-striped table-bordered no-wrap">
									<thead>
										<tr class="text-center">
											<th>Nom</th>
											<th>Valeur</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($configurations as $configuration)
											<tr class="py-0 text-center">
												<td class="" style="width: 100px">{{ $configuration['key'] }}</td>
												<td class="py-4">{{ $configuration['value'] }}</td>
												<td class="" style="max-width: 100px">
													@can(['edit'], 'configuration', session('userData'))
														<a href="{{ route('admin.configuration.edit', $configuration['id']) }}" type="button"
															class="btn text-warning"><i class="fa fa-edit"></i></a>
													@endcan
													@can(['delete'], 'configuration', session('userData'))
														<form action="{{ route('admin.configuration.destroy', $configuration['id']) }}" method="POST"
															style="display:inline-block;">
															@csrf
															@method('DELETE')
															<button type="submit" class="btn"
																onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet configuration ?')">
																<i style="color: red" class="fa fa-trash"></i>
															</button>
														</form>
													@endcan
													</form>
												</td>
											</tr>
										@endforeach
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div id="signup-modal" class="modal fade show" tabindex="-1" role="dialog" aria-hidden="false">
				<div class="modal-dialog">
					<div class="modal-content p-2 rounded-app">
						<div class="modal-body">
							<div class="text-center mt-2 mb-4">
								<a href="{{ route('admin.configuration.index') }}" class="text-success">
									<span><img class="mr-2" src="/assets/images/logo-icon.png" alt="" height="18"><img
											src="/assets/images/logo-text.png" alt="" height="18"></span>
								</a>
							</div>

							<form class="pl-3 pr-3" action="/admin/configuration" method="POST" enctype="multipart/form-data">
								@csrf

								<div class="form-group">
									<label for="key">Nom</label>
									<input class="form-control" name="key" id="key" required="" placeholder="" value="">
									@error('key')
										<span class="text-danger">{{ $message }}</span>
									@enderror
								</div>
								<div class="form-group">
									<label for="value">Valeur</label>
									<input class="form-control" name="value" id="value" required="" placeholder="" value="">
									@error('value')
										<span class="text-danger">{{ $message }}</span>
									@enderror
								</div>

								<div class="form-group text-center mt-4">
									<button class="btn btn-primary w-100" type="submit">Créer</button>
								</div>

							</form>

						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->
		</div>
	</div>
	<script>
		// document.addEventListener("DOMContentLoaded", function () {
		//     var myModal = new bootstrap.Modal(document.getElementById('signup-modal'));
		//     myModal.show();
		// });

		document.addEventListener('DOMContentLoaded', function() {
			if ({{ $errors->any() ? 'true' : 'false' }}) {
				$('#signup-modal').modal('show');
			}
		});
	</script>
@endsection
