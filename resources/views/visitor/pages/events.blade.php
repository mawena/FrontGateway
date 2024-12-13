@extends('visitor.base')

@section('base.body')
<section class="bg-white overflow-hidden space position-relative bg-top-center" id="blog-sec" data-bg-src="{{ asset('/visitor/assets/img/bg/tour_bg_1.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="title-area text-center"><span class="sub-title">Événements Trouvés</span>
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
					<div class="col-3 pb-3">
						@include('visitor.modules.event')
					</div>
				@empty
					Aucun événement
				@endforelse
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
