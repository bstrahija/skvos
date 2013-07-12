@extends('_layout.default')

@section('content')

	<div class="form">
		<h2>Izmijeni termin</h2>

		@include('_partial.notifications')

		{{ Form::model($event, array('route' => array('events.update', $event->id), 'method' => 'put')) }}

			<div class="control-group">
				<label for="title" class="control-label">Title</label>
				<div class="controls">
					{{ Form::text('title', null, array('class' => 'title')) }}
				</div>
			</div>

			<div class="control-group">
				<label for="date" class="control-label">Datum</label>
				<div class="controls">
					<select name="date" id="date" class="select2">
						@for ($days = 0; $days <= 60; $days++)
							<option value="{{ Carbon::now()->addDays($days)->format('Y-m-d') }}" <?php echo ($event->date == Carbon::now()->addDays($days)->format('Y-m-d')) ? 'selected="selected"' : '' ?>>
								{{ Carbon::now()->addDays($days)->format('d.m.Y. l') }}
							</option>
						@endfor
					</select>
				</div>
			</div>

			<div class="control-group">
				<label for="time" class="control-label">Vrijeme</label>
				<div class="controls">
					<select name="from" id="from" class="select2">
						@for ($hours = 0; $hours <= 23; $hours++)
							<option value="{{ $hours }}:00" <?php echo (date('H:i', strtotime($event->from)) == $hours.':00') ? 'selected="selected"' : ''; ?>>{{ $hours }}:00</option>
							<option value="{{ $hours }}:30" <?php echo (date('H:i', strtotime($event->from)) == $hours.':30') ? 'selected="selected"' : ''; ?>>{{ $hours }}:30</option>
						@endfor
					</select>

					<br><br>
					<select name="to" id="to" class="select2" placeholder="Test 123">
						@for ($hours = 0; $hours <= 23; $hours++)
							<option value="{{ $hours }}:00" <?php echo (date('H:i', strtotime($event->to)) == $hours.':00') ? 'selected="selected"' : ''; ?>>{{ $hours }}:00</option>
							<option value="{{ $hours }}:30" <?php echo (date('H:i', strtotime($event->to)) == $hours.':30') ? 'selected="selected"' : ''; ?>>{{ $hours }}:30</option>
						@endfor
					</select>
				</div>
			</div>

			<div class="control-group">
				<label for="players" class="control-label">Igrači</label>
				<div class="controls">
					<select name="players[]" id="players" class="multiselect" multiple>
						@foreach ($users as $user)
							<option value="{{ $user->id }}" <?php echo ($event->isUserInvited($user->id)) ? 'selected="selected"' : '' ?>>{{ $user->full_name }}</option>
						@endforeach
					</select>
				</div>
			</div>

			<div class="control-group">
				<label for="players" class="control-label">Potvrde</label>
				<div class="controls attendance">
					<table class="table">
						<thead>
							<tr>
								<th><i class="icon-check-sign"></i></th>
								<th>Igrač</th>
								<th><i class="icon-thumbs-up"></i> / <i class="icon-thumbs-down"></i></th>
							</tr>
						</thead>
						<tbody>
							@foreach ($invitees as $user)
								<?php $status = $event->isUserConfirmed($user->id) ? 'confirmed' : 'unknown'; ?>
								<?php $status = $event->isUserCancelled($user->id) ? 'cancelled' : $status; ?>

								<tr class="status status-{{ $status }}">
									<td class="status"><i class="icon-check-sign"></i></td>
									<td>{{ $user->full_name }}</td>
									<td><select name="attendance[{{ $user->id }}]" id="attendance" style="font-size: 11px; height: 130%;">
										<option value="">Neizjašnjen</option>
										<option value="confirmed" <?php echo ($event->isUserConfirmed($user->id)) ? 'selected="selected"' : '' ?>>Dolazi</option>
										<option value="cancelled" <?php echo ($event->isUserCancelled($user->id)) ? 'selected="selected"' : '' ?>>Ne dolazi</option>
									</select></td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>

			<div class="form-actions">
				<hr>
				<a href="#" class="button button-circle button-action button-save submit"><i class="icon-cloud-upload"></i></a>
			</div>

		{{ Form::close() }}
	</div>

@stop
