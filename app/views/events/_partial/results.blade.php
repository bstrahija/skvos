@if ($matches and ! $matches->isEmpty())
	<div class="event-results">
		<h3>Rezultati</h3>

		<table class="table">
			<thead>
				<tr>
					<td><i class="icon-user"></i></td>

					@foreach ($matches as $num => $match)
						<td>{{ $num+1 }}.</td>
					@endforeach
				</tr>
			</thead>
			<tbody>
				@foreach ($event->attendees as $user)
					<tr>
						<td>{{ $user->first_name }}</td>
						@foreach ($matches as $match)
							<td>
								@if ($user->id == $match->player1_id)
									{{ $match->player1_sets_won }}
								@elseif ($user->id == $match->player2_id)
									{{ $match->player2_sets_won }}
								@else
									-
								@endif
							</td>
						@endforeach
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>

	<hr>
@endif
