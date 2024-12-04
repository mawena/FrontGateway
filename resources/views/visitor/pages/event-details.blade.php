@extends('visitor.base')

@section('base.body')
<div class="about-area position-relative overflow-hidden space" id="about-sec">
    <div class="container">
        <div class="row">
            <div class="col-xl-6">
                <div class="img-box1">
                    <div style="border-radius:16px; overflow: hidden;" class="img shadow-lg"><img src="{{ asset('/visitor/assets/img/normal/about_1_1.jpg') }}" style="width: 100%; height: 600px; object-fit: cover" alt="About"></div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="ps-xl-4 ms-xl-2">
                    <div class="title-area mb-20 pe-xl-5 me-xl-5"><span class="sub-title style1">
                        Date de début - Date de Fin
                    </span>
                        <h2 class="sec-title mb-20 pe-xl-5 me-xl-5 heading">Titre Titre Titre </h2>
                        <p class="sec-text mb-30">
                            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Aliquam, quis. Dolores, distinctio facere tempore, assumenda dolorem voluptatem quasi laborum asperiores ut, voluptatum perferendis veritatis corrupti! Error id qui facilis. Fugit tempore dignissimos earum modi ea ab eaque cum cumque quasi, veniam aperiam consectetur impedit. Exercitationem?
                        </p>
                    </div>
                    <div class="about-item-wrap">
                        <div class="about-item">
                            <div class="about-item_img"><img src="/visitor/assets/img/icon/map3.svg"
                                    alt=""></div>
                            <div class="about-item_centent">
                                <h5 class="box-title">Lieu</h5>
                                <p class="about-item_text">
                                    Lomé Toog, BP 550, Von de la station Zener
                                </p>
                            </div>
                        </div>
                        <div class="about-item">
                            <div class="about-item_img"><img src="/visitor/assets/img/icon/guide.svg"
                                    alt=""></div>
                            <div class="about-item_centent">
                                <h5 class="box-title">Modalité de participation</h5>
                                <p class="about-item_text">
                                    Participation payante/gratuite
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-35"><a href="#decors" class="th-btn style3 th-icon">Voir les décors</a></div>
                </div>
            </div>
        </div>
        <div class="shape-mockup shape1 d-none d-xl-block" data-top="12%" data-left="-16%"><img
                src="/visitor/assets/img/shape/shape_1.png" alt="shape"></div>
        <div class="shape-mockup shape2 d-none d-xl-block" data-top="20%" data-left="-16%"><img
                src="/visitor/assets/img/shape/shape_2.png" alt="shape"></div>
        <div class="shape-mockup shape3 d-none d-xl-block" data-top="14%" data-left="-10%"><img
                src="/visitor/assets/img/shape/shape_3.png" alt="shape"></div>
        <div class="shape-mockup about-rating d-none d-xxl-block" data-bottom="50%" data-right="-20%"><i
                class="fa-sharp fa-solid fa-star"></i><span>4.9k</span></div>
        <div class="shape-mockup about-emoji d-none d-xxl-block" data-bottom="25%" data-right="5%"><img
                src="/visitor/assets/img/icon/emoji.png" alt=""></div>
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
                    @for ($i = 0; $i < 10; $i++)
                        <div class="col-lg-6 col-xl-4 col-md-6 pb-3">
                            @include('visitor.modules.decor')
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </section>
@endsection
