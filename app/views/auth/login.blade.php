@extends('_layout.default')

@section('content')

<h2>Login</h2>

{{ Form::open(array('route' => 'login.post')) }}

	<div id="login" class="login">
		@if ($errors->has('login'))
			<div class="alert alert-error">{{ $errors->first('login', ':message') }}</div>
		@endif

		<div class="control-group">
			{{ Form::label('email', 'Email') }}
			<div class="controls">
				{{ Form::text('email') }}
			</div>
		</div>

		<div class="control-group">
			{{ Form::label('password', 'Password') }}
			<div class="controls">
				{{ Form::password('password') }}
			</div>
		</div>

		<div class="form-actions">
			{{ Form::submit('Login', array('class' => 'btn btn-inverse btn-login')) }}
		</div>
	</div>

{{ Form::close() }}

@stop
