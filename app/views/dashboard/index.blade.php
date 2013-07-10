@extends('_layout.default')

@section('content')

	<div class="dashboard">
		<h2>Termini</h2>

		@if (isset($events) and $events)
			<ul class="panel upcoming">
				@foreach ($events as $event)
					<li>
						<h3><a href="#">{{ $event->title }}</a></h3>
						<h6>{{ $event->from }}</h6>

						<!-- <h4>Invited</h4>

						@if ($event->invitees)
							<ul>
								@foreach ($event->invitees as $invitee)
									<li>{{ $invitee->fullName }}</li>
								@endforeach
							</ul>
						@endif -->
					</li>
				@endforeach
			</ul>
		@else
			<p class="not-found">Nema nadolazećih termina. <a href="#" class="btn btn-success">Dodaj termin</a></p>
		@endif

		<h2>Prošli Termini</h2>

		@if (isset($past) and $past)
			<ul class="panel past">
				@foreach ($past as $event)
					<li>
						<h3><a href="#">{{ $event->title }}</a></h3>

						<!-- <h4>Attended</h4>

						@if ($event->attendees)
							<ul>
								@foreach ($event->attendees as $attendee)
									<li>{{ $attendee->fullName }}</li>
								@endforeach
							</ul>
						@endif -->
					</li>
				@endforeach
			</ul>
		@else
			<p class="not-found">Nema prošlih termina.</p>
		@endif
	</div>

@stop
