<div class="event-overview">
	<h3>Pregled</h3>

	<table class="table">
		<thead>
			<tr>
				<th><i class="icon-user"></i></th>
				<th title="Dobiveni mečevi">M+</th>
				<th title="Izbubljeni mečevi">M-</th>
				<th title="Dobiveni setovi">S+</th>
				<th title="Izbubljeni setovi">S-</th>
				<th title="Pive">P</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($event->attendees as $user)
				<tr>
					<td>{{ $user->full_name }}</td>
					<td title="Dobiveni mečevi">{{ $event->userWonMatches($user->id) }}</td>
					<td title="Izbubljeni mečevi">{{ $event->userLostMatches($user->id) }}</td>
					<td title="Dobiveni setovi">{{ $event->userWonSets($user->id) }}</td>
					<td title="Izbubljeni setovi">{{ $event->userLostSets($user->id) }}</td>
					<td title="Pive">-</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>

<hr>


<!--
<ul>
	@foreach ($event->attendees as $user)
		<li>
			<h4>
				{{ $user->full_name }}
				<em>je dobio {{ $event->userWonSets($user->id) }} setova i {{ $event->userWonMatches($user->id) }} mečeva</em>
			</h4>
		</li>
	@endforeach
</ul>
-->
