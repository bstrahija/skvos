@extends('_layout.master')

@section('main')

<div class="page invitations send-invitations">

	<h2 class="pg">
		{{ icn('mail') }} Pošalji pozivnice
		<em class="right"><a href="{{ route('events.show', $event->id) }}" class="button tiny alert round">{{ icn('arrow-left') }}</a></em>
	</h2>

	<hr>

	{{ Form::open(['route' => ['invitations.send', $event->id]]) }}

		<table class="">
			<tbody class="invitees-table">
				@foreach ($event->invitees as $user)
					<tr class="{{ ($user->invitation_confirmed) ? 'confirmed' : ($user->invitation_cancelled ? 'cancelled' : '') }}">
						<td class="slim check">
							<input type="checkbox" name="users[]" value="{{ $user->id }}" id="invitation-{{ $user->id }}" {{ $user->invitation_sent ? '' : ' checked="checked"'; }}>
						</td>
						<td>
							<label for="invitation-{{ $user->id }}">
								{{ $user->first_name }} {{ $user->last_name }}
								@if ($user->invitation_sent)
									<small class="sent-indicator">{{ icn('mail') }}</small>
								@endif
							</label>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>

		<hr>

		<div class="button-actions">
			<button type="submit" class="button small round success">{{ icn('mail') }}  Pošalji</button>
		</div>
	{{ Form::close() }}
</div>

@stop
