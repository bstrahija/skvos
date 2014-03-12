@extends('_layout.master')

@section('page_title') Moja Statistika @stop

@section('main')

<div class="stats row">

	<h2 class="pg">
		{{ icn('graph-bar') }} Statistika
		<em class="right"><a href="{{ route('showcase', strtolower(Auth::user()->nickname)) }}">{{ Auth::user()->nickname }}</a></em>
	</h2>

	<hr>

	<canvas id="chart-320" width="320" height="200"></canvas>
	<canvas id="chart-640" width="640" height="200"></canvas>

	<hr>

</div>

@stop
