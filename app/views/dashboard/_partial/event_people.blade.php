<div class="people">
	@if ($event->invitees)
		<table class="table">
			<tbody>
				@foreach ($event->invitees as $person)
					<tr>
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
					</tr>
				@endforeach
			</tbody>
		</table>

		@if ($event->date >= Carbon::now()->format('Y-m-d'))
			<div class="send-tools form clearfix">
				<hr>
				<a href="{{ url('invitations/resend', $event->id) }}" class="button button-circle button-royal pull-right" title="Pošalji svima"><i class="icon-envelope-alt"></i></a>
				<a href="{{ url('invitations/send', $event->id) }}" class="button button-circle button-primary" title="Pošalji svima kojima nije poslano"><i class="icon-envelope"></i></a>
			</div>
		@endif
	@endif
</div>

<hr>
