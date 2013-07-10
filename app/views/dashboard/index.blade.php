@extends('_layout.default')

@section('content')

	<div class="dashboard">
		<h2>Termini</h2>

		<hr>

		@if (isset($events) and $events)
			<ul class="panel upcoming">
				@foreach ($events as $event)
					<li>
						<h3><a href="#">{{ $event->title }}</a></h3>
						<h6 class="clearfix">
							{{ $event->period }}

							<span class="people pull-right">
								<i class="icon-thumbs-up"></i> {{ count($event->attendees) }}
								/
								<i class="icon-user"></i> {{ count($event->invitees) }}
							</span>
						</h6>
						<hr>
					</li>
				@endforeach
			</ul>
		@else
			<p class="not-found">Nema nadolazećih termina. <a href="#" class="btn btn-success">Dodaj termin</a></p>
			<hr>
		@endif





		<h2>Prošli Termini</h2>
		<hr>

		@if (isset($past) and $past)
			<ul class="panel past">
				@foreach ($past as $event)
					<li>
						<h3><a href="#">{{ $event->title }}</a></h3>
						<h6 class="clearfix">
							{{ $event->period }}

							<span class="people pull-right">
								<i class="icon-thumbs-up"></i> {{ count($event->attendees) }}
								/
								<i class="icon-user"></i> {{ count($event->invitees) }}
							</span>
						</h6>
						<hr>
					</li>
				@endforeach
			</ul>
		@else
			<p class="not-found">Nema prošlih termina.</p>
			<hr>
		@endif


	</div>

@stop
