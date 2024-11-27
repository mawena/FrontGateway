@extends('base')

@section('content')
	<div class="page-wrapper">
		<!-- ============================================================== -->
		<!-- Bread crumb and right sidebar toggle -->
		<!-- ============================================================== -->
		<div class="page-breadcrumb">
			<div class="row">
				<div class="col-7 align-self-center">
					<h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Modification d'utilisateur</h4>
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
									<a href="index.html" class="text-success">
										<span><img class="mr-2" src="/assets/images/logo-icon.png" alt="" height="18"><img
												src="/assets/images/logo-text.png" alt="" height="18"></span>
									</a>
								</div>

								<form class="pl-3 pr-3" action="{{route('admin.promoter.update', $promoter['id'])}}" method="POST">
									@csrf
									@method("PUT")
									<div class="form-group">
										<label for="name">Nom</label>
										<input class="form-control" name="name" id="name" required="" placeholder=""
											value="{{ $promoter['name'] }}">
										@error('name')
											<span class="text-danger">{{ $message }}</span>
										@enderror
									</div>

									<div class="form-group">
										<label for="email">Email</label>
										<input class="form-control" type="email" name="email" id="email" required="" placeholder=""
											value="{{ $promoter['email'] }}">
										@error('email')
											<span class="text-danger">{{ $message }}</span>
										@enderror
									</div>

									<div class="form-group">
										<label for="password">Mot de passe</label>
										<input class="form-control" name="password" type="password" id="password" placeholder=""
											value="">
										@error('password')
											<span class="text-danger">{{ $message }}</span>
										@enderror
									</div>

									<div class="form-group">
										<label for="structure">Structure</label>
										<input class="form-control" name="promoter.structure" type="text" required="" id="structure"
											placeholder="" value="{{ $promoter['promoter']['structure'] }}">
										@error('promoter.structure')
											<span class="text-danger">{{ $message }}</span>
										@enderror
									</div>

									<div class="form-group">
										<label for="phone_number">Téléphone</label>
										<input class="form-control" name="promoter.phone_number" type="text" required="" id="phone_number"
											placeholder="" value="{{ $promoter['promoter']['phone_number'] }}">
										@error('promoter.phone_number')
											<span class="text-danger">{{ $message }}</span>
										@enderror
									</div>

									<div class="form-group">
										<label for="birth_date">Date de naissance</label>
										<input class="form-control" name="promoter.birth_date" type="date" required="" id="birth_date"
											placeholder="" value="{{ $promoter['promoter']['birth_date'] }}">
										@error('promoter.birth_date')
											<span class="text-danger">{{ $message }}</span>
										@enderror
									</div>

									<div class="form-group">
										<label for="sex">Sexe</label>
										<select class="form-control" id="sex" name="promoter.sex" required="">
											<option value="M" selected>Home</option>
											<option value="F"> Femme</option>
										</select>
										@error('promoter.sex')
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

									<input type="hidden" value="promoter" name="profile">

									<div class="form-group text-right">
										<button class="btn btn-primary" type="submit">Modifier</button>
									</div>

								</form>

							</div>
						</div>
					</div>
				</div>
			</div>
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
