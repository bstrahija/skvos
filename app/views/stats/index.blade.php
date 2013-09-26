@extends('_layout.default')

@section('content')

	<h3 class="c">Mečevi i setovi</h3>
	<hr>

	<table class="table" style="text-align: center;">
		<thead>
			<tr>
				<th><i class="icon-user"></i></th>
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
			@foreach ($leaderboard as $user)
				<tr>
					<td>{{ $user->first_name }}</td>
					<td>{{ (int) $user->matches_played }}</td>
					<td style="color: #0a0;"><strong>{{ (int) $user->matches_won }}</strong></td>
					<td style="color: #c00;">{{ (int) $user->matches_played - $user->matches_won }}</td>
					<td>{{ round($user->matches_won / $user->matches_played, 3) * 100 }}%</td>

					<td>{{ (int) $user->sets_played }}</td>
					<td style="color: #0a0;">{{ (int) $user->sets_won }}</td>
					<td style="color: #c00;">{{ (int) $user->sets_played - $user->sets_won }}</td>
					<td>{{ round($user->sets_won / $user->sets_played, 3) * 100 }}%</td>
				</tr>
			@endforeach
		</tbody>
	</table>

	<hr>

@stop
