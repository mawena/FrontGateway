@extends('visitor.base')

@section('base.body')
	<div class="about-area position-relative overflow-hidden space" id="about-sec">
		<div class="container">
			<div class="row">
				<div class="col-xl-6">
					<div class="img-box1">
						<div style="border-radius:16px; overflow: hidden;" class="img shadow-lg"><img
								src="/storage/{{ $event['poster_path'] }}" style="width: 100%; height: 600px; object-fit: cover" alt="About">
						</div>
					</div>
				</div>
				<div class="col-xl-6">
					<div class="ps-xl-4 ms-xl-2">
						<div class="title-area mb-20 pe-xl-5 me-xl-5">
							<h2 class="sec-title mb-20 pe-xl-5 me-xl-5 heading">{{ $event['name'] }}</h2>
							<p class="sec-text mb-30">
								{{ $event['description_summary'] }}
							</p>

							<p class="sec-text mb-30">
								{{ $event['description'] }}
							</p>
						</div>
						<div class="about-item-wrap">
							<div class="about-container">
								<div class="about-item">
									<div class="about-item_centent">
										<h5 class="box-title">Début</h5>
										<p class="about-item_text">
											<span>
												<i class="fa fa-calendar" style="font-size: 24px;"></i>
												{{ $event['start_date_fr'] }}
											</span>
											<br>
											<span>
												<i class="fa fa-clock" style="font-size: 24px;"></i>
												{{ $event['start_hour_fr'] }}
											</span>
										</p>
									</div>
								</div>
								<div class="about-item">
									<div class="about-item_centent">
										<h5 class="box-title">Fin</h5>
										<p class="about-item_text">
											<span>
												<i class="fa fa-calendar" style="font-size: 24px;"></i>
												{{ $event['end_date_fr'] }}
											</span>
											<br>
											<span>
												<i class="fa fa-clock" style="font-size: 24px;"></i>
												{{ $event['end_hour_fr'] }}
											</span>
										</p>
									</div>
								</div>
							</div>
							<div class="about-item">
								<div class="about-item_img"><img src="/visitor/assets/img/icon/map3.svg" alt=""></div>
								<div class="about-item_centent">
									<h5 class="box-title">Lieu</h5>
									<p class="about-item_text">
										{{ $event['place'] }}
									</p>
								</div>
							</div>
							<div class="about-item">
								<div class="about-item_img"><img src="/visitor/assets/img/icon/guide.svg" alt=""></div>
								<div class="about-item_centent">
									<h5 class="box-title">Modalité de participation</h5>
									<p class="about-item_text">
										Participation {{ $event['entrance_fr'] }}
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
	<style>
		.about-container {
			display: flex;
			justify-content: space-between;
			/* Sépare les éléments avec un espace */
			align-items: flex-start;
			/* Aligne en haut */
			gap: 20px;
			/* Espacement entre les items */
		}

		.about-item {
			flex: 1;
			/* Permet aux items de prendre une largeur égale */
		}

		.about-item_centent {
			/* text-align: center; */
			/* Centrer le contenu des items */
		}
	</style>
@endsection
