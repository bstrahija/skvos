<h3>
	<a href="{{ route('events.show', $event->id) }}" class="button button-circle button-action button-tiny pull-right"><i class="icon-trophy"></i></a>
	<a href="{{ route('events.show', $event->id) }}" class="toggle t">{{ $event->title }}</a>
</h3>
<h6 class="clearfix">
	{{ $event->period }} <em>by {{ $event->author->full_name }}</em>

	<span class="stats pull-right">
		<i class="icon-thumbs-up"></i> {{ count($event->attendees) }}
		/
		<i class="icon-user"></i> {{ count($event->invitees) }}
	</span>
</h6>
