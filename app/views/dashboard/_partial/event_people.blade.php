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
	@endif
</div>

<hr>
