@if ($matches and ! $matches->isEmpty())
	<div class="event-results">
		<h3>Rezultati</h3>

		<table class="table">
			<thead>
				<tr>
					<th scope="col"><i class="icon-user"></i></th>

					@foreach ($matches as $num => $match)
						@if (User::isAdmin())
							<th scope="col"><a href="{{ route('matches.edit', $match->id) }}">{{ $num+1 }}</a>.</th>
						@else
							<th scope="col">{{ $num+1 }}.</th>
						@endif
					@endforeach
				</tr>
			</thead>
			<tbody>
				@foreach ($event->attendees as $user)
					<tr>
						<th scope="row">{{ $user->first_name }}</th>
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
