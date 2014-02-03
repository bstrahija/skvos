@extends('_layout.master')

@section('page_title') Dodaj termin @stop

@section('main')

<div class="page event create-event">

	<h2 class="pg">
		{{ icn('trophy') }} Novi termin
		<em class="right"><a href="{{ route('events.index') }}" class="button tiny alert round">{{ icn('arrow-left') }}</a></em>
	</h2>

	<hr>

	{{ Form::open(['route' => 'events.store']) }}

		<div class="row">
			<div class="columns">
				<label for="title">Naziv</label>
				<input type="text" name="title" id="title" placeholder="" value="{{ Input::old('title', 'BEER/SQUASH: '.date('d').'.'.date('m').'.'.date('Y').'.') }}">
			</div>
		</div>

		<div class="row">
			<div class="columns">
				<label for="">Kada?</label>
				<select name="date" id="date">
					@for ($days = 0; $days <= 60; $days++)
						<option value="{{ Carbon::now()->addDays($days)->format('Y-m-d') }}">{{ Carbon::now()->addDays($days)->format('d.m.Y. l') }}</option>
					@endfor
				</select>
			</div>
		</div>

		<div class="row">
			<div class="columns">
				<label for="time">Vrijeme</label>

				<div class="row">
					<div class="columns small-6">
						<select name="from" id="from" class="select2">
							@for ($hours = 0; $hours <= 23; $hours++)
							<option value="{{ $hours }}:00" <?php echo ($hours == '18') ? 'selected="selected"' : '' ?>>{{ $hours }}:00</option>
							<option value="{{ $hours }}:30">{{ $hours }}:30</option>
							@endfor
						</select>
					</div>

					<div class="columns small-6">
						<select name="to" id="to" class="select2" placeholder="Test 123">
							@for ($hours = 0; $hours <= 23; $hours++)
							<option value="{{ $hours }}:00">{{ $hours }}:00</option>
							<option value="{{ $hours }}:30" <?php echo ($hours == '20') ? 'selected="selected"' : '' ?>>{{ $hours }}:30</option>
							@endfor
						</select>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="columns">
				<label for="players">Igrači</label>

				<ul class="small-block-grid-2 medium-block-grid-3 player-picker">
					@foreach ($players as $player)
						<li>
							<input type="checkbox" name="players[]" value="{{ $player->id }}" id="players_{{ $player->id }}"><label for="players_{{ $player->id }}">{{ $player->full_name }}</label>
						</li>
					@endforeach
				</ul>
			</div>
		</div>

		<hr>

		<div class="row actions">
			<button type="submit" class="button round">Kreiraj termin</button>
		</div>

	{{ Form::close() }}

</div>

@stop
