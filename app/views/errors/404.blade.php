@extends('_layout.master')

@section('page_title') Greška 404 @stop

@section('main')

<div class="page error-page">

	<h2 class="pg">
		{{ icn('alert') }} Error 404
	</h2>

	<hr>

	<p class="not-found">Nije pronađeno</p>

	<hr>

</div>

@stop
