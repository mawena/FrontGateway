@extends('visitor.base')

@section('base.body')
	<section class="tour-area position-relative bg-top-center overflow-hidden space" id="service-sec"
		data-bg-src="{{ asset('/visitor/assets/img/bg/tour_bg_1.jpg') }}">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 offset-lg-3">
					<div class="title-area text-center">
						@if ($search)
							<span class="sub-title">Décors Trouvés</span>
						@endif

						<h2 class="sec-title">Choisissez Un Décor</h2>
						<p class="sec-text">
							Voici la liste des décors actuellement disponibles sur {{ config('app.name') }}.
							Choisissez l'un d'eux pour l'utiliser !
						</p>
					</div>
				</div>
			</div>
			<div class="my-5 pt-5">
				@include('visitor.sections.search', ['_link' => route('visitor.decors')])
			</div>
			<div class="slider-area tour-slider">
				<div class="row justify-content-center gx-3 gy-4">
					@forelse ($decors as $key => $decor)
						<div class="col-lg-6 col-xl-3 col-md-6 pb-3">
							@include('visitor.modules.decor')
						</div>
					@empty
						Aucun Décor
					@endforelse
					@if ($decors->hasPages())
						<div class="d-flex justify-content-between align-items-center">
							<span>Entrée {{ $decors->firstItem() }} à {{ $decors->lastItem() }} sur {{ $decors->total() }} Entrées</span>
							<nav class="pagination-wrapper">
								<ul class="pagination justify-content-center">
									{{-- Lien vers la page précédente --}}
									@if ($decors->onFirstPage())
										<li class="page-item disabled">
											<span class="page-link">&laquo;</span>
										</li>
									@else
										<li class="page-item">
											<a class="page-link" href="{{ $decors->previousPageUrl() }}" aria-label="Précédent">
												&laquo;
											</a>
										</li>
									@endif

									{{-- Affichage des numéros de page --}}
									@php
										$currentPage = $decors->currentPage();
										$lastPage = $decors->lastPage();
										$start = max(1, $currentPage - 2);
										$end = min($lastPage, $currentPage + 2);
									@endphp

									{{-- Affichage de la première page et "..." si besoin --}}
									@if ($start > 1)
										<li class="page-item">
											<a class="page-link" href="{{ $decors->url(1) }}">1</a>
										</li>
										@if ($start > 2)
											<li class="page-item disabled"><span class="page-link">...</span></li>
										@endif
									@endif

									{{-- Pages dynamiques autour de la page actuelle --}}
									@for ($i = $start; $i <= $end; $i++)
										<li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
											<a class="page-link" href="{{ $decors->url($i) }}">{{ $i }}</a>
										</li>
									@endfor

									{{-- Affichage de la dernière page et "..." si besoin --}}
									@if ($end < $lastPage)
										@if ($end < $lastPage - 1)
											<li class="page-item disabled"><span class="page-link">...</span></li>
										@endif
										<li class="page-item">
											<a class="page-link" href="{{ $decors->url($lastPage) }}">{{ $lastPage }}</a>
										</li>
									@endif

									{{-- Lien vers la page suivante --}}
									@if ($decors->hasMorePages())
										<li class="page-item">
											<a class="page-link" href="{{ $decors->nextPageUrl() }}" aria-label="Suivant">
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
		</div>
	</section>
@endsection
