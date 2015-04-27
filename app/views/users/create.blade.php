@extends('_layout.master')

@section('page_title') Profil @stop

@section('main')

<div class="page profile">

	<h2 class="pg">
		{{ icn('torso') }} Novi igrač
		<em class="right"><a href="{{ route('events.index') }}" class="button tiny alert round">{{ icn('arrow-left') }}</a></em>
	</h2>

	<hr>

	{{ Form::open(['route' => ['users.store'], 'files' => true]) }}

		<fieldset>
			<div class="row">
				<div class="columns small-12"><input type="email" name="email" value="{{ Input::old('email') }}" placeholder="Email adresa" required></div>
			</div>

			<div class="row">
				<div class="columns small-6"><input type="text" name="first_name" value="{{ Input::old('first_name') }}" placeholder="Ime" required></div>
				<div class="columns small-6"><input type="text" name="last_name" value="{{ Input::old('last_name') }}" placeholder="Prezime" required></div>
			</div>

			<div class="row">
				<div class="columns small-12"><input type="text" name="nickname" value="{{ Input::old('nickname') }}" placeholder="Nadimak"></div>
			</div>
		</fieldset>

		<hr>

		<fieldset>
			<h3>Slika</h3>
			<div class="row">
				<div class="columns small-3">
					<div class="photo" style="background-image: url({{ Image::thumb('/storage/avatars/avatar_dummy.png', 100) }});"></div>
				</div>
				<div class="columns small-9"><input type="file" name="photo" accept="image/*" capture="camera"></div>
			</div>
		</fieldset>

		<hr>

		<fieldset>
			<h3>Lozinka</h3>
			<div class="row">
				<div class="columns small-6"><input type="password" name="password" value="" placeholder="Lozinka" required></div>
				<div class="columns small-6"><input type="password" name="password_confirmation" value="" placeholder="Potvrdi" required></div>
			</div>
		</fieldset>

		<hr>

		<div class="row actions">
			<button type="submit" class="button round">Kreiraj igrača</button>
		</div>

	{{ Form::close() }}

</div>

@stop
