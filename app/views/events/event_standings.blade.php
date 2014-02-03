@if ($event->show_results)
	<h3 class="pg">Pregled</h3>
	<hr>

	<table>
		<thead>
			<th class="l"><i class="fi-torso"></i></th>
			<th class="r">Mečevi</th>
			<th class="r">Setovi</th>
			<th class="r">Bodovi</th>
		</thead>
		<tbody>
			<?php $num = 1; ?>
			@foreach ($leaderboard as $key => $player)

				<tr>
					<td>
						{{ $num }}.
						{{ $player->nickname }}
					</td>
					<td class="r">
						<strong>{{ $player->stats->match_efficiency }}%</strong><br>
						{{ $player->stats->matches_won }}/{{ $player->stats->matches_played }}
					</td>
					<td class="r">
						<strong>{{ $player->stats->set_efficiency }}%</strong><br>
						{{ $player->stats->sets_won }}/{{ $player->stats->sets_played }}
					</td>
					<td class="r"><strong>{{ number_format($player->points, 2) }}</td>

					<?php $num++; ?>
				</tr>

			@endforeach
		</tbody>
	</table>
@endif
