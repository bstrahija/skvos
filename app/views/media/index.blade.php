@extends('_layout.default')

@section('content')

<table class="table">
	<thead>
		<tr>
			<th>Path</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($media as $item)
			<tr>
				<td>{{ $item->path }}</td>
			</tr>
		@endforeach
	</tbody>
</table>

@stop
