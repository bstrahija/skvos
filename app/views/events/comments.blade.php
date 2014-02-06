@if ($event->comments)

	<h4 class="pg">Komentari</h4>

	<hr>

	@if ($event->comments->count())

		<ul class="comments comments-{{ $event->id }}">
			@foreach ($event->comments as $comment)
				<li>
					<em>{{ icn('comment') }} {{ $comment->author->full_name }}</em>:
					{{ $comment->text }}
				</li>
			@endforeach
		</ul>

		<hr>

	@else

		<p class="not-found">Nema komentara.</p>

	@endif

@endif
