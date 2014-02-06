@if ($event->show_results)
	<h3 class="pg">Pregled</h3>
	<hr>

	<table>
		<thead>
			<th class="l">{{ icn('torso') }}</th>
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


	<hr>

	<div class="button-actions">
		<a href="https://twitter.com/intent/tweet?text={{ urlencode('Squash rezultati za: '.$event->title.' #squash #skvoshin') }}&amp;url={{ urlencode(route('events.public.stats', $event->hash)) }}" class="button tiny round" data-ajax="false" target="_blank">{{ icn('social-twitter') }} Tweet</a>
		&nbsp;&nbsp;
		<a href="http://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('events.public.stats', $event->hash)) }}" class="button tiny round" data-ajax="false" target="_blank">{{ icn('social-facebook') }} Like</a>
	</div>

	<hr>

	@include('events.comments')

	<hr>

@endif
