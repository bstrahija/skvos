@extends('_layout.default')

@section('content')

<div class="matches">

	@include('_partial.notifications')

	<div class="event-match-add form">

		<h3>Izmijeni meč</h3>

		{{ Form::model($match, array('method' => 'put', 'route' => array('matches.update', $match->id))) }}
			<table class="table">
				<thead>
					<tr>
						<th class="l">Igrač 1</th>
						<th class="c"><i class="icon-trophy"></i> P1</th>
						<th class="c">P2 <i class="icon-trophy"></i></th>
						<th class="r">Igrač 2</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="l player">
							{{ Form::select('player1_id', $match->event->attendees->lists('first_name', 'id')) }}
						</td>

						<td class="l score">
							{{ Form::select('player1_sets_won', $scores) }}
						</td>


						<td class="l score">
							{{ Form::select('player2_sets_won', $scores) }}
						</td>

						<td class="r player">
							{{ Form::select('player2_id', $match->event->attendees->lists('first_name', 'id')) }}
						</td>
					</tr>
				</tbody>
			</table>

			<div class="form-actions">
				<a href="#" class="button button-circle button-action submit"><i class="icon-trophy"></i></a>
			</div>

		{{ Form::close() }}

	</div>

	<hr>

</div>

@stop
