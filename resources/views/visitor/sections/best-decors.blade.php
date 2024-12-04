<section class="tour-area position-relative bg-top-center overflow-hidden space" id="service-sec"
    data-bg-src="/visitor/assets/img/bg/tour_bg_1.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="title-area text-center"><span class="sub-title">Meilleurs décors pour vous</span>
                    <h2 class="sec-title">Utilisez nos meilleurs décors</h2>
                    <p class="sec-text">
                        Trouvez des décors captivants et professionnels sur {{ config('app.name') }}.
                    </p>
                </div>
            </div>
        </div>
        <div class="slider-area tour-slider">
            <div class="swiper th-slider has-shadow slider-drag-wrap"
                data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"3"},"1300":{"slidesPerView":"4"}}}'>
                <div class="swiper-wrapper">
                    @for ($i = 0; $i < 10; $i++)
                        <div class="swiper-slide">
                            @include('visitor.modules.decor')
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</section>
