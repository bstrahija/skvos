@if ($matches and ! $matches->isEmpty())
	<div class="event-results">
		<h3>Mečevi</h3>

		<table class="table">
			<thead>
				<tr>
					<th scope="col" class="c"><i class="icon-user"></i></th>
					<th scope="col" class="c">Results</th>
					<th scope="col" class="slim r"><i class="icon-cog"></i></th>
				</tr>
			</thead>
			<tbody>
				@foreach ($event->matches as $num => $match)
					<tr class="match-result">
						<td class="player">
							{{ $num + 1 }}. <strong class="{{ $match->winner->id ==  $match->player_one->id ? 'winner' : null }}">{{ $match->player_one->first_name }} </strong>
							<em>Vs.</em>
							<strong class="{{ $match->winner->id ==  $match->player_two->id ? 'winner' : null }}">{{ $match->player_two->first_name }} </strong>
						</td>

						<td class="c result">
							{{ Form::selectRange('player1_sets_won', 1, 20, $match->player1_sets_won) }}
							:
							{{ Form::selectRange('player2_sets_won', 1, 20, $match->player2_sets_won) }}
						</td>

						<td class="slim r"><i class="icon-save"></i></td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>

	<hr>
@endif
