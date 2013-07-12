@extends('_layout.default')

@section('content')

<div class="matches">
	<h2>Pregled</h2>

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

	<h2>Mečevi</h2>

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
</div>

@stop
