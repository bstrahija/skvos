@extends('_layout.master')

@section('page_title') Termini @stop

@section('main')

	<div class="events">
		<h2 class="pg">{{ icn('trophy') }} Slijedeći termin</h2><hr>

		@if (isset($event) and $event)
			<ul class="event-list upcoming">
				<li>
					@include('events.list_item')
				</li>
			</ul>
		@else
			<p class="not-found">{{ icn('alert') }} Nema termina</p>
		@endif

		@if (role('admin'))
			<div class="add-event">
				<a href="{{ route('events.create') }}" class="button success round">{{ icn('plus') }}</a>
			</div>
		@endif


		<hr>

		<!-- ! Upcoming -->

		<h2 class="pg">{{ icn('calendar') }} Budući termini</h2><hr>

		@if (isset($upcoming) and ! $upcoming->isEmpty())
			<ul class="event-list upcoming">
				@foreach ($upcoming as $event)
					<li>
						@include('events.list_item')
					</li>
				@endforeach
			</ul>
		@else
			<p class="not-found">{{ icn('alert') }} Nema nadolazećih termina <hr></p>

		@endif

		<!-- ! Past -->

		<h2 class="pg">{{ icn('archive') }} Prošli Termini</h2><hr>

		@if (isset($past) and ! $past->isEmpty())
			<ul class="event-list past">
				@foreach ($past as $event)
					<li>
						@include('events.list_item')
					</li>
				@endforeach
			</ul>
		@else
			<p class="not-found">{{ icn('alert') }} Nema prošlih termina</p>
			<hr>
		@endif
	</div>

@stop
