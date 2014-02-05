@extends('_layout.master')

@section('page_title') Statistika @stop

@section('main')

<div class="stats page row">

	<h2 class="pg">
		{{ icn('graph-bar') }} Statistika
	</h2>

	<hr>

	{{ Form::open(['route' => 'stats.players', 'method' => 'get']) }}
		<div class=" columns">
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

			<br><br>
		</div>
	{{ Form::close() }}


	@if (isset($player_stats) and $player_stats)
		<hr>
		<table>
			<thead>
				<tr>
					<th class="l"></th>
					<th title="Mečevi" class="r">Mečevi</th>
					<th title="Setovi" class="r">Setovi</th>
				</tr>
			</thead>

			@foreach ($player_stats as $stats)
				<thead>
					<tr style="border-top: 1px solid rgba(255,255,255,.1); border-bottom: 1px solid rgba(255,255,255,.1);">
						<th class="l"><a href="#" class="inter-player-toggle" data-toggle="{{ $stats[0]['stats']->id }}">{{ $stats[0]['stats']->nickname }}</a></th>
						<td class="r total-matches-text-target">
							<strong style="color: rgba(100,255,100,.7);">0%</strong><br>
							0 / 0
						</td>
						<td class="r total-sets-text-target">
							<strong style="color: rgba(100,255,100,.7);">0%</strong><br>
							0 / 0
						</td>
					</tr>
				</thead>
				<tbody>
					<?php
						$mp = 0; $mw = 0; $ml = 0; $me = 0;
						$sp = 0; $sw = 0; $sl = 0; $se = 0;
					?>

					@foreach ($stats as $stat)
						<tr class="inter-player inter-player-{{ $stats[0]['stats']->id }}">
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

					<tr style="display: none;">
						<th class="l"></th>
						<th class="r total-matches-text">
							<strong style="color: rgba(100,255,100,.7);">{{ ($mp) ? number_format(($mw / $mp) * 100, 2) : 0 }}%</strong><br>
							{{ $mw }} / {{ $mp }}
						</th>

						<th class="r total-sets-text">
							<strong style="color: rgba(100,255,100,.5);">{{ ($sp) ? number_format(($sw / $sp) * 100, 2) : 0 }}%</strong><br>
							{{ $sw }} / {{ $sp }}
						</th>
					</tr>
				</tbody>
			@endforeach
		</table>

		<br><br><br>
	@else
		<hr>

		<p class="not-found">{{ icn('alert') }} Nema statistike. <br>Probaj ponovno odabrati igrače.</p>

	@endif

</div>

@stop
