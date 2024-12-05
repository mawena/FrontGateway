@extends('visitor.base')

@section('base.body')
<div class="about-area position-relative overflow-hidden space" id="about-sec">
    <div class="container">
        <div class="row">
            <div class="col-xl-6">
                <div class="img-box1">
                    <div style="border-radius:16px; overflow: hidden;" class="img shadow-lg"><img src="/storage/{{$event['poster_path']}}" style="width: 100%; height: 600px; object-fit: cover" alt="About"></div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="ps-xl-4 ms-xl-2">
                    <div class="title-area mb-20 pe-xl-5 me-xl-5"><span class="sub-title style1">
                        {{$event['start_date_fr']}} - {{$event['end_date_fr']}}
                    </span>
                        <h2 class="sec-title mb-20 pe-xl-5 me-xl-5 heading">{{$event['name']}}</h2>
                        <p class="sec-text mb-30">
                            {{$event['description_summary']}}
                        </p>
						
						<p class="sec-text mb-30">
                            {{$event['description']}}
                        </p>
                    </div>
                    <div class="about-item-wrap">
                        <div class="about-item">
                            <div class="about-item_img"><img src="/visitor/assets/img/icon/map3.svg"
                                    alt=""></div>
                            <div class="about-item_centent">
                                <h5 class="box-title">Lieu</h5>
                                <p class="about-item_text">
                                    {{$event['place']}}
                                </p>
                            </div>
                        </div>
                        <div class="about-item">
                            <div class="about-item_img"><img src="/visitor/assets/img/icon/guide.svg"
                                    alt=""></div>
                            <div class="about-item_centent">
                                <h5 class="box-title">Modalité de participation</h5>
                                <p class="about-item_text">
                                    Participation {{$event['entrance_fr']}}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-35"><a href="#decors" class="th-btn style3 th-icon">Voir les décors</a></div>
                </div>
            </div>
        </div>
    </div>
</div>

    <section class="tour-area position-relative bg-top-center overflow-hidden space" id="decors"
        data-bg-src="{{ asset('/visitor/assets/img/bg/tour_bg_1.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="title-area text-center"><span class="sub-title">Décors Associés</span>
                        <h2 class="sec-title">Choisissez Un Décor</h2>
                        <p class="sec-text">
                            Voici la liste des décors associés à cet événement.
                            Choisissez l'un d'eux pour l'utiliser !
                        </p>
                    </div>
                </div>
            </div>
            <div class="slider-area tour-slider">
                <div class="row justify-content-center gx-3 gy-4">
                    @forelse ($event["decors"] as $key => $decor)
						<div class="col-lg-6 col-xl-4 col-md-6 pb-3">
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
