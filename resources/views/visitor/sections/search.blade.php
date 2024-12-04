<div class="booking-sec">
    <div class="container mb-0">
        <form action="{{ $_link }}" method="GET" class="booking-form">
            <div class="input-wrap">
                <div class="row align-items-center justify-content-between">
                    <div class="form-group col-md-6 col-lg-auto">
                        <div class="icon"><i class="fa-light fa-route"></i></div>
                        <div class="search-input">
                            <label>Lieu</label>
                            <select required name="place" id="place"
                                class="form-select nice-select">
                                <option selected value="" disabled>
                                    * Choisir un lieu
                                </option>
                                <option @selected(request('place') == "Australia") value="Australia">Australia</option>
                                <option @selected(request('place') == "Dubai") value="Dubai">Dubai</option>
                                <option @selected(request('place') == "England") value="England">England</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-6 col-lg-auto">
                        <div class="icon"><i class="fa-regular fa-person-hiking"></i></div>
                        <div class="search-input">
                            <label>Modalité de participation</label>
                            <select required class="nice-select" name="type" id="type">
                                <option selected value="" disabled>
                                   * Choisir une modalité
                                </option>
                                <option @selected(request('type') == "free") value="free">Participation Gratuite</option>
                                <option @selected(request('type') == "paid") value="paid">Participation Payante</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-6 col-lg-auto">
                        <div class="icon"><i class="fa-light fa-clock"></i></div>
                        <div class="search-input">
                            <label>Intervalle du</label>
                            <input required type="date" value="{{ request('start') ?? \Carbon\Carbon::now()->toDateString() }}"
                                class="form-input" name="start" />
                        </div>
                    </div>
                    <div class="form-group col-md-6 col-lg-auto">
                        <div class="icon"><i class="fa-light fa-clock"></i></div>
                        <div class="search-input">
                            <label>Au</label>
                            <input required type="date"
                                value="{{ request('end') ?? \Carbon\Carbon::now()->addMonth()->toDateString() }}" class="form-input"
                                name="end" />
                        </div>
                    </div>
                    <div class="form-btn col-md-12 col-lg-auto">
                        <button type="submit" class="th-btn">
                            <img src="{{ asset('/visitor/assets/img/icon/search.svg') }}" alt="">
                            Rechercher
                        </button>
                    </div>
                </div>
                <p class="form-messages mb-0 mt-3"></p>
            </div>
        </form>
    </div>
</div>
