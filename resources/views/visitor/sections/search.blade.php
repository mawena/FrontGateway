{{-- ----------------------------------------------V01---------------------------------------------- --}}

{{-- <div class="booking-sec">
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
</div> --}}

{{-- ----------------------------------------------V02---------------------------------------------- --}}

{{-- <div class="booking-sec">
	<div class="container mb-0">
		<form action="{{ $_link }}" method="GET" class="booking-form">
			<div class="input-wrap">
				<div class="row align-items-center">
					<div class="form-group col-12 position-relative">
						<div class="search-input w-100">
							<input class="form-control w-100 pr-5" type="text" name="search" placeholder="{{ $search_text }}" />
							<button type="submit" class="th-btn position-absolute end-0 top-50 translate-middle-y">
								<img src="{{ asset('/visitor/assets/img/icon/search.svg') }}" alt="Rechercher">
								Rechercher
							</button>
						</div>
					</div>
				</div>

				<!-- Option de tri -->
				<div class="row mt-3">
					<div class="col-12">
						<select name="sort" class="form-select">
							<option value="">Trier par</option>
							<option value="created_at.desc">Les plus récents</option>
							<option value="created_at.asc">Les plus anciens</option>
							<option value="start_date.asc">Les plus proches</option>
							<option value="start_date.desc">Les moins proches</option>
						</select>
					</div>
				</div>

				<p class="form-messages mb-0 mt-3"></p>
			</div>
		</form>
	</div>
</div> --}}

{{-- ----------------------------------------------V03---------------------------------------------- --}}

{{-- <div class="booking-sec">
	<div class="container mb-0">
		<form id="search-form" action="{{ $_link }}#search-form" method="GET" class="booking-form">
			<div class="input-wrap">
				<div class="row align-items-center">
					<div class="form-group col-12 position-relative">
						<div class="search-input w-100">
							<input class="form-control w-100 pr-5" type="text" name="search" placeholder="{{ $search_text }}" />
							<button type="submit" class="th-btn position-absolute end-0 top-50 translate-middle-y">
								<img src="{{ asset('/visitor/assets/img/icon/search.svg') }}" alt="Rechercher">
								Rechercher
							</button>
						</div>
					</div>
				</div>
				<p class="form-messages mb-0 mt-3"></p>
			</div>

			<div class="row mt-3">
				<div class="col-12">
					<label for="sort-by" class="fw-bold me-2">Trier par :</label>
					<select id="sort-by" name="sort" class="form-select">
						@foreach ($sortList as $key => $value)
							<option value="{{ $key }}" @if ($sort == '{{ $key }}') selected @endif>{{ $value }}
							</option>
						@endforeach
					</select>
				</div>
			</div>
		</form>
	</div>
</div>

<script>
	document.getElementById('sort-by').addEventListener('change', function() {
		document.getElementById('search-form').submit();
	});
</script> --}}

{{-- ----------------------------------------------V04---------------------------------------------- --}}

<div class="booking-sec">
	<div class="container mb-0">
		<form id="search-form" action="{{ $_link }}#search-form" method="GET" class="booking-form">
			<div class="input-wrap">
				<div class="row align-items-center">
					<div class="form-group col-12 position-relative">
						<div class="search-input w-100">
							<input class="form-control w-100 pr-5" type="text" name="search" placeholder="{{ $search_text }}"
								value="{{ request('search', '') }}" />
							<button type="submit" class="th-btn position-absolute end-0 top-50 translate-middle-y">
								<img src="{{ asset('/visitor/assets/img/icon/search.svg') }}" alt="Rechercher">
								Rechercher
							</button>
						</div>
					</div>
				</div>
				<p class="form-messages mb-0 mt-3"></p>
			</div>

			<div class="row mt-3">
				<div class="col-12">
					<label for="sort-by" class="fw-bold me-2">Trier par :</label>
					<select id="sort-by" name="sort" class="form-select">
						@foreach ($sortList as $key => $value)
							<option value="{{ $key }}" @if ($sort == $key) selected @endif>{{ $value }}
							</option>
						@endforeach
					</select>
				</div>
			</div>
		</form>
	</div>
</div>

<script>
	document.getElementById('sort-by').addEventListener('change', function() {
		document.getElementById('search-form').submit();
	});
</script>
