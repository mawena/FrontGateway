<section class="category-area bg-top-center" data-bg-src="/visitor/assets/img/bg/category_bg_1.png">
    <div class="container th-container">
        <div class="title-area text-center"><span class="sub-title">Nouveaux Décors Ajoutés</span>
            <h2 class="sec-title">Faites votre choix</h2>
        </div>
        <div class="swiper th-slider has-shadow categorySlider" id="categorySlider1"
            data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"3"},"1400":{"slidesPerView":"5"}}}'>
            <div class="swiper-wrapper">
                @for ($i = 0; $i < 20; $i++)
                    <div class="swiper-slide">
                        @include('visitor.modules.decor-simple')
                    </div>
                @endfor
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>
