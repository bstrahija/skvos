@if ( ! $event->matches->isEmpty())
	<div class="event-overview">
		<h3>Pregled</h3>

		<table class="table">
			<thead>
				<tr>
					<th scope="col"><i class="icon-user"></i></th>
					<th scope="col" title="Dobiveni mečevi">M+</th>
					<th scope="col" title="Izbubljeni mečevi">M-</th>
					<th scope="col" title="Dobiveni setovi">S+</th>
					<th scope="col" title="Izbubljeni setovi">S-</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($event->attendees as $user)
					<tr>
						<th scope="row">{{ $user->full_name }}</th>
						<td title="Dobiveni mečevi">{{ $event->userWonMatches($user->id) }}</td>
						<td title="Izbubljeni mečevi">{{ $event->userLostMatches($user->id) }}</td>
						<td title="Dobiveni setovi">{{ $event->userWonSets($user->id) }}</td>
						<td title="Izbubljeni setovi">{{ $event->userLostSets($user->id) }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>

	<hr>
@endif
