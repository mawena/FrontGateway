@extends('base')

@section('content')
	<div class="page-wrapper">
		<!-- ============================================================== -->
		<!-- Bread crumb and right sidebar toggle -->
		<!-- ============================================================== -->
		<div class="page-breadcrumb">
			<div class="row">
				<div class="col-7 align-self-center">
					<h2 class="page-title text-truncate text-dark font-weight-medium mb-1">Gestion des Achat d'utilisations de décors
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
							<div class="d-flex align-items-center mb-4">
								<h4 class="card-title">
									<p>
										Liste des achats
										<span class="text-primary px-3 ml-2 py-4 border-primary">
											[ Total : {{ count($payments) }} ]
										</span>
									</p>
									<p>
										Utilisation de décors
										<span class="text-primary px-3 ml-2 py-4 border-primary">
											[ Total : {{ $user['nb_decor_payed'] }}, Utilisés : {{ $user['nb_decor_used'] }}, Restant :
											{{ $user['nb_decor_not_used'] }} ]
										</span>
									</p>
								</h4>
								<br>
								<div class="ml-auto">
									@can(['create'], 'payment', session('userData'))
										<button type="button" class="btn btn-primary px-4" data-toggle="modal" data-target="#signup-modal"
											id="toggle_modal">
											Nouvel achat
										</button>
									@endcan
								</div>
							</div>
							<div class="table-responsive">
								<table id="zero_config" class="table table-striped table-bordered no-wrap">
									<thead>
										<tr class="text-center">
											<th>Date</th>
											<th>Nombre</th>
											<th>Montant</th>
											<th>Statut</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($payments as $payment)
											<tr class="py-0 text-center">
												<td>{{ $payment['created_at_fr'] }}</td>
												<td>{{ $payment['nb_uses'] }}</td>
												<td>{{ $payment['amount'] }}</td>
												<td>{{ $payment['status_fr'] }}</td>
												<td class="" style="max-width: 100px">
													@can(['read'], 'payment', session('userData'))
														<a href="{{ route('admin.payment.show', $payment['id']) }}" class="btn text-primary"><i
																class="fa fa-eye"></i></a>
													@endcan
													@if (!in_array($payment['status'], ['validated', 'rejected']) && $payment['user_id'] == session('userData')['id'])
														<a href="{{ $payment['payment_url'] }}" class="btn text-primary"><i class="fa fa-credit-card"></i></a>
													@endif
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
								<a href="{{ route('admin.payment.index') }}" class="text-success">
									<span><img class="mr-2" src="/assets/images/logo-icon.png" alt="" height="18"><img
											src="/assets/images/logo-text.png" alt="" height="18"></span>
								</a>
							</div>

							<form class="pl-3 pr-3" action="/admin/payment" method="POST" enctype="multipart/form-data">
								@csrf

								<div class="form-group">
									<label for="nb_uses">Nombre d'utilisation à acheter</label>
									<input class="form-control" type="number" name="nb_uses" id="nb_uses" required="" placeholder="">
									@error('nb_uses')
										<span class="text-danger">{{ $message }}</span>
									@enderror
								</div>

								<div class="form-group">
									<label for="country_code">Indicatif</label>
									<select class="form-control" id="country_code" name="country_code">
										<option value="228" selected>Togo</option>
									</select>
									@error('country_code')
										<span class="text-danger">{{ $message }}</span>
									@enderror
								</div>

								<div class="form-group">
									<label for="phone_number">Numéro de téléphone</label>
									<input class="form-control" name="phone_number" id="phone_number" required="" placeholder="">
									@error('phone_number')
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
