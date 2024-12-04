<section class="bg-smoke overflow-hidden space" id="blog-sec">
    <div class="container">
        <div class="mb-30 text-center text-md-start">
            <div class="row align-items-center justify-content-between">
                <div class="col-md-7">
                    <div class="title-area mb-md-0"><span class="sub-title">Nouveaux arrivages !</span>
                        <h2 class="sec-title">Nouveaux événements disponibles</h2>
                    </div>
                </div>
                <div class="col-md-auto"><a href="{{ route('visitor.events') }}" class="th-btn style4 th-icon">
                        Tout voir</a></div>
            </div>
        </div>
        <div class="slider-area">
            <div class="swiper th-slider has-shadow" id="blogSlider1"
                data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"3"}}}'>
                <div class="swiper-wrapper">
                    @for ($i = 0; $i < 10; $i++)
                        <div class="swiper-slide">
                            @include('visitor.modules.event')
                        </div>
                    @endfor
                </div>
            </div>
        </div>
        <div class="shape-mockup shape1 d-none d-xxl-block" data-bottom="20%" data-left="-17%"><img
                src="/visitor/assets/img/shape/shape_1.png" alt="shape"></div>
        <div class="shape-mockup shape2 d-none d-xl-block" data-bottom="5%" data-left="-17%"><img
                src="/visitor/assets/img/shape/shape_2.png" alt="shape"></div>
        <div class="shape-mockup shape3 d-none d-xxl-block" data-bottom="12%" data-left="-10%"><img
                src="/visitor/assets/img/shape/shape_3.png" alt="shape"></div>
    </div>
</section>
