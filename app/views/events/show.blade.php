@extends('_layout.default')

@section('content')

<div class="matches">
	<?php $now = Carbon::now()->format('Y-m-d H:i:s'); ?>

	@if ($event->from > $now)
		<h3 class="c">Termin još nije održan</h3>
		<br><br><br><br><br><br><br><br><br>
		<hr>

	@else
		@if ($now >= $event->from and $now <= $event->to)
			<h3>Termin je u tijeku</h3>
		@else
			<h3>Pregled</h3>
		@endif

		<ul>
			@foreach ($event->attendees as $user)
				<li>
					<h4>
						{{ $user->full_name }}
						<em>je dobio {{ $event->userWonSets($user->id) }} setova i {{ $event->userWonMatches($user->id) }} mečeva</em>
					</h4>
				</li>
			@endforeach
		</ul>

		<hr>

		@if ($matches and ! $matches->isEmpty())
			<h3>Mečevi</h3>
			<ul>
				@foreach ($matches as $match)
					<li>
						<h4>
							{{ $match->playerOne->first_name }}
							<em>Vs.</em>
							{{ $match->playerTwo->first_name }}
						</h4>
						<p>
							Rezultat:
							{{ $match->player1_sets_won }}
							<em>:</em>
							{{ $match->player2_sets_won }}
						</p>
						<p>
							Pobjednik:
							{{ $match->winner->first_name }}
						</p>
					</li>
				@endforeach
			</ul>
		@else
			<h3>Nije odigran nijedan meč</h3>

		@endif
	@endif
</div>

@stop
