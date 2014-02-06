<div>
	<h3 class="clearfix row">
		<div class="columns">
			@if (role('admin'))
				<a href="{{ route('events.edit', $event->id) }}" class="button round right">{{ icn('trophy') }}</a>
			@endif

			<a href="{{ route('events.show', $event->id) }}" class="toggle t">{{ $event->title }}</a>
		</div>
	</h3>
	<h6 class="clearfix">
		<div class="row">
			<div class="columns small-8"><a href="{{ route('events.show', $event->id) }}" class="toggle t">{{ $event->period }}</a></div>

			<div class="columns small-4">
				<span class="stats right">
					<a href="#" data-reveal-id="event-attendance-popup-{{ $event->id }}" data-ajax="false" data-reveal>
						<span class="attending-count">{{ icn('like') }}</i> {{ count($event->attendees) }}</span>
						/
						<span class="invited-count">{{ icn('torso') }}</i> {{ count($event->invitees) }}</span>
					</a>
				</span>
			</div>

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

							{{ $invitee->nickname }}
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

		@if ($event->to < Carbon::now())
			<div class="row columns">
				@if ($event->mvp)
					<strong class="mvp">{{ icn('trophy') }}</i> MVP : {{ $event->mvp->nickname }}</strong>
				@else
					<strong class="mvp no"><em>No MVP selected</em></strong>
				@endif
			</div>
		@endif

	</h6>
</div>
