@extends('_layout.default')

@section('content')

<div class="users">
	<h3>
		<a href="{{ route('users.create') }}" class="button button-rounded button-tiny button-action pull-right"><i class="icon-plus-sign"></i> Novi korisnik</a>
		Korisnici
	</h3>

	<hr>

	<table class="table">
		<thead>
			<tr>
				<th>Name</th>
				<th>Email</th>
				<th><i class="icon-cog"></i></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($users as $user)
				<tr>
					<td><a href="{{ route('users.edit', $user->id) }}">{{ $user->full_name }}</a></td>
					<td>{{ $user->email }}</td>
					<td>-</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>

@stop
