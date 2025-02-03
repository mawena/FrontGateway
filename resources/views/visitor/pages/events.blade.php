@extends('visitor.base')

@section('base.body')
	<section class="bg-white overflow-hidden space position-relative bg-top-center" id="blog-sec"
		data-bg-src="{{ asset('/visitor/assets/img/bg/tour_bg_1.jpg') }}">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 offset-lg-3">
					<div class="title-area text-center">
						@if ($search)
							<span class="sub-title">Événements Trouvés</span>
						@endif
						<h2 class="sec-title">Choisissez Un Événement</h2>
						<p class="sec-text">
							Voici la liste des événements actuellement disponibles sur {{ config('app.name') }}.
							Choisissez l'un d'eux pour utiliser ses décors !
						</p>
					</div>
				</div>
			</div>
			<div class="my-5 pt-5">
				@include('visitor.sections.search', ['_link' => route('visitor.events')])
			</div>
			<br>
			<div class="slider-area">
				<div class="row justify-content-center gx-3 gy-4">
					@forelse ($events as $event)
						<div class="col-12 col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 col-xl-4 col-xxl-3 pb-3">
							@include('visitor.modules.event')
						</div>
					@empty
						Aucun événement
					@endforelse
					@if ($events->hasPages())
						<div class="d-flex justify-content-between align-items-center">
							<span>Entrée {{ $events->firstItem() }} à {{ $events->lastItem() }} sur {{ $events->total() }} Entrées</span>
							<nav class="pagination-wrapper">
								<ul class="pagination justify-content-center">
									{{-- Lien vers la page précédente --}}
									@if ($events->onFirstPage())
										<li class="page-item disabled">
											<span class="page-link">&laquo;</span>
										</li>
									@else
										<li class="page-item">
											<a class="page-link" href="{{ $events->previousPageUrl() }}" aria-label="Précédent">
												&laquo;
											</a>
										</li>
									@endif

									{{-- Affichage des numéros de page --}}
									@php
										$currentPage = $events->currentPage();
										$lastPage = $events->lastPage();
										$start = max(1, $currentPage - 2);
										$end = min($lastPage, $currentPage + 2);
									@endphp

									{{-- Affichage de la première page et "..." si besoin --}}
									@if ($start > 1)
										<li class="page-item">
											<a class="page-link" href="{{ $events->url(1) }}">1</a>
										</li>
										@if ($start > 2)
											<li class="page-item disabled"><span class="page-link">...</span></li>
										@endif
									@endif

									{{-- Pages dynamiques autour de la page actuelle --}}
									@for ($i = $start; $i <= $end; $i++)
										<li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
											<a class="page-link" href="{{ $events->url($i) }}">{{ $i }}</a>
										</li>
									@endfor

									{{-- Affichage de la dernière page et "..." si besoin --}}
									@if ($end < $lastPage)
										@if ($end < $lastPage - 1)
											<li class="page-item disabled"><span class="page-link">...</span></li>
										@endif
										<li class="page-item">
											<a class="page-link" href="{{ $events->url($lastPage) }}">{{ $lastPage }}</a>
										</li>
									@endif

									{{-- Lien vers la page suivante --}}
									@if ($events->hasMorePages())
										<li class="page-item">
											<a class="page-link" href="{{ $events->nextPageUrl() }}" aria-label="Suivant">
												&raquo;
											</a>
										</li>
									@else
										<li class="page-item disabled">
											<span class="page-link">&raquo;</span>
										</li>
									@endif
								</ul>
							</nav>
						</div>
					@endif
				</div>
			</div>
			<div class="shape-mockup shape1 d-none d-xxl-block" data-bottom="20%" data-left="-17%"><img
					src="{{ asset('/visitor/assets/img/shape/shape_1.png') }}" alt="shape"></div>
			<div class="shape-mockup shape2 d-none d-xl-block" data-bottom="5%" data-left="-17%"><img
					src="{{ asset('/visitor/assets/img/shape/shape_2.png') }}" alt="shape"></div>
			<div class="shape-mockup shape3 d-none d-xxl-block" data-bottom="12%" data-left="-10%"><img
					src="{{ asset('/visitor/assets/img/shape/shape_3.png') }}" alt="shape"></div>
		</div>
	</section>
@endsection
