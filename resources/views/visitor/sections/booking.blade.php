<div class="booking-sec">
    <div class="container mb-0">
        <form action="https://html.themeholy.com/tourm/demo/mail.php" method="POST" class="booking-form ajax-contact">
            <div class="input-wrap">
                <div class="row align-items-center justify-content-between">
                    <div class="form-group col-md-12 col-lg-auto">
                        <div class="icon"><i class="fa-light fa-route"></i></div>
                        <div class="search-input"><label>Lieu</label> <select name="place" id="place"
                                class="form-select nice-select">
                                <option value="Choisir un lieu" selected="selected" disabled="disabled">
                                    Choisir un lieu
                                </option>
                                <option value="Lomé">Lomé</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-12 col-lg-auto">
                        <div class="icon"><i class="fa-regular fa-person-hiking"></i></div>
                        <div class="search-input">
                            <label>Modalité</label>
                            <select class="nice-select" name="type" id="type">
                                <option value="type" selected="selected" disabled="disabled">
                                    Modalité de participation
                                </option>
                                <option value="free">Participation Gratuite</option>
                                <option value="paid">Participation Payante</option>
                            </select>
                        </div>
                    </div>
                    {{-- <div class="form-group col-md-6 col-lg-auto">
                        <div class="icon"><i class="fa-light fa-clock"></i></div>
                        <div class="search-input">
                            <label>Intervalle du</label>
                            <input type="date" class="form-input" name="start" />
                        </div>
                    </div>
                    <div class="form-group col-md-6 col-lg-auto">
                        <div class="icon"><i class="fa-light fa-clock"></i></div>
                        <div class="search-input">
                            <label>Au</label>
                            <input type="date" class="form-input" name="end" />
                        </div>
                    </div> --}}
                    <div class="form-btn col-md-12 col-lg-auto">
                        <button class="th-btn">
                            <img src="{{ asset("/visitor/assets/img/icon/search.svg") }}" alt="">
                            Rechercher
                        </button>
                    </div>
                </div>
                <p class="form-messages mb-0 mt-3"></p>
            </div>
        </form>
    </div>
</div>
