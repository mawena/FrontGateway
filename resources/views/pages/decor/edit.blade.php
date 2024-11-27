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
						Modification de décor / {{ $decor['name'] }}
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
									<a href="{{ route('admin.decor.index') }}" class="text-success">
										<span><img class="mr-2" src="/assets/images/logo-icon.png" alt="" height="18"><img
												src="/assets/images/logo-text.png" alt="" height="18"></span>
									</a>
								</div>

								<form class="pl-3 pr-3" action="{{ route('admin.decor.update', $decor['id']) }}" method="POST">
									@csrf
									@method('PUT')
									<div class="row">
										<div class="col-lg-6 col-md-12">
											<div class="form-group">
												<label for="event_id">Evénement</label>
												<select class="form-control" id="event_id" name="event_id" required="">
													@foreach ($events as $event)
														<option value="{{ $event['id'] }}">{{ $event['name'] }}</option>
													@endforeach
												</select>
												@error('event_id')
													<span class="text-danger">{{ $message }}</span>
												@enderror
											</div>
										</div>
										<div class="col-lg-6 col-md-12">
											<div class="form-group">
												<label for="name">Nom</label>
												<input class="form-control" name="name" id="name" required="" placeholder=""
													value="{{ $decor['name'] }}">
												@error('name')
													<span class="text-danger">{{ $message }}</span>
												@enderror
											</div>
										</div>
										<div class="col-lg-6 col-md-12">
											<div class="form-group">
												<label for="start_use">Date de début de disponibilit</label>
												<input class="form-control" type="date" name="start_use" id="start_use" placeholder="" value="{{$decor['start_use']}}">
												@error('start_use')
													<span class="text-danger">{{ $message }}</span>
												@enderror
											</div>
										</div>
										<div class="col-lg-6 col-md-12">
											<div class="form-group">
												<label for="end_use">Date de fin de disponibilit</label>
												<input class="form-control" type="date" name="end_use" id="end_use" placeholder="" value="{{$decor['end_use']}}">
												@error('end_use')
													<span class="text-danger">{{ $message }}</span>
												@enderror
											</div>
										</div>
										<div class="col-lg-6 col-md-12">
											<div class="form-group">
												<label for="file">Décor</label>
												<input class="form-control" type="file" name="file" id="file" placeholder=""
													value="2024-01-01">
												@error('file')
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
