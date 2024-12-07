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
						Modification d'utilisateur / {{ $event['name'] }}
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
									<a href="{{ route('admin.event.index') }}" class="text-success">
										<span><img class="mr-2" src="/assets/images/logo-icon.png" alt="" height="18"><img
												src="/assets/images/logo-text.png" alt="" height="18"></span>
									</a>
								</div>

								<form class="pl-3 pr-3" action="{{ route('admin.event.update', $event['id']) }}" method="POST" enctype="multipart/form-data">
									@csrf
									@method('PUT')
									<div class="row">
										<div class="col-lg-6 col-md-12">
											<div class="form-group">
												<label for="name">Nom</label>
												<input class="form-control" name="name" id="name" required="" placeholder=""
													value="{{ $event['name'] }}">
												@error('name')
													<span class="text-danger">{{ $message }}</span>
												@enderror
											</div>
										</div>
										<div class="col-lg-6 col-md-12">
											<div class="form-group">
												<label for="start_date">Date Début</label>
												<input class="form-control" type="datetime-local" name="start_date" id="start_date" required="" placeholder=""
													value="{{ $event['start_date'] }}">
												@error('start_date')
													<span class="text-danger">{{ $message }}</span>
												@enderror
											</div>
										</div>
										<div class="col-lg-6 col-md-12">
											<div class="form-group">
												<label for="end_date">Date Fin</label>
												<input class="form-control" type="datetime-local" name="end_date" id="end_date" required="" placeholder=""
													value="{{ $event['end_date'] }}">
												@error('end_date')
													<span class="text-danger">{{ $message }}</span>
												@enderror
											</div>
										</div>
										<div class="col-lg-6 col-md-12">
											<div class="form-group">
												<label for="place">Lieu</label>
												<input class="form-control" name="place" id="place" required="" placeholder=""
													value="{{ $event['place'] }}">
												@error('place')
													<span class="text-danger">{{ $message }}</span>
												@enderror
											</div>
										</div>
										<div class="col-lg-6 col-md-12">
											<div class="form-group">
												<label for="type">Type</label>
												<input class="form-control" name="type" id="type" required="" placeholder=""
													value="{{ $event['type'] }}">
												@error('type')
													<span class="text-danger">{{ $message }}</span>
												@enderror
											</div>
										</div>
										<div class="col-lg-6 col-md-12">
											<div class="form-group">
												<label for="nb_expected">Nombre de personnes attendus</label>
												<input class="form-control" type="number" name="nb_expected" id="nb_expected" required="" placeholder=""
													value="{{ $event['nb_expected'] }}">
												@error('nb_expected')
													<span class="text-danger">{{ $message }}</span>
												@enderror
											</div>
										</div>
										<div class="col-lg-6 col-md-12">
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
										<div class="col-lg-6 col-md-12">
											<div class="form-group">
												<label for="entry_price">Prix d'entrée</label>
												<input class="form-control" type="number" name="entry_price" id="entry_price" placeholder=""
													value="{{ $event['entry_price'] }}">
												@error('entry_price')
													<span class="text-danger">{{ $message }}</span>
												@enderror
											</div>
										</div>
										<div class="col-lg-6 col-md-12">
											<div class="form-group">
												<label for="contact">Contact</label>
												<input class="form-control" name="contact" id="contact" required="" placeholder=""
													value="{{ $event['contact'] }}">
												@error('contact')
													<span class="text-danger">{{ $message }}</span>
												@enderror
											</div>
										</div>
										<div class="col-lg-6 col-md-12">
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
													placeholder="" value="{{ $event['description_summary'] }}">
												@error('description_summary')
													<span class="text-danger">{{ $message }}</span>
												@enderror
											</div>
										</div>
										<div class="col-lg-12 col-md-12">
											<div class="form-group">
												<label for="description">Description Detaillé</label>
												<textarea class="form-control" name="description" id="description" placeholder="">{{ $event['description'] }}</textarea>
												@error('description')
													<span class="text-danger">{{ $message }}</span>
												@enderror
											</div>
										</div>
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
