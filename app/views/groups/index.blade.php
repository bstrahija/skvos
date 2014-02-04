@extends('_layout.master')

@section('page_title') Grupe @stop

@section('main')

<div class="stats row">

	<h2 class="pg">
		{{ icn('torsos-all') }} Grupe
	</h2>

	<hr>

	<?php echo '<pre>'; print_r(var_dump($groups)); echo '</pre>'; ?>

</div>

@stop
