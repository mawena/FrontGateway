<div class="booking-sec">
	<div class="container mb-0">
		<form action="{{ $_link }}" method="GET" class="booking-form">
			<div class="input-wrap">
				<div class="row align-items-center justify-content-between">
					<div class="form-group col-10">
						<div class="search-input">
							<input class="form-control" type="text" name="search" placeholder="Chercher des événements" />
						</div>
					</div>
					<div class="form-btn col-2">
						<button type="submit" class="th-btn">
							<img src="{{ asset('/visitor/assets/img/icon/search.svg') }}" alt="Rechercher">
							Rechercher
						</button>
					</div>
				</div>
				<p class="form-messages mb-0 mt-3"></p>
			</div>
		</form>
	</div>
</div>
