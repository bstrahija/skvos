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
