@extends('_layout.default')

@section('content')

<div class="matches">
	<?php $now = Carbon::now(); ?>

	@include('_partial.notifications')

	@if ($event->from > $now)
		<h3 class="c">Termin još nije održan</h3>
		<br><br><br><br><br><br><br><br><br>

		<hr>

	@else
		@if ($now >= $event->fromDate and $now->format('Y-m-d') <= $event->toDate->addDay()->format('Y-m-d'))
			@if ($now >= $event->fromDate and $now <= $event->toDate)
				<h3>Termin je u tijeku</h3>
			@else
				<h3>Termin je održan jučer</h3>
			@endif
			<hr>

			@include('events._partial.add_match')

		@endif

		@include('events._partial.overview')

		@include('events._partial.results')

		@include('events._partial.media')

	@endif

</div>

@stop
