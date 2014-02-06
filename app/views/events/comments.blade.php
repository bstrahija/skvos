@if (Auth::check() and $event->comments)

	<h4 class="pg">{{ icn('comment') }} Komentari</h4>

	<hr>

	<div class="comments-container" id="comments-container">
		<ul class="comments comments-{{ $event->id }}">
			@include('events.comment_items')
		</ul>
		<hr>
		{{ Form::open(['route' => 'api.comments.store']) }}
			<input type="hidden" name="event_id" value="{{ $event->id }}">
			<input type="hidden" name="author_id" value="{{ Auth::user()->id }}">

			<div class="row">
				<input type="text" name="text" placeholder="Tvoja poruka...." autocomplete="off">
			</div>

		{{ Form::close() }}
	</div>

	<hr>

@endif
