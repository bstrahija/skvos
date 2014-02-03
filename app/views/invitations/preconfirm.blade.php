@extends('_layout.master')

@section('main')

<div class="page invitations confirm-invitation">

	<h2 class="pg">
		{{ icn('trophy') }} Potvrdi svoj dolazak
	</h2>

	<hr>

	<h3 class="pg">{{ $invitation->event->title }}</h3>

	<h5 class="pg">
		Na dan: <em>{{ $invitation->event->date->formatLocalized('%A') }},
		{{ $invitation->event->date->format('d.m.') }}</em>
		u <em>{{ $invitation->event->from->format('H:i') }}</em>
	</h5>

	<hr>

	<div class="pg">
		<p>
			Bok, {{ $invitation->user->first_name }}<br>

			@if ($invitation->confirmed)
				<span style="color: #1a6;">Tvoj dolazak je potvrđen</span><br>
				Želiš li ipak otkazati dolazak?
			@elseif ($invitation->cancelled)
				<span style="color: #c23;">Tvoj dolazak je otkazan.</span><br>
				Želiš li ipak doći?
			@else
				Da li dolaziš na termin?
			@endif

		</p>
	</div>

	<hr>

	{{ Form::open(['route' => ['invitations.confirm.post', $invitation->hash], 'class' => 'confirmation-form']) }}
		<input type="hidden" name="action" value="confirm">
		<div class="form-actions">
			<div class="button-actions">
				@if ( ! $invitation->confirmed)
					<button class="btn-confirm-invite button round success">{{ icn('like') }}</button>
				@endif

				@if ( ! $invitation->cancelled)
					<button class="btn-cancel-invite button round alert">{{ icn('dislike') }}</button>
				@endif
			</div>
		</div>

	{{ Form::close() }}

	<hr>

</div>

@stop
