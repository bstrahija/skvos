@if ($event->can_enter_match)
	@if ($players and $players->count() > 1)
		{{ Form::open(['route' => 'matches.store', 'class' => 'new-match-form']) }}
			<input type="hidden" name="event_id" value="{{ $event->id }}">

			<h3 class="pg">Novi meč</h3>

			<hr>

			<div class="match-playing row">
				<div class="columns small-6">
					<select name="player1_id" id="player1">
						@foreach ($players as $player)
							<option value="{{ $player->id }}" {{ $player->id == $next_match_player_1 ? 'selected="selected"' : null }}>{{ $player->nickname }}</option>
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
							<option value="{{ $player->id }}" {{ $player->id == $next_match_player_2 ? 'selected="selected"' : null }}>{{ $player->nickname }}</option>
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

	<h3 class="pg with-photo text-center">
		@if ($event->mvp)
			@if ($event->mvp->photo)
				<div class="photo" style="background-image: url({{ Image::thumb('/' . $event->mvp->photo, 100) }});"></div>
			@else
				<div class="photo" style="background-image: url({{ Image::thumb('/storage/avatars/avatar_dummy.png', 100) }});"></div>
			@endif<br>

			MVP :
			<strong class="mvp">{{ icn('trophy') }} {{ $event->mvp->full_name }}</strong>
		@else
			Temin je završio.
		@endif
	</h3><hr>

	<!-- <p class="warning">{{ icn('alert') }} Ne može se unijeti meč jer temin nije počeo ili je već završio.</p> -->

@else

	<h4 class="pg">
		Temin se održava: {{ $event->period }}.
	</h4><hr>

@endif
