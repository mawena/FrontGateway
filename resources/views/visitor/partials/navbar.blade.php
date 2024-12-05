<div class="th-menu-wrapper onepage-nav">
    <div class="th-menu-area text-center"><button class="th-menu-toggle"><i class="fal fa-times"></i></button>
        <div class="mobile-logo"><a href="/"><img src="/visitor/assets/img/logo2.svg"
                    alt="Tourm"></a>
        </div>
        <div class="th-mobile-menu">
            <ul>
                <li><a href="{{ route('visitor.events') }}">Événements</a></li>
                <li><a href="{{ route('visitor.decors') }}">Décors</a></li>
            </ul>
        </div>
    </div>
</div>
<header class="th-header header-layout1">
    <div class="sticky-wrapper">
        <div class="menu-area">
            <div class="container th-container">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto">
                        <div class="header-logo"><a href="/"><img
                                    src="{{ asset("/visitor/assets/img/logo.svg") }}" alt="Tourm"></a></div>
                    </div>
                    <div class="col text-center me-xl-auto">
                        <nav class="main-menu d-none w-100 d-xl-inline-block">
                            <ul>
                                <li><a @class(['active'=> Route::is('visitor.events') || Route::is('visitor.events.details')]) href="{{ route('visitor.events') }}">Événements</a></li>
                                <li><a @class(['active'=> Route::is('visitor.decors') || Route::is('visitor.decors.use')]) href="{{ route('visitor.decors') }}">Décors</a></li>
                            </ul>
                        </nav>
						<button  style="margin-left: 1500cm" type="button" class="th-menu-toggle d-block d-xl-none"><i
                                class="far fa-bars"></i></button>
                    </div>
                    <div class="col-auto d-none d-xl-block">
                        <div class="header-button">
                            <a href="contact.html" class="th-btn style3 th-icon">
                                Nous contacter
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="logo-bg" data-mask-src="{{ asset("/visitor/assets/img/logo_bg_mask.png") }}"></div>
        </div>
    </div>
</header>
