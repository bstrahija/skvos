@extends('_layout.default')

@section('content')

	<h3 class="c">Mečevi i setovi</h3>
	<hr>

	{{ Form::open(array('route' => 'stats.players', 'method' => 'get', 'style' => 'text-align: center;')) }}
		<br>

		{{ Form::select('player1', $users->lists('first_name', 'id'), Input::get('player1')) }}

		<p>Vs</p>

		{{ Form::select('player2', $player_select, Input::get('player2')) }}

		<p>Vs</p>

		{{ Form::select('player3', $player_select, Input::get('player3')) }}

		<p>Vs</p>

		{{ Form::select('player4', $player_select, Input::get('player4')) }}

		<br>
		<button type="submit" class="button button-rounded button-action button-save submit">Prikaži</button>

	{{ Form::close() }}

	<hr>

	@if (isset($player_stats) and $player_stats)
		@foreach ($player_stats as $stats)
			<?php //echo '<pre>'; print_r(var_dump($stats)); echo '</pre>'; ?>

			<table class="table" style="text-align: center;">
				<thead>
					<tr>
						<th>{{ $stats[0]['stats']->first_name }}</th>
						<th title="Matches played / Odigrani mečevi">MP</th>
						<th title="Matches won / Dobiveni mečeva">MW</th>
						<th title="Matches lost / Izgubljeni mečevi">ML</th>
						<th title="Match efficiency / Efikasnost">ME</th>

						<th title="Sets played / Odigrani setovi">SP</th>
						<th title="Sets won / Dobiveni setovi">SW</th>
						<th title="Sets lost / Izgubljeni setovi">SL</th>
						<th title="Set efficiency / Efikasnost">SE</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$mp = 0; $mw = 0; $ml = 0; $me = 0;
						$sp = 0; $sw = 0; $sl = 0; $se = 0;
					?>

					@foreach ($stats as $stat)
						<tr>
							<td><i style="color: #aaa; font-size: 10px;">vs</i> {{ $stat['opponent']->first_name }}</td>
							<td>{{ (int) $stat['stats']->matches_played }}</td>
							<td style="color: #0a0;"><strong>{{ (int) $stat['stats']->matches_won }}</strong></td>
							<td style="color: #c00;">{{ (int) $stat['stats']->matches_played - $stat['stats']->matches_won }}</td>
							<td>{{ ($stat['stats']->matches_played) ? round($stat['stats']->matches_won / $stat['stats']->matches_played, 3) * 100 : 0 }}%</td>

							<td>{{ (int) $stat['stats']->sets_played }}</td>
							<td style="color: #0a0;">{{ (int) $stat['stats']->sets_won }}</td>
							<td style="color: #c00;">{{ (int) $stat['stats']->sets_played - $stat['stats']->sets_won }}</td>
							<td>{{ ($stat['stats']->sets_played) ? round($stat['stats']->sets_won / $stat['stats']->sets_played, 3) * 100 : 0 }}%</td>
						</tr>

						<?php
							$mp += $stat['stats']->matches_played;
							$mw += $stat['stats']->matches_won;
							$ml += ((int) $stat['stats']->matches_played - $stat['stats']->matches_won);

							$sp += $stat['stats']->sets_played;
							$sw += $stat['stats']->sets_won;
							$sl += ((int) $stat['stats']->sets_played - $stat['stats']->sets_won);
						?>

					@endforeach

					<tr>
						<th>Total</th>
						<th>{{ $mp }}</th>
						<th>{{ $mw }}</th>
						<th>{{ $ml }}</th>
						<th>{{ ($mp) ? round($mw / $mp, 3) * 100 : 0 }}%</th>

						<th>{{ $sp }}</th>
						<th>{{ $sw }}</th>
						<th>{{ $sl }}</th>
						<th>{{ ($sp) ? round($sw / $sp, 3) * 100 : 0 }}%</th>
					</tr>
				</tbody>
			</table>

			<hr><br>
		@endforeach
	@else
		<br>
		<p>Nema statistike</p>
		<br><br><br>
		<hr>
	@endif




	<p style="text-align: center;"><a href="{{ route('stats') }}" class="button button-success">Odnos između svih igrača</a></p>

	<br><hr>

@stop
