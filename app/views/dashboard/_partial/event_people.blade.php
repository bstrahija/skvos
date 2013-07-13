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
