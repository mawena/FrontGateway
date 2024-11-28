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
						Détails de décor / {{ $decor['name'] }}
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
                            <img src="{{ asset($event['poster_path']) }}" style="width: 100%; height: 250px; object-fit: cover"
                               alt="">
                        </div>
						<div class="card-body pb-0">
							<div class="modal-body">
								<div class="pl-3 pr-3">
									<div class="row">
										<div class="col-lg-6 col-md-12">
											<img src="{{ asset($decor['file_path']) }}" class="rounded-app" @style(['width:100%; height:100%; object-fit: contain; border: black 4px dashed'])
											alt="">
										</div>
										<div class="col-lg-6 col-md-12">
											<div class="row">
												<div class="col-lg-6 col-md-12">
													<div class="form-group">
														<label for="decor_id">Evénement</label>
														<p class="py-1 text-bold text-dark">
															<a class="text-primary d-flex align-items-center" href="{{ route('admin.event.show', $event['id']) }}">
																<i class="fa fa-eye"></i> &nbsp; {{ $event['name'] }}
															</a>
														</p>
													</div>
												</div>
												<div class="col-lg-6 col-md-12">
													<div class="form-group">
														<label for="decor_id">Promoteur</label>
														<p class="py-1 text-bold text-dark">
															<a class="text-primary d-flex align-items-center" href="{{ route('admin.promoter.show', $promoter['id']) }}">
																<i class="fa fa-eye"></i> &nbsp; {{ $promoter['name'] }}
															</a>
														</p>
													</div>
												</div>
												<div class="col-lg-12 col-md-12">
													<div class="form-group">
														<label for="name">Nom</label>
														<p class="py-1 text-bold text-uppercase text-dark">{{ $decor['name'] }}</p>
													</div>
												</div>
												<div class="col-lg-6 col-md-12">
													<div class="form-group">
														<label for="start_use">Date de début de disponibilité</label>
														<p class="py-1 text-bold text-uppercase text-dark">{{ $decor['start_use_fr'] }}</p>
													</div>
												</div>
												<div class="col-lg-6 col-md-12">
													<div class="form-group">
														<label for="end_use">Date de fin de disponibilit</label>
														<p class="py-1 text-bold text-uppercase text-dark">{{ $decor['start_use_fr'] }}</p>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group text-right mt-4">
                                        <a href="{{ route('admin.decor.index') }}" class="btn btn-secondary px-5"
                                            type="submit">Retour</a>
                                        <a href="{{ route('admin.decor.edit', $decor['id']) }}"
                                            class="btn btn-warning px-5" type="submit">Modifier ce décor</a>
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
