@if ($event->show_results and $matches->count())
	<div class="event-matches">
		<h3 class="pg">Rezultati</h3>

		<hr>

		@if ($matches)

			<div class="event-results">
				@foreach ($matches as $key => $match)

					<?php
						$sep = null;

						// Thripple event
						if ($event_type == 'tripple' and ($key != 0 and $key % 3 == 0)) $sep = 'sep2';

						// Quadruple event
						if ($event_type == 'quadruple')
						{
							if ($key % 4 == 2) $sep = 'sep';
							if ($key != 0 && $key % 4 == 0) $sep = 'sep3';
						}
					?>

					<div class="row event-result {{ $sep }}">
						<div class="small-9 columns">
							<a href="{{ route('matches.edit', $match->id) }}">
								{{ $key+1 }}.
								<span class="{{ $match->winner_id != $match->player1_id ? 'loser' : 'winner' }}">{{ $match->player1->nickname }}</span>
								Vs.
								<span class="{{ $match->winner_id != $match->player2_id ? 'loser' : 'winner' }}">{{ $match->player2->nickname }}</span>
							</a>
						</div>

						<div class="small-3 columns text-right">
							<a href="{{ route('matches.edit', $match->id) }}"><strong>{{ $match->player1_score }} : {{ $match->player2_score }}</strong></a>
						</div>
					</div>
				@endforeach
			</div>

		@else

			<p class="not-found">{{ icn('alert') }} Nema rezultata.</p>

		@endif
	</div>

	<hr>
@endif
