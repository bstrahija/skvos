@extends('_layout.default')

@section('content')

	<div class="dashboard">
		<h2>Slijedeći termin</h2>
		<hr>

		@if (isset($event) and ! $event->isEmpty())
			<ul class="panel upcoming">
				<li>
					<h3>
						<a href="{{ route('events.show', $event->id) }}" class="button button-circle button-action button-tiny pull-right"><i class="icon-trophy"></i></a>
						@if (Auth::user()->role == 'admin')
							<a href="{{ route('events.edit', $event->id) }}" class="button button-circle button-caution button-tiny pull-right"><i class="icon-pencil"></i></a>
						@endif
						<a href="{{ route('events.show', $event->id) }}" class="toggle t">{{ $event->title }}</a>
					</h3>
					<h6 class="clearfix">
						{{ $event->period }}

						<span class="stats pull-right">
							<i class="icon-thumbs-up"></i> {{ count($event->attendees) }}
							/
							<i class="icon-user"></i> {{ count($event->invitees) }}
						</span>
					</h6>

					<div class="people">
						@if ($event->invitees)
							<table class="table">
								<tbody>
									@foreach ($event->invitees as $person)
										<tr>
											<td class="slim">
												@if ($person->confirmed)
													<i class="icon-ok-sign"></i>
												@else
													<i class="icon-minus-sign"></i>
												@endif
											</td>
											<td>{{ $person->full_name }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						@endif
					</div>

					<hr>
				</li>
			</ul>
		@else
			<p class="not-found"><i class="icon-warning-sign"></i> Nema termina</p>
			<hr>
		@endif

		@if (Auth::user()->role == "admin")
			<div class="add-event">
				<a href="{{ route('events.create') }}" class="button button-circle button-action"><i class="icon-plus"></i></a>
			</div>
		@endif




		<h2>Budući termini</h2>
		<hr>

		@if (isset($events) and ! $events->isEmpty())
			<ul class="panel upcoming">
				@foreach ($events as $event)
					<li>
						<h3>
							<a href="{{ route('events.show', $event->id) }}" class="button button-circle button-action button-tiny pull-right"><i class="icon-trophy"></i></a>
							@if (Auth::user()->role == 'admin')
								<a href="{{ route('events.edit', $event->id) }}" class="button button-circle button-caution button-tiny pull-right"><i class="icon-pencil"></i></a>
							@endif
							<a href="{{ route('events.show', $event->id) }}" class="toggle t">{{ $event->title }}</a>
						</h3>
						<h6 class="clearfix">
							{{ $event->period }}

							<span class="stats pull-right">
								<i class="icon-thumbs-up"></i> {{ count($event->attendees) }}
								/
								<i class="icon-user"></i> {{ count($event->invitees) }}
							</span>
						</h6>

						<div class="people">
							@if ($event->invitees)
								<table class="table">
									<tbody>
										@foreach ($event->invitees as $person)
											<tr>
												<td class="slim">
													@if ($person->confirmed)
														<i class="icon-ok-sign"></i>
													@else
														<i class="icon-minus-sign"></i>
													@endif
												</td>
												<td>{{ $person->full_name }}</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							@endif
						</div>

						<hr>
					</li>
				@endforeach
			</ul>
		@else
			<p class="not-found"><i class="icon-warning-sign"></i> Nema nadolazećih termina</p>
			<hr>
		@endif






		<h2>Prošli Termini</h2>
		<hr>

		@if (isset($past) and ! $past->isEmpty())
			<ul class="panel past">
				@foreach ($past as $event)
					<li>
						<h3>
							<a href="{{ route('events.show', $event->id) }}" class="button button-circle button-primary button-tiny pull-right"><i class="icon-trophy"></i></a>
							@if (Auth::user()->role == 'admin')
								<a href="{{ route('events.edit', $event->id) }}" class="button button-circle button-caution button-tiny pull-right"><i class="icon-pencil"></i></a>
							@endif
							<a href="{{ route('events.show', $event->id) }}" class="toggle t">{{ $event->title }}</a>
						</h3>
						<h6 class="clearfix">
							{{ $event->period }}

							<span class="stats pull-right">
								<i class="icon-thumbs-up"></i> {{ count($event->attendees) }}
								/
								<i class="icon-user"></i> {{ count($event->invitees) }}
							</span>
						</h6>

						<div class="people">
							@if ($event->invitees)
								<table class="table">
									<tbody>
										@foreach ($event->invitees as $person)
											<tr>
												<td class="slim">
													@if ($person->confirmed)
														<i class="icon-ok-sign"></i>
													@else
														<i class="icon-minus-sign"></i>
													@endif
												</td>
												<td>{{ $person->full_name }}</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							@endif
						</div>

						<hr>
					</li>
				@endforeach
			</ul>
		@else
			<p class="not-found"><i class="icon-warning-sign"></i> Nema prošlih termina</p>
			<hr>
		@endif


	</div>

@stop
