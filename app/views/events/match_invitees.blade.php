@if ( ! $event->show_results)
	<h3 class="pg">Pozvani su:</h3>

	<hr>

	<table class="">
		<tbody class="invitees-table">
			@foreach ($invitees as $user)
				<tr class="{{ ($user->invitation_confirmed) ? 'confirmed' : ($user->invitation_cancelled ? 'cancelled' : '') }}">
					<td>
						@if ($user->invitation_confirmed)
							<i class="fi-like confirmed"></i>
						@elseif ($user->invitation_cancelled)
							<i class="fi-prohibited cancelled"></i>
						@else
							<i class="fi-info unknown"></i>
						@endif

						{{ $user->first_name }} {{ $user->last_name }}
					</td>
					<td class="fade s">
						&lt;{{ $user->email }}&gt;
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>

	<hr>

	@if (role('admin'))
		<div class="button-actions">
			<a href="{{ route('invitations.send', $event->id) }}" class="button small round success">{{ icn('mail') }}  Pošalji pozivnice</a>
		</div>

		<hr>
	@endif
@endif
