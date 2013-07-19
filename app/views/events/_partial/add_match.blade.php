@if (User::isAdmin())

	<div class="event-match-add form">

		@if ($event->attendees->isEmpty())

			<h3>Nema prijavljenih igrača</h3>
			<hr>

		@else

			<h3>Dodaj meč</h3>

			{{ Form::open(array('route' => 'matches.store')) }}
				{{ Form::hidden('event_id', $event->id) }}

				<table class="table">
					<thead>
						<tr>
							<th class="l">Igrač 1</th>
							<th class="c"><i class="icon-trophy"></i> P1</th>
							<th class="c">P2 <i class="icon-trophy"></i></th>
							<th class="r">Igrač 2</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="l player"><select name="player1_id" id="player1_id">
								@foreach ($event->attendees as $attendee)
									<option value="{{ $attendee->id }}">{{ $attendee->first_name }}</option>
								@endforeach
							</select></td>

							<td class="l score"><select name="player1_sets_won" id="player1_sets_won">
								@for ($i = 0; $i < 15; $i++)
									<option value="{{ $i }}">{{ $i }}</option>
								@endfor
							</select></td>


							<td class="l score"><select name="player2_sets_won" id="player2_sets_won">
								@for ($i = 0; $i < 15; $i++)
									<option value="{{ $i }}">{{ $i }}</option>
								@endfor
							</select></td>

							<td class="r player"><select name="player2_id" id="player2_id">
								@foreach ($event->attendees as $attendee)
									<option value="{{ $attendee->id }}">{{ $attendee->first_name }}</option>
								@endforeach
							</select></td>
						</tr>
					</tbody>
				</table>

				<div class="form-actions">
					<a href="#" class="button button-circle button-action submit"><i class="icon-trophy"></i></a>
				</div>

			{{ Form::close() }}

			<hr>

		@endif

	</div>

@endif
