<table class="stats-table">
	<tbody>
		<tr>
			<th>MVP:</th>
			<td>
				{{ $stats->mvp_count }} put(a)
				<em>Najbolji igrač termina</em>
			</td>
		</tr>

		<tr>
			<th>Mečevi:</th>
			<td>
				{{ number_format($stats->match_efficiency, 1, ",", null) }}%
				<em>Dobivenih <strong>{{ $stats->matches_won }}</strong> od <strong>{{ $stats->matches_played }}</strong> mečeva</em>
			</td>
		</tr>

		@if ($rival)
			<tr>
				<th>Rival:</th>
				<td>
					{{ $rival->full_name }}
					<span>(
						<strong>{{ $rival->efficiency_against }}%</strong> &mdash;
						<strong>{{ $rival->won_against }}</strong>/<strong>{{ $rival->played_against }}</strong> dobivenih
					)</span>
					<em>Najviše odigranih mečeva protiv ovog igrača</em>
				</td>
			</tr>
		@endif

		<tr>
			<th>Sets:</th>
			<td>
				{{ number_format($stats->set_efficiency, 1, ",", null) }}%
				<em>Dobivenih <strong>{{ $stats->sets_won }}</strong> od <strong>{{ $stats->sets_played }}</strong> setova</em>
			</td>
		</tr>
		<tr>
			<th>Posjećenost:</th>
			<td>
				{{ $stats->events_attendance }}%
				<em>Igrač je bio na <strong>{{ $stats->events_attended }}</strong> od <strong>{{ $stats->events_invited }}</strong> termina na koje je pozvan</em>
			</td>
		</tr>
	</tbody>
</table>
