@extends('_layout.default')

@section('content')

<div class="form invitations invitations-confirm">
	<h2>Pozivnica za: {{ $invitation->event->title }}</h2>
	<p>Da li dolaziš na termin?</p>
	<br><br>

	{{ Form::open(array('action' => 'App\Controllers\InvitationsController@postConfirm')) }}

		{{ Form::hidden('hash', $hash) }}

		<div class="form-actions">
			<hr>
			<a href="#" class="button button-circle button-action button-yes"><i class="icon-ok-sign"></i></a>
			<a href="#" class="button button-circle button-caution button-no"><i class="icon-remove-sign"></i></a>
		</div>

	{{ Form::close() }}
</div>

<?php
	echo '<pre>'; print_r($invitation->toArray()); echo '</pre>';
	echo '<pre>'; print_r($invitation->event->toArray()); echo '</pre>';
	echo '<pre>'; print_r($invitation->user->toArray()); echo '</pre>';
	echo '<pre>'; print_r($hash); echo '</pre>';
?>

@stop
