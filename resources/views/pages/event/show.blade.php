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
						Détails d'événement / {{ $event['name'] }}
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
					<div class="card" style="overflow: hidden">
						<div class="card-header p-2">
							<img src="/storage/{{ $event['poster_path'] }}" style="width: 100%; height: 250px; object-fit: cover"
								alt="">
						</div>
						<div class="card-body pb-0">
							<div class="modal-body">
								<div class="pl-3 pr-3">
									<div class="row">
										<div class="col-lg-4 col-md-12">
											<div class="form-group">
												<label for="name">Nom</label>
												<p class="py-1 text-bold text-dark">{{ $event['name'] }}</p>
											</div>
										</div>
										<div class="col-lg-4 col-md-12">
											<div class="form-group">
												<label for="start_date">Date Début</label>
												<p class="py-1 text-bold text-dark">{{ $event['start_date'] }}</p>
											</div>
										</div>
										<div class="col-lg-4 col-md-12">
											<div class="form-group">
												<label for="end_date">Date Fin</label>
												<p class="py-1 text-bold text-dark">{{ $event['end_date'] }}</p>
											</div>
										</div>
										<div class="col-lg-4 col-md-12">
											<div class="form-group">
												<label for="place">Lieu</label>
												<p class="py-1 text-bold text-dark">{{ $event['place'] }}</p>
											</div>
										</div>
										<div class="col-lg-4 col-md-12">
											<div class="form-group">
												<label for="type">Type</label>
												<p class="py-1 text-bold text-dark">{{ $event['type'] }}</p>
											</div>
										</div>
										<div class="col-lg-4 col-md-12">
											<div class="form-group">
												<label for="nb_expected">Nombre de personnes attendus</label>
												<p class="py-1 text-bold text-dark">{{ $event['nb_expected'] }}</p>
											</div>
										</div>
										<div class="col-lg-4 col-md-12">
											<div class="form-group">
												<label for="entrance">Entrée</label>
												<p>
													<span @class([
														'py-1 text-bold text-dark w-auto rounded-app px-4 py-2',
														'bg-warning' => $event['entrance'] != 'free',
														'bg-success' => $event['entrance'] == 'free',
													])>
														{{ $event['entrance'] == 'free' ? 'GRATUITE' : 'PAYANTE' }}
													</span>
												</p>
											</div>
										</div>
										<div class="col-lg-4 col-md-12">
											<div class="form-group">
												<label for="entry_price">Prix d'entrée</label>
												<p class="py-1 text-bold text-dark">{{ $event['entry_price'] }} FCFA</p>
											</div>
										</div>
										<div class="col-lg-4 col-md-12">
											<div class="form-group">
												<label for="contact">Contact</label>
												<p class="py-1 text-bold text-dark">{{ $event['contact'] }}</p>
											</div>
										</div>
										<div class="col-lg-6 col-md-12">
											<div class="form-group">
												<label for="description_summary">Description résumé</label>
												<p class="py-1 text-bold text-dark">{{ $event['description_summary'] ?? '- Aucun résumé fourni -' }}</p>
											</div>
										</div>
										<div class="col-lg-6 col-md-12">
											<div class="form-group">
												<label for="description">Description Detaillé</label>
												<p class="py-1 text-bold text-dark">{{ $event['description'] ?? '- Aucune description fournie -' }}</p>
											</div>
										</div>
									</div>
									<div class="form-group text-right mt-4">
										<a href="{{ route('admin.event.index') }}" class="btn btn-secondary px-5" type="submit">Retour</a>
										<a href="{{ route('admin.event.edit', $event['id']) }}" class="btn btn-warning px-5" type="submit">Modifier
											cet événement</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
