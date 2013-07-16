@extends('_layout.default')

@section('content')

	<div class="dashboard">

		@include('_partial.notifications')

		<!-- ! Next -->

		<h2>Slijedeći termin</h2><hr>

		@if (isset($event) and $event)
			<ul class="panel upcoming">
				<li>
					@include('dashboard._partial.event_header')

					@include('dashboard._partial.event_people')
				</li>
			</ul>
		@else
			<p class="not-found"><i class="icon-warning-sign"></i> Nema termina</p>
			<hr>
		@endif

		@if (User::isAdmin())
			<div class="add-event">
				<a href="{{ route('events.create') }}" class="button button-circle button-action"><i class="icon-plus"></i></a>
			</div>
		@endif

		<!-- ! Upcoming -->

		<h2>Budući termini</h2><hr>

		@if (isset($events) and ! $events->isEmpty())
			<ul class="panel upcoming">
				@foreach ($events as $event)
					<li>
						@include('dashboard._partial.event_header')

						@include('dashboard._partial.event_people')
					</li>
				@endforeach
			</ul>
		@else
			<p class="not-found"><i class="icon-warning-sign"></i> Nema nadolazećih termina</p>
			<hr>
		@endif

		<!-- ! Past -->

		<h2>Prošli Termini</h2><hr>

		@if (isset($past) and ! $past->isEmpty())
			<ul class="panel past">
				@foreach ($past as $event)
					<li>
						@include('dashboard._partial.event_header')

						@include('dashboard._partial.event_people')
					</li>
				@endforeach
			</ul>
		@else
			<p class="not-found"><i class="icon-warning-sign"></i> Nema prošlih termina</p>
			<hr>
		@endif

	</div>

@stop
