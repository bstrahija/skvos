@if (Carbon::now() >= $event->to)
	<h3 class="pg with-photo text-center">
		@if ($event->mvp)
			@if ($event->mvp->photo)
				<div class="photo" style="background-image: url({{ Image::thumb('/' . $event->mvp->photo, 100) }});"></div>
			@else
				<div class="photo" style="background-image: url({{ Image::thumb('/storage/avatars/avatar_dummy.png', 100) }});"></div>
			@endif<br>

			MVP :
			<strong class="mvp">{{ icn('trophy') }} {{ $event->mvp->full_name }}</strong><br>
			<small>
				<span><strong>{{ $leaderboard->first()->stats->match_efficiency }}%</strong> ({{ $leaderboard->first()->stats->matches_won }}/{{ $leaderboard->first()->stats->matches_played }})</span>
				<span>Bodovi: <strong>{{ $leaderboard->first()->points }}</strong></span>
			</small>
		@else
			Temin je završio.
		@endif
	</h3><hr>
@endif
