@extends('_layout.master')

@section('page_title') Moja Statistika @stop

@section('main')

<div class="stats row">

	<h2 class="pg">
		{{ icn('graph-bar') }} Statistika
		<em class="right"><a href="{{ route('showcase', strtolower(Auth::user()->nickname)) }}">{{ Auth::user()->nickname }}</a></em>
	</h2>

	<hr>

	@include('stats.my_table')

	<hr>

	<div class="button-actions">
		<a href="{{ route('stats') }}" class="button round small">{{ icn('graph-bar') }} Ukupna statistika</a>
	</div>

	<hr>

</div>

@stop
