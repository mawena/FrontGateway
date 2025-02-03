<div class="booking-sec">
	<div class="container mb-0">
		<form id="searchForm" action="{{ $_link }}/#searchForm" method="GET" class="booking-form">
			<div class="input-wrap">
				<div class="row align-items-center">
					<div class="form-group col-12 position-relative">
						<div class="search-input w-100">
							<input class="form-control w-100 pr-5" type="text" name="search" placeholder="{{ $search_text }}"
								value="{{ $search }}" />
							<button type="submit" class="th-btn position-absolute end-0 top-50 translate-middle-y">
								<img src="{{ asset('/visitor/assets/img/icon/search.svg') }}" alt="Rechercher">
								Rechercher
							</button>
						</div>
					</div>
				</div>
				<p class="form-messages mb-0 mt-3"></p>
			</div>
		</form>
	</div>
</div>
