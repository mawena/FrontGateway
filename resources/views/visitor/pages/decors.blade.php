@extends('visitor.base')

@section('base.body')
    <section class="tour-area position-relative bg-top-center overflow-hidden space" id="service-sec"
        data-bg-src="{{ asset('/visitor/assets/img/bg/tour_bg_1.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="title-area text-center"><span class="sub-title">Décors Trouvés</span>
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
                </div>
            </div>
        </div>
    </section>
@endsection
