@extends('_layout.master')

@section('page_title') Profil @stop

@section('main')

<div class="page users">

	<h2 class="pg">
		{{ icn('torsos') }} Igrači
		<em class="right"><a href="{{ route('users.create') }}" class="button tiny round success">{{ icn('plus') }} Dodaj</a></em>
	</h2>

	<hr>

	<table class="user-table">
		<tbody>
			@foreach ($users as $user)
				<tr>
					<td>
						<a href="{{ route('users.edit', $user->id) }}">{{ $user->first_name }} {{ $user->last_name }}</a>
					</td>
					<td class="fade s">
						<a href="{{ route('users.edit', $user->id) }}">&lt;{{ $user->email }}&gt;</a>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>

</div>

@stop
