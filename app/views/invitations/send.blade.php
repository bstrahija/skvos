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

		@if ($invitations->isEmpty())
			<h4>Sve pozivnice su već poslane</h4>
			<p>Za ponovo slanje kliknite <a href="{{ url('invitations/resend/'.$event->id) }}">ovdje</a>.</p>
			<br><br><br>
		@else
			<h4>Pozivnice će biti poslane na:</h4>

			<ul class="no-style">
				@foreach ($invitations as $invitation)
					<li>
						{{ $invitation->user->full_name }} <strong>&lt;{{ $invitation->user->email }}&gt;</strong>
					</li>
				@endforeach
			</ul>

			<div class="form-actions">
				<hr>
				<a href="#" class="button button-circle button-action button-save submit"><i class="icon-envelope"></i></a>
			</div>
		@endif

		<hr>

	{{ Form::close() }}

</div>

@stop
