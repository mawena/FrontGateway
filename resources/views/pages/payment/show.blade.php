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
						Détails de l'achat</h2>
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
						<div class="card-body pb-0">
							<div class="modal-body">
								<div class="pl-3 pr-3">
									<div class="row">
										<div class="col-md-12">
											<div class="row">
												<div class="col-lg-4 col-md-12">
													<div class="form-group">
														<label for="user_id">Initiateur</label>
														<p class="py-1 text-bold text-dark" id="user_id">{{ $payment['user']['name'] }}</p>
													</div>
												</div>
												<div class="col-lg-4 col-md-12">
													<div class="form-group">
														<label for="nb_uses">Quantité acheté</label>
														<p class="py-1 text-bold text-dark" id="nb_uses">{{ $payment['nb_uses'] }}</p>
													</div>
												</div>
												<div class="col-lg-4 col-md-12">
													<div class="form-group">
														<label for="amount">Montant total</label>
														<p class="py-1 text-bold text-dark" id="amount">
															{{ $payment['amount'] }}</p>
													</div>
												</div>
												<div class="col-lg-4 col-md-12">
													<div class="form-group">
														<label for="activated">Statut</label>
														<p>{{ $payment['status'] }}</p>
													</div>
												</div>
												<div class="col-lg-4 col-md-12">
													<div class="form-group">
														<label for="email">Date de création</label>
														<p class="py-1 text-bold text-dark">{{ $payment['created_at_fr'] }}
														</p>
													</div>
												</div>
												<div class="col-lg-4 col-md-12">
													<div class="form-group">
														<label for="email">Dernière modification</label>
														<p class="py-1 text-bold text-dark">
															{{ $payment['updated_at_fr'] }}</p>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group text-right mt-4">
										<a href="{{ route('admin.payment.index') }}" class="btn btn-secondary px-5" type="submit">Retour</a>
									</div>
								</div>
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
