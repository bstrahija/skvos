@extends('_layout.master')

@section('page_title') Login @stop

@section('body_class') auth @stop

@section('main')
	<div class="login">
		{{ Form::open(['route' => 'login.attempt', 'method' => 'post']) }}
			<h1>Skvosh.in</h1>

			<div class="row">
				<div class="large-10 small-10 small-offset-1"><input type="email" name="email" value="{{ Input::old('email') }}" placeholder="{{ trans('messages.Email') }}"></div>
			</div>
			<div class="row">
				<div class="large-10 small-10 small-offset-1"><input type="password" name="password" value="" placeholder="{{ trans('messages.Password') }}"></div>
			</div>

			<div class="row actions">
				<button type="submit" class="button round">{{ trans('messages.Login') }}</button>
			</div>
		{{ Form::close() }}

		<p class="copy">
			<a href="http://creolab.hr" target="_blank">&copy; 2014 Skvoš &amp; Beer inc.</a>
		</p>
	</div>
@stop
