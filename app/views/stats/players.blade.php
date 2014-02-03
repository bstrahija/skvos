@extends('_layout.master')

@section('page_title') Statistika @stop

@section('main')

<div class="stats row">

	<h2 class="pg">
		{{ icn('graph-bar') }} Statistika
	</h2>

	<hr>

	{{ Form::open(['route' => 'stats.players', 'method' => 'get']) }}
		<ul class="small-block-grid-2 medium-block-grid-3 player-picker">
			@foreach ($players as $player)
				<li>
					<input type="checkbox" name="players[]" value="{{ $player->id }}" id="players_{{ $player->id }}" {{ in_array($player->id, (array) Input::get('players')) ? ' checked="checked"' : null }}>
					<label for="players_{{ $player->id }}">{{ $player->nickname }}</label>
				</li>
			@endforeach
		</ul>

		<hr>

		<div class="button-actions">
			<button type="submit" class="button small round">Prikaži</button>
		</div>
	{{ Form::close() }}

	<hr>

	@if (isset($player_stats) and $player_stats)
		@foreach ($player_stats as $stats)
			<?php //echo '<pre>'; print_r(var_dump($stats)); echo '</pre>'; ?>

			<table>
				<thead>
					<tr>
						<th class="l">{{ $stats[0]['stats']->nickname }}</th>
						<th title="Mečevi" class="r">Mečevi</th>
						<th title="Setovi" class="r">Setovi</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$mp = 0; $mw = 0; $ml = 0; $me = 0;
						$sp = 0; $sw = 0; $sl = 0; $se = 0;
					?>

					@foreach ($stats as $stat)
						<tr>
							<td><i style="color: #aaa; font-size: 10px;">vs</i> {{ $stat['opponent']->nickname }}</td>
							<td class="r">
								<strong>{{ ($stat['stats']->matches_played) ? number_format(($stat['stats']->matches_won / $stat['stats']->matches_played) * 100, 2) : 0 }}%</strong><br>
								{{ (int) $stat['stats']->matches_won }} /
								{{ (int) $stat['stats']->matches_played }}
							</td>

							<td class="r">
								<strong>{{ ($stat['stats']->sets_played) ? number_format(($stat['stats']->sets_won / $stat['stats']->sets_played) * 100, 2) : 0 }}%</strong><br>
								{{ (int) $stat['stats']->sets_won }} /
								{{ (int) $stat['stats']->sets_played }}
							</td>
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
						<th class="l">Total</th>
						<th class="r">
							<strong style="color: rgba(100,255,100,.7);">{{ ($mp) ? number_format(($mw / $mp) * 100, 2) : 0 }}%</strong><br>
							{{ $mw }} / {{ $mp }}
						</th>

						<th class="r">
							<strong style="color: rgba(100,255,100,.5);">{{ ($sp) ? number_format(($sw / $sp) * 100, 2) : 0 }}%</strong><br>
							{{ $sw }} / {{ $sp }}
						</th>
					</tr>
				</tbody>
			</table>

			<hr><br>
		@endforeach
	@else

		<p class="not-found">{{ icn('alert') }} Nema statistike. <br>Probaj ponovno odabrati igrače.</p>

	@endif

</div>

@stop
