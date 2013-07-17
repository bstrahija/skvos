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

<hr>

