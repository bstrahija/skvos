@extends('_layout.default')

@section('content')

<div class="users form">
	<h3>Izmijeni korisnika</h3>

	@include('_partial.notifications')

	{{ Form::open(array('route' => 'users.store')) }}

		<div class="control-group">
			<label for="email" class="control-label">Email</label>
			<div class="controls">
				{{ Form::text('email') }}
			</div>
		</div>

		<div class="row">
			<div class="span6">
				<div class="control-group">
					<label for="first_name" class="control-label">Ime</label>
					<div class="controls">
						{{ Form::text('first_name') }}
					</div>
				</div>
			</div>

			<div class="span6">
				<div class="control-group">
					<label for="last_name" class="control-label">Prezime</label>
					<div class="controls">
						{{ Form::text('last_name') }}
					</div>
				</div>
			</div>
		</div>

		<div class="control-group">
			<label for="password" class="control-label">Lozinka</label>
			<div class="controls">
				{{ Form::text('password', false) }}
			</div>
		</div>

		<div class="control-group">
			<label for="role" class="control-label">Prava</label>
			<div class="controls">
				{{ Form::select('role', array('player' => 'Igrač', 'admin' => 'Administrator', 'superadmin' => 'Superadmin')) }}
			</div>
		</div>

		<div class="form-actions">
			<hr>
			<a href="#" class="button button-circle button-action button-save submit"><i class="icon-cloud-upload"></i></a>
		</div>

	{{ Form::close() }}
</div>

@stop
