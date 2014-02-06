@if ($event->can_enter_match)
	@if ($players and $players->count() > 1)
		{{ Form::open(['route' => 'matches.store', 'class' => 'match-form new-match-form']) }}
			<input type="hidden" name="event_id" value="{{ $event->id }}">

			<h3 class="pg">Novi meč</h3>

			<hr>

			<div class="match-playing row">
				<div class="columns small-6">
					<select name="player1_id" id="player1">
						@foreach ($players as $player)
							<option value="{{ $player->id }}" {{ $player->id == $next_players[0] ? 'selected="selected"' : null }}>{{ $player->nickname }}</option>
						@endforeach
					</select>

					<ul class="button-group round">
						<li><a href="#" class="inc-dec dec button">{{ icn('minus') }}</a></li>
						<li><span class="button secondary res1 res"><input type="text" name="player1_score" class="score" value="0" readonly="readonly"></span></li>
						<li><a href="#" class="inc-dec inc button success">{{ icn('plus') }}</a></li>
					</ul>
				</div>

				<div class="columns small-6">
					<select name="player2_id" id="player1">
						@foreach ($players as $player)
							<option value="{{ $player->id }}" {{ $player->id == $next_players[1] ? 'selected="selected"' : null }}>{{ $player->nickname }}</option>
						@endforeach
					</select>

					<ul class="button-group round right">
						<li><a href="#" class="inc-dec dec button">{{ icn('minus') }}</a></li>
						<li><span class="button secondary res2 res"><input type="text" name="player2_score" class="score" value="0" readonly="readonly"></span></li>
						<li><a href="#" class="inc-dec inc button success">{{ icn('plus') }}</a></li>
					</ul>
				</div>
			</div>

			<hr>

			<div class="row match-add-actions">
				<button type="submit" class="button success round">Dodaj</button>
			</div>
		{{ Form::close() }}

		<hr>

	@endif

@elseif ($event->is_over)

	@include('events.event_mvp')
	<!-- <p class="warning">{{ icn('alert') }} Ne može se unijeti meč jer temin nije počeo ili je već završio.</p> -->

@else

	@include('events.comments')

	<h4 class="pg">
		Temin se održava: {{ $event->period }}.
	</h4><hr>

@endif
