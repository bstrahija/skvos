@extends('_layout.master')

@section('page_title') Statistika @stop

@section('main')

<div class="stats row">

	<h2 class="pg">
		<i class="fi-graph-bar"></i> Statistika
	</h2>

	<hr>

	<table>
		<thead>
			<tr>
				<th class="l">{{ icn('torso') }}</th>
				<th title="Mečevi" class="r">Mečevi</th>
				<th title="Setovi" class="r">Setovi</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($leaderboard as $user)
				@if ($user->matches_played > 5)
					<tr>
						<td class="l"><a href="{{ route('showcase', strtolower($user->nickname)) }}">{{ $user->nickname }}</a></td>

						<td class="r">
							<strong>{{ ($user->matches_played) ? number_format(($user->matches_won / $user->matches_played) * 100, 2) : 0 }}%</strong><br>
							{{ (int) $user->matches_won }} /
							{{ (int) $user->matches_played }}
						</td>

						<td class="r">
							<strong>{{ ($user->sets_played) ? number_format(($user->sets_won / $user->sets_played) * 100, 2) : 0 }}%</strong><br>
							{{ (int) $user->sets_played }} /
							{{ (int) $user->sets_won }}
						</td>
					</tr>
				@endif
			@endforeach
		</tbody>
	</table>

	<hr>

	<div class="button-actions">
		<a href="{{ route('stats.players') }}" class="button round small">{{ icn('torsos') }} Odnos između igrača</a>
	</div>

	<hr>

</div>

@stop
