@extends('base')

@section('content')
	<div class="page-wrapper">
		<!-- ============================================================== -->
		<!-- Bread crumb and right sidebar toggle -->
		<!-- ============================================================== -->
		<div class="page-breadcrumb">
			<div class="row">
				<div class="col-7 align-self-center">
					<h2 class="page-title text-truncate text-dark font-weight-medium mb-1">Gestion des Evenements</h2>
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
									Liste des évènements
									<span class="text-primary px-3 ml-2 py-4 border-primary">
										[ Total : {{ count($events) }} ]
									</span>
								</h4>
								<div class="ml-auto">
									<button type="button" class="btn btn-primary px-4" data-toggle="modal" data-target="#signup-modal"
										id="toggle_modal">
										Nouvel évènement
									</button>
								</div>
							</div>
							<div class="table-responsive">
								<table id="zero_config" class="table table-striped table-bordered no-wrap">
									<thead>
										<tr class="text-center">
											<th>Nom</th>
											<th>Type</th>
											<th>Lieu</th>
											<th>Date de debut</th>
											<th>Date de fin</th>
											<th>Nombre de personne attendues</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($events as $event)
											<tr class="py-0 text-center">

												<td class="py-4">{{ $event['name'] }}</td>
												<td class="py-4">{{ $event['type'] }}</td>
												<td class="py-4">{{ $event['place'] }}</td>
												<td class="py-4">{{ $event['start_date'] }}</td>
												<td class="py-4">{{ $event['end_date'] }}</td>
												<td class="py-4">{{ $event['nb_expected'] }}</td>
												<td class="" style="max-width: 100px">
													{{-- <button type="button" class="btn text-primary"><i class="fa fa-eye"></i></button> --}}
													<a href="{{ route('admin.event.edit', $event['id']) }}" type="button" class="btn text-warning"><i
															class="fa fa-edit"></i></a>
													<form action="{{ route('admin.event.destroy', $event['id']) }}" method="POST"
														style="display:inline-block;">
														@csrf
														@method('DELETE')
														<button type="submit" class="btn"
															onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet évènement ?')">
															<i style="color: red" class="fa fa-trash"></i>
														</button>
													</form>
													<a href="{{ route('admin.event.destroy', $event['id']) }}" class="btn">
													</a>
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
					<div class="modal-content p-4 rounded-app">
						<div class="modal-body">
							<div class="text-center mt-2 mb-4">
								<a href="{{ route('admin.event.index') }}" class="text-success">
									<span><img class="mr-2" src="/assets/images/logo-icon.png" alt="" height="18"><img
											src="/assets/images/logo-text.png" alt="" height="18"></span>
								</a>
							</div>

							<form class="pl-3 pr-3" action="/admin/event" method="POST" enctype="multipart/form-data">
								@csrf
								<div class="row">
									<div class="col-lg-12 col-md-12">
										<div class="form-group">
											<label for="name">Nom</label>
											<input class="form-control" name="name" id="name" required="" placeholder="" value="Damso">
											@error('name')
												<span class="text-danger">{{ $message }}</span>
											@enderror
										</div>
									</div>
									<div class="col-lg-12 col-md-12">
										<div class="form-group">
											<label for="start_date">Date Début</label>
											<input class="form-control" type="date" name="start_date" id="start_date" required="" placeholder=""
												value="2024-01-01">
											@error('start_date')
												<span class="text-danger">{{ $message }}</span>
											@enderror
										</div>
									</div>
									<div class="col-lg-12 col-md-12">
										<div class="form-group">
											<label for="end_date">Nom</label>
											<input class="form-control" type="date" name="end_date" id="end_date" required="" placeholder=""
												value="2024-01-01">
											@error('end_date')
												<span class="text-danger">{{ $message }}</span>
											@enderror
										</div>
									</div>
									<div class="col-lg-12 col-md-12">
										<div class="form-group">
											<label for="place">Lieu</label>
											<input class="form-control" name="place" id="place" required="" placeholder="" value="Lomé">
											@error('place')
												<span class="text-danger">{{ $message }}</span>
											@enderror
										</div>
									</div>
									<div class="col-lg-12 col-md-12">
										<div class="form-group">
											<label for="type">Type</label>
											<input class="form-control" name="type" id="type" required="" placeholder="" value="Test">
											@error('type')
												<span class="text-danger">{{ $message }}</span>
											@enderror
										</div>
									</div>
									<div class="col-lg-12 col-md-12">
										<div class="form-group">
											<label for="nb_expected">Nombre de personnes attendus</label>
											<input class="form-control" type="number" name="nb_expected" id="nb_expected" required="" placeholder=""
												value="10">
											@error('nb_expected')
												<span class="text-danger">{{ $message }}</span>
											@enderror
										</div>
									</div>
									<div class="col-lg-12 col-md-12">
										<div class="form-group">
											<label for="entrance">Entrée</label>
											<select class="form-control" id="entrance" name="entrance" required="">
												<option value="free">Grauite</option>
												<option value="paid">Payante</option>
											</select>
											@error('entrance')
												<span class="text-danger">{{ $message }}</span>
											@enderror
										</div>
									</div>
									<div class="col-lg-12 col-md-12">
										<div class="form-group">
											<label for="entry_price">Prix d'entrée</label>
											<input class="form-control" type="number" name="entry_price" id="entry_price" placeholder=""
												value="500">
											@error('entry_price')
												<span class="text-danger">{{ $message }}</span>
											@enderror
										</div>
									</div>
									<div class="col-lg-12 col-md-12">
										<div class="form-group">
											<label for="contact">Contact</label>
											<input class="form-control" name="contact" id="contact" required="" placeholder="" value="+228 30 30 30 30">
											@error('contact')
												<span class="text-danger">{{ $message }}</span>
											@enderror
										</div>
									</div>
									<div class="col-lg-12 col-md-12">
										<div class="form-group">
											<label for="poster">Poster</label>
											<input class="form-control" type="file" name="poster" id="poster" placeholder="" value="">
											@error('poster')
												<span class="text-danger">{{ $message }}</span>
											@enderror
										</div>
									</div>
									<div class="col-lg-12 col-md-12">
										<div class="form-group">
											<label for="description_summary">Description résumé</label>
											<input class="form-control" name="description_summary" id="description_summary" required=""
												placeholder="" value="Test">
											@error('description_summary')
												<span class="text-danger">{{ $message }}</span>
											@enderror
										</div>
									</div>
									<div class="col-lg-12 col-md-12">
										<div class="form-group">
											<label for="description">Description Detaillé</label>
											<textarea class="form-control" name="description" id="description" placeholder=""></textarea>
											@error('description')
												<span class="text-danger">{{ $message }}</span>
											@enderror
										</div>
									</div>
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
