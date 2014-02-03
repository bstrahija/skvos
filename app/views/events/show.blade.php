@extends('_layout.master')

@section('page_title') Termin - {{ $event->title }} @stop

@section('main')

<div class="event">

	<h2 class="pg">
		<em class="right"><a href="{{ route('events.index') }}" class="button tiny alert round">{{ icn('arrow-left') }}</a></em>
		{{ icn('trophy') }} Termin<br>
		<small>{{ $event->title}}</small>
	</h2>

	<hr>

	@if ($players and $players->count() > 1)

		@include('events.match_create')

		@include('events.match_results')

		@include('events.event_standings')

		@include('events.match_invitees')

	@else

		@if (Carbon::now() >= $event->from->subMinutes(30))
			<p class="not-found">{{ icn('alert') }} Nema dovoljno igrača</p>
		@endif

		@include('events.match_create')

		@include('events.match_invitees')

	@endif

</div>

@stop
