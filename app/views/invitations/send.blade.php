@extends('_layout.default')

@section('content')

<div class="form invitations">
	<h3>Slanje pozivnica</h2>

	@include('_partial.notifications')

	{{ Form::open(array('action' => 'App\Controllers\InvitationsController@postSend')) }}
		{{ Form::hidden('event_id', $event->id) }}
		{{ Form::hidden('all', $all) }}

		<h2>Termin: {{ $event->title }}</h3>
		<hr>
		<h4>Pozivnice će biti poslane na:</h4>

		<ul class="no-style">
			@foreach ($event->invitees as $invitee)
				@if ( ! $invitee->sent or $all)
					<li>
						{{ $invitee->full_name }} <strong>&lt;{{ $invitee->email }}&gt;</strong>
					</li>
				@endif
			@endforeach
		</ul>

		<div class="form-actions">
			<hr>
			<a href="#" class="button button-circle button-action button-save submit"><i class="icon-envelope"></i></a>
		</div>

	{{ Form::close() }}

</div>

@stop