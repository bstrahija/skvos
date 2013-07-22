<div class="people">
	@if ($event->invitees)
		<table class="table">
			@if ( ! $event->matches->isEmpty())
				<thead>
					<th colspan="3"></th>
					<th class="res r" scope="col" title="Dobiveni mečevi">M+</th>
					<th class="res r" scope="col" title="Izbubljeni mečevi">M-</th>
					<th class="res r" scope="col" title="Dobiveni setovi">S+</th>
					<th class="res r" scope="col" title="Izbubljeni setovi">S-</th>
				</thead>
			@endif

			<tbody>
				@foreach ($event->invitees as $person)
					<tr class="invitation-status{{ ($person->cancelled) ? '-cancelled' : null; }}{{ ($person->confirmed) ? '-confirmed' : null; }}">
						<!-- Confirmed -->
						<td class="slim">
							@if ($person->confirmed)
								<i class="icon-ok-sign" title="Potvrđen dolazak"></i>
							@elseif ($person->cancelled)
								<i class="icon-minus-sign" title="Otkazan dolazak"></i>
							@else
								<i class="icon-question-sign" title="Nepotvrđen dolazak"></i>
							@endif
						</td>

						<!-- ! Sent invitation -->
						<td class="slim">
							@if ($person->sent)
								<i class="icon-envelope" title="Poslana pozivnica"></i>
							@else
								<i class="icon-envelope-alt" title="Nije poslana pozivnica"></i>
							@endif
						</td>

						<!-- ! Name -->
						<td>{{ $person->full_name }}</td>

						@if ( ! $event->matches->isEmpty())
							<td class="res r" title="Dobiveni mečevi">{{ $event->userWonMatches($person->id) }}</td>
							<td class="res r" title="Izbubljeni mečevi">{{ $event->userLostMatches($person->id) }}</td>
							<td class="res r" title="Dobiveni setovi">{{ $event->userWonSets($person->id) }}</td>
							<td class="res r" title="Izbubljeni setovi">{{ $event->userLostSets($person->id) }}</td>
						@endif
					</tr>
				@endforeach
			</tbody>
		</table>

		@if ($event->userInvitation and ! $event->passed())
			<div class="confirm-tools form clearfix">
				<hr>
				@if ( ! $event->userInvitation->confirmed and  ! $event->userInvitation->cancelled)
					<h5>Potvrda dolaska</h5>
				@elseif ($event->userInvitation->confirmed)
					<h5>Dolazim!</h5>
				@elseif ($event->userInvitation->cancelled)
					<h5>Ne dolazim!</h5>
				@endif

				@if ( ! $event->userInvitation->confirmed)
					{{ Form::open(array('method' => 'put', 'action' => 'App\Controllers\InvitationsController@putConfirm')) }}
						{{ Form::hidden('invitation_id', $event->userInvitation->id) }}
						<a href="#" class="button button-circle button-action button-yes submit" title="Da, potvrdi moj dolazak"><i class="icon-ok-sign"></i></a>
					{{ Form::close() }}
				@endif

				@if ( ! $event->userInvitation->cancelled)
					{{ Form::open(array('method' => 'delete', 'action' => 'App\Controllers\InvitationsController@deleteConfirm')) }}
						{{ Form::hidden('invitation_id', $event->userInvitation->id) }}
						<a href="#" class="button button-circle button-caution button-no submit" title="Ne, otkaži"><i class="icon-remove-sign"></i></a>
					{{ Form::close() }}
				@endif
			</div>
		@endif

		@if (User::isAdmin() and $event->date >= Carbon::now()->format('Y-m-d'))
			<div class="send-tools form clearfix">
				<hr>
				<h5>Pozivnice / Izmjena</h5>

				<a href="{{ url('invitations/resend', $event->id) }}" class="button button-circle button-royal pull-right" title="Pošalji svima"><i class="icon-envelope-alt"></i></a>
				<a href="{{ url('invitations/send', $event->id) }}" class="button button-circle button-primary pull-left" title="Pošalji svima kojima nije poslano"><i class="icon-envelope"></i></a>

				<a href="{{ route('events.edit', $event->id) }}" class="button button-circle button-caution"><i class="icon-pencil"></i></a>
			</div>
		@endif
	@endif
</div>

<hr>
