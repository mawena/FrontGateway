<a href="{{ route('visitor.events.details', ['id' => $event['id']]) }}">
	<div class="blog-box th-ani">
		<div class="blog-img global-img">
			<img src="/storage/{{ $event['poster_path'] }}" alt="blog image">
		</div>
		<div class="blog-box_content">
			<div class="blog-meta">
				<a class="author"
					href="{{ route('visitor.events.details', ['id' => $event['id']]) }}">{{ $event->toArray()['start_date_fr'] }}</a>
				<a href="{{ route('visitor.events.details', ['id' => $event['id']]) }}">{{ $event['place'] }}</a>
				<a href="{{ route('visitor.events.details', ['id' => $event['id']]) }}">{{ count($event['decors']) }} Décors</a>
			</div>
			<h3 class="box-title">
				<a href="{{ route('visitor.events.details', ['id' => $event['id']]) }}">
					{{ $event['name'] }}
				</a>
			</h3>
			<p class="description-summary">
				{{ $event['description_summary'] }}
			</p>
			<a href="{{ route('visitor.events.details', ['id' => $event['id']]) }}" class="th-btn style4 th-icon">Voir les
				détails</a>
		</div>
	</div>
</a>

<style>
	/* Conteneur principal */
	.blog-box {
		display: flex;
		flex-direction: column;
		justify-content: space-between;
		height: 500px;
		/* Hauteur uniforme */
		padding: 10px;
		overflow: hidden;
	}

	/* Image */
	.blog-img {
		height: 300px;
		overflow: hidden;
		display: flex;
		justify-content: center;
		align-items: center;
		background-color: #f5f5f5;
	}

	.blog-img img {
		height: 100%;
		width: auto;
		object-fit: cover;
	}

	/* Contenu */
	.blog-box_content {
		display: flex;
		flex-direction: column;
		justify-content: space-between;
		overflow: hidden;
	}

	.blog-meta {
		font-size: 14px;
		color: #888;
		margin-bottom: 10px;
	}

	/* Titre */
	.box-title {
		font-size: 16px;
		font-weight: bold;
		margin-bottom: 10px;
		line-height: 1.4;
	}

	/* Description */
	.description-summary {
		flex-grow: 1;
		font-size: 14px;
		line-height: 1.5;
		color: #333;
		overflow: hidden;
		text-overflow: ellipsis;
		display: -webkit-box;
		-webkit-line-clamp: 3;
		/* Nombre de lignes visibles */
		-webkit-box-orient: vertical;
		margin-bottom: 30px;
	}

	/* Bouton */
	.th-btn {
		text-align: center;
		padding: 8px 12px;
		font-size: 14px;
		background-color: #007bff;
		color: #fff;
		border-radius: 5px;
		text-decoration: none;
	}

	.th-btn:hover {
		background-color: #0056b3;
	}
</style>
