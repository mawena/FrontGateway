@extends('base')

@section('content')
<div class="page-wrapper">
	<!-- ============================================================== -->
	<!-- Bread crumb and right sidebar toggle -->
	<!-- ============================================================== -->
	<div class="page-breadcrumb">
		<div class="row">
			<div class="col-7 align-self-center">
				<h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Gestion des Utilisateurs</h4>
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
						<div class="d-flex justify-content-end mb-3">
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#signup-modal" id="toggle_modal">Créer</button>
						</div>
						<h4 class="card-title">Liste des utilisateurs</h4>
						<div class="table-responsive">
							<table id="zero_config" class="table table-striped table-bordered no-wrap">
								<thead>
									<tr>
										<th>Nom</th>
										<th>Email</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
									@foreach($users as $user)
										<tr>
											<td>{{ $user["name"] }}</td>
											<td>{{ $user["email"] }}</td>
											<td>
												<button type="button" class="btn"><i class="fa fa-eye"></i></button>
												<button type="button" class="btn"><i class="fa fa-edit"></i></button>
												<form action="{{ route('admin.user.destroy', $user['id']) }}" method="POST"
													style="display:inline-block;">
													@csrf
													@method('DELETE')
													<button type="submit" class="btn"
														onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette offre ?')">
														<i style="color: red" class="fa fa-trash"></i>
													</button>
												</form>
												<a href="{{ route('admin.user.destroy', $user['id']) }}" class="btn">
												</a>
											</td>
										</tr>
									@endforeach
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div id="signup-modal" class="modal fade show" tabindex="-1" role="dialog"
		aria-hidden="false">
		<div class="modal-dialog">
			<div class="modal-content">

				<div class="modal-body">
					<div class="text-center mt-2 mb-4">
						<a href="index.html" class="text-success">
							<span><img class="mr-2" src="/assets/images/logo-icon.png"
									alt="" height="18"><img
									src="/assets/images/logo-text.png" alt=""
									height="18"></span>
						</a>
					</div>

					<form class="pl-3 pr-3" action="/admin/user" method="POST">
						@csrf
						<div class="form-group">
							<label for="name">Nom</label>
							<input class="form-control" name="name" id="name" required="" placeholder="" value="Test01">
							@error('name')
								<span class="text-danger">{{ $message }}</span>
							@enderror
						</div>

						<div class="form-group">
							<label for="email">Email</label>
							<input class="form-control" type="email" name="email" id="email" required="" placeholder="" value="Test01@gmail.com">
							@error('email')
								<span class="text-danger">{{ $message }}</span>
							@enderror
						</div>

						<div class="form-group">
							<label for="password">Mot de passe</label>
							<input class="form-control" name="password" type="password" required="" id="password" placeholder="" value="azertyazerty">
							@error('password')
								<span class="text-danger">{{ $message }}</span>
							@enderror
						</div>

						<div class="form-group">
							<label for="activated">Statut</label>
							<select class="form-control" id="activated" name="activated" required="">
								<option value="1" selected>Actif</option>
								<option value="0">Inactif</option>
							</select>
							@error('activated')
								<span class="text-danger">{{ $message }}</span>
							@enderror
						</div>

						<input type="hidden" value="supervisor" name="profile">

						<div class="form-group text-center">
							<button class="btn btn-primary" type="submit">Créersss</button>
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

	document.addEventListener('DOMContentLoaded', function () {
        if ({{ $errors->any() ? 'true' : 'false' }}) {
            $('#signup-modal').modal('show');
        }
    });
</script>
@endsection