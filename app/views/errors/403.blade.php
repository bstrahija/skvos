@extends('_layout.master')

@section('page_title') Greška 403 @stop

@section('main')

<div class="page error-page">

	<h2 class="pg">
		{{ icn('alert') }} Greška 403
	</h2>

	<hr>

	<p class="not-found">Zabranjen pristup</p>

</div>

@stop
