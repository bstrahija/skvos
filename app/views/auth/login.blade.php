@extends('_layout.auth')

@section('content')

<h1>Skvosh.in</h1>

{{ Form::open(array('route' => 'login.post')) }}

	<div id="login" class="login">
		@if ($errors->has('login'))
			<div class="alert alert-error">{{ $errors->first('login', ':message') }}</div>
		@endif

		<div class="control-group">
			{{ Form::label('email', 'E-mail') }}
			<div class="controls">
				{{ Form::text('email', null, array('placeholder' => 'Email')) }}
			</div>
		</div>

		<div class="control-group">
			{{ Form::label('password', 'Password') }}
			<div class="controls">
				{{ Form::password('password', array('placeholder' => 'Password')) }}
			</div>
		</div>

		<div class="form-actions">
			<button type="submit" class="button glow button-pill button-action btn-login">Login</button>
		</div>
	</div>

{{ Form::close() }}

@stop
