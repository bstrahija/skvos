@extends('_layout.default')

@section('content')

<div class="form invitations invitations-confirm">
	<?php $date = strtotime($invitation->event->date); ?>
	<?php $time = date('H:i', strtotime($invitation->event->from)); ?>

	<h3>Potvrda dolaska</h3>
	<h2>Pozivnica za: {{ $invitation->event->title }}</h2>
	<h5>Na dan: <em>{{ strftime('%A', $date) }}, {{ date('d.m.', $date) }}</em> u <em>{{ $time }}</em></h5>

	@include('_partial.notifications')

	<hr>

	<p>Bok, {{ $invitation->user->first_name }}</p>

	@if ($invitation->confirmed)
		<p style="color: #1a6;">Tvoj dolazak je potvrđen</p>
		<p>Želiš li ipak otkazati dolazak?</p>
	@elseif ($invitation->cancelled)
		<p style="color: #c23;">Tvoj dolazak je otkazan.</p>
		<p>Želiš li ipak doći?</p>
	@else
		<p>Da li dolaziš na termin?</p>
	@endif

	<br>

	{{ Form::open(array('action' => 'App\Controllers\InvitationsController@putConfirm', 'method' => 'put')) }}

		{{ Form::hidden('hash', $hash) }}

		<div class="form-actions">
			@if ( ! $invitation->confirmed)
				<a href="#" class="button button-circle button-action button-yes" title="Da, potvrdi moj dolazak"><i class="icon-ok-sign"></i></a>
			@endif

			@if ( ! $invitation->cancelled)
				<a href="#" class="button button-circle button-caution button-no" title="Ne, otkaži"><i class="icon-remove-sign"></i></a>
			@endif
		</div>

		<hr>

	{{ Form::close() }}
</div>

@stop
