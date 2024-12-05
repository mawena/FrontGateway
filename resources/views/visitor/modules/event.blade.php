<div class="blog-box th-ani">
	<div class="blog-img global-img"><img src="/storage/{{ $event['poster_path'] }}" alt="blog image"></div>
	<div class="blog-box_content">
		<div class="blog-meta">
			<a class="author" href="{{ route('visitor.events.details', ['id' => $event['id']]) }}">{{ $event['start_date_fr'] }}</a>
			<a href="{{ route('visitor.events.details', ['id' => $event['id']]) }}">{{$event['place']}}</a>
			<a href="{{ route('visitor.events.details', ['id' => $event['id']]) }}">{{count($event['decors'])}} Décors</a>
		</div>
		<h3 class="box-title">
			<a href="{{ route('visitor.events.details', ['id' => $event['id']]) }}">
				{{ $event['name'] }}
			</a>
			<p class="text-dark" style="font-size: 14px; font-weight: 100; line-height: 28px">
				{{$event["description_summary"]}}
			</p>
		</h3>
		<a href="{{ route('visitor.events.details', ['id' => $event['id']]) }}" class="th-btn style4 th-icon">Voir les détails</a>
	</div>
</div>
