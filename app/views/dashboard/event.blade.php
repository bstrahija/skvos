@if ($event)

	<div class="row event next-event {{
		($invitation and $invitation->confirmed) ? 'event-confirmed' : ''
	}} {{
		($invitation and $invitation->cancelled) ? 'event-cancelled' : ''
	}} {{
		(Carbon::now() > $event->from and Carbon::now() < $event->to) ? 'event-now' : ''
	}}">
		<h2 class="small-3 columns">
			{{ (Carbon::now() > $event->from and Carbon::now() < $event->to) ? 'Upravo:' : 'Uskoro:' }}

			@if ($invitation and ! $invitation->confirmed)
				<div class="confirmation">
					<a href="{{ route('invitations.show', $invitation->id) }}" class="confirm-invitation button success tiny round" data-id="{{ $invitation->id }}">{{ icn('check') }}</a>
				</div>
			@elseif ($invitation and ! $invitation->cancelled)
				<!--<div class="confirmation">
					<span class="cancel-invitation button alert tiny round" data-id="{{ $invitation->id }}">{{ icn('dislike') }}</span>
				</div>-->
			@endif
		</h2>

		<div class="small-9 columns">
			<h3><a href="{{ route('events.show', $event->id) }}">{{ $event->title }}</a></h3>

			<div class="attendance">
				<a href="{{ route('events.show', $event->id) }}">
					<em>
						{{ $event->date->format('d.m.') }} @ {{ $event->from->format('H:i') }}
					</em>
				</a>
				<a href="#" data-reveal-id="event-attendance-popup-{{ $event->id }}" data-reveal>
					<span class="attendees">{{ icn('like') }} {{ count($event->attendees) }}</span> /
					<span class="invitees">{{ icn('torso') }} {{ count($event->invitees) }}</span>
				</a>

				<div id="event-attendance-popup-{{ $event->id }}" class="reveal-modal" data-reveal>
					<h2>Pozvani su:</h2>
					<ul class="invitees">
						@foreach ($event->invitees as $invitee)
							<li class="{{ ($invitee->invitation_confirmed) ? 'confirmed' : ($invitee->invitation_cancelled ? 'cancelled' : '') }}">
								@if ($invitee->invitation_confirmed)
									{{ icn('like') }}
								@elseif ($invitee->invitation_cancelled)
									{{ icn('dislike') }}
								@else
									{{ icn('info') }}
								@endif

								{{ $invitee->full_name }}
							</li>
						@endforeach
					</ul>
					@if (Carbon::now() < $event->to and role('admin'))
						<hr>
						<a href="{{ route('invitations.send', $event->id) }}" class="button tiny round success">{{ icn('mail') }}  Pošalji pozivnice</a>
					@endif

					<a class="close-reveal-modal">&#215;</a>
				</div>
			</div>
		</div>
	</div>

@elseif ($last)

	<div class="row event last-event" data-ajax="true" data-href="{{ route('events.show', $last->id) }}">
		<h2 class="small-3 columns">
			Zadnje:

			@if (role('admin'))
				<div class="confirmation">
					<a href="{{ route('events.create') }}" class="button success tiny round">{{ icn('plus') }}</i></a>
				</div>
			@endif
		</h2>

		<div class="small-9 columns">
			<h3>{{ $last->title }}</h3>

			<div class="attendance">
				@if ($last->mvp)
					MVP : <strong class="mvp">{{ icn('trophy') }} {{ $last->mvp->full_name }}</strong>
				@endif
			</div>
		</div>
	</div>

@else

	<div class="row event">
		<h3 class="no">Nema termina</h3>
	</div>

@endif
