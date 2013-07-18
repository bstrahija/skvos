@extends('_layout.default')

@section('content')

<div class="form">
	<h2>Novi termin</h2>

	@include('_partial.notifications')

	{{ Form::open(array('route' => 'events.store')) }}

		<div class="control-group">
			<label for="title" class="control-label">Title</label>
			<div class="controls">
				{{ Form::text('title', 'BEER/SQUASH: '.date('d').'.'.date('m').'.2013.', array('class' => 'title')) }}
			</div>
		</div>

		<div class="control-group">
			<label for="date" class="control-label">Datum</label>
			<div class="controls">
				<select name="date" id="date" class="select2">
					@for ($days = 0; $days <= 60; $days++)
						<option value="{{ Carbon::now()->addDays($days)->format('Y-m-d') }}">{{ Carbon::now()->addDays($days)->format('d.m.Y. l') }}</option>
					@endfor
				</select>
			</div>
		</div>

		<div class="control-group">
			<label for="time" class="control-label">Vrijeme</label>
			<div class="controls">
				<select name="from" id="from" class="select2">
					@for ($hours = 0; $hours <= 23; $hours++)
						<option value="{{ $hours }}:00" <?php echo ($hours == '18') ? 'selected="selected"' : '' ?>>{{ $hours }}:00</option>
						<option value="{{ $hours }}:30">{{ $hours }}:30</option>
					@endfor
				</select>

				<br><br>
				<select name="to" id="to" class="select2" placeholder="Test 123">
					@for ($hours = 0; $hours <= 23; $hours++)
						<option value="{{ $hours }}:00">{{ $hours }}:00</option>
						<option value="{{ $hours }}:30" <?php echo ($hours == '20') ? 'selected="selected"' : '' ?>>{{ $hours }}:30</option>
					@endfor
				</select>
			</div>
		</div>

		<div class="control-group">
			<label for="players" class="control-label">Igrači</label>
			<div class="controls">
				<select name="players[]" id="players" class="multiselect" multiple>
					@foreach ($users as $user)
						<option value="{{ $user->id }}">{{ $user->full_name }}</option>
					@endforeach
				</select>
			</div>
		</div>

		<div class="form-actions">
			<hr>
			<a href="#" class="button button-circle button-action button-save submit"><i class="icon-cloud-upload"></i></a>
		</div>

	{{ Form::close() }}
</div>

@stop
