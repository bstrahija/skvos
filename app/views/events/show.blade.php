@extends('_layout.default')

@section('content')

<div class="matches">
	<?php $from = Carbon::now()->addHours(2); ?>
	<?php $now  = Carbon::now(); ?>

	@include('_partial.notifications')

	@if ($event->from > $from)
		<h3 class="c">Termin još nije održan</h3>
		<br><br><br><br><br><br><br><br><br>

		<hr>

	@else
		@if ($from >= $event->fromDate and $now->format('Y-m-d') <= $event->toDate->addDay()->format('Y-m-d'))
			@if ($now >= $event->fromDate and $now <= $event->toDate)
				<h3>Termin je u tijeku</h3>
			@elseif ($from >= $event->fromDate and $now <= $event->toDate)
				<h3>Termin počinje u {{ $event->fromDate->format('H:i') }}</h3>
			@else
				<h3>Termin je održan jučer</h3>
			@endif
			<hr>

			@include('events._partial.add_match')

		@endif

		@include('events._partial.overview')

		@include('events._partial.results_alt')

		@include('events._partial.results')

		@include('events._partial.media')

	@endif

</div>

@stop
