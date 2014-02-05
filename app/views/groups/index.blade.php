@extends('_layout.master')

@section('page_title') Grupe @stop

@section('main')

<div class="stats row">

	<h2 class="pg">
		{{ icn('torsos-all') }} Grupe
	</h2>

	<hr>

	<table>
		<thead>
			<th>Grupa</th>
			<th>{{ icn('torsos-all') }}</th>
		</thead>
		<tbody>
			@foreach ($groups as $group)
				<tr>
					<td>{{ $group->title }} [{{ $group->members->count() }}]</td>
					<td>by {{ $group->owner->full_name }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>

</div>

@stop
