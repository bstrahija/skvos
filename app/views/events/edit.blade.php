@extends('_layout.master')

@section('page_title') Izmijeni termin @stop

@section('main')

	<h2 class="pg">
		{{ icn('trophy') }} Izmijeni termin
		<em class="right"><a href="{{ route('events.index') }}" class="button tiny alert round">{{ icn('arrow-left') }}</a></em>
	</h2>

	<hr>

	{{ Form::open(['route' => ['events.update', $event->id], 'method' => 'put']) }}

		<div class="row">
			<div class="columns">
				<label for="title">Naziv</label>
				<input type="text" name="title" id="title" placeholder="" value="{{ Input::old('title', $event->title) }}">
			</div>
		</div>

		<div class="row">
			<div class="columns">
				<label for="">Kada?</label>
				<select name="date" id="date">
					@for ($days = 0; $days <= 60; $days++)
						<option value="{{ Carbon::now()->addDays($days)->format('Y-m-d') }}" {{ Carbon::now()->addDays($days)->format('Y-m-d') == $event->date->format('Y-m-d') ? 'selected="selected"' : null }}>
							{{ Carbon::now()->addDays($days)->format('d.m.Y. l') }}
						</option>
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
							<option value="{{ $hours }}:00" {{ ($hours == $event->from->format('H'))                                     ? 'selected="selected"' : '' }}>{{ $hours }}:00</option>
							<option value="{{ $hours }}:30" {{ ($hours == $event->from->format('H') and $event->from->format('i') == 30) ? 'selected="selected"' : '' }}>{{ $hours }}:30</option>
							@endfor
						</select>
					</div>

					<div class="columns small-6">
						<select name="to" id="to" class="select2" placeholder="Test 123">
							@for ($hours = 0; $hours <= 23; $hours++)
								<option value="{{ $hours }}:00" {{ ($hours == $event->to->format('H'))                                   ? 'selected="selected"' : '' }}>{{ $hours }}:00</option>
								<option value="{{ $hours }}:30" {{ ($hours == $event->to->format('H') and $event->to->format('i') == 30) ? 'selected="selected"' : '' }}>{{ $hours }}:30</option>
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
					@foreach ($event->invitees as $player)
						<li>
							<input type="checkbox" name="players[]" value="{{ $player->id }}" id="players_{{ $player->id }}" {{ in_array($player->id, $attendee_ids) ? 'checked="checked"' : null }}>
							<label for="players_{{ $player->id }}">{{ $player->full_name }}</label>
						</li>
					@endforeach
				</ul>
			</div>
		</div>

		<hr>

		<div class="row actions">
			<button type="submit" class="button round">Spremi izmjene</button>
		</div>

	{{ Form::close() }}

@stop
