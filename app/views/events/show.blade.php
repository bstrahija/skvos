@extends('_layout.default')

@section('content')

<div class="matches">
	<?php $now = Carbon::now()->format('Y-m-d H:i:s'); ?>

	@if ($event->from > $now)
		<h3 class="c">Termin još nije održan</h3>
		<br><br><br><br><br><br><br><br><br>
		<hr>

	@else
		@if ($now >= $event->from and $now <= $event->to)

			<h3>Termin je u tijeku</h3>

		@else

			@include('events._partial.overview')

			@include('events._partial.results')

		@endif


		@if ($now >= $event->from)

			<!-- @include('events._partial.matches') -->

		@endif

	@endif
</div>

@stop
