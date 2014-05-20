<!DOCTYPE html>
<html lang="hr-HR">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h1>Novi komentari za termin "<a href="{{ route('events.show', $event->id) }}">{{ $event->title }}</a>"</h1>

		@if (count($new_comments))
			<table style="color: #272;" border="0">
				@foreach ($new_comments as $comment)
					<tr>
						<td width="10%"><strong>{{ $comment->author->nickname }}:</strong>&nbsp;&nbsp;&nbsp;</td>
						<td>{{ $comment->text }}</td>
					</tr>
				@endforeach
			</table>
		@endif

		<hr>

		@if (count($old_comments))
			<table style="color: #666;" border="0">
				@foreach ($old_comments as $comment)
					<tr>
						<td width="10%"><strong>{{ $comment->author->nickname }}:</strong>&nbsp;&nbsp;&nbsp;</td>
						<td>{{ $comment->text }}</td>
					</tr>
				@endforeach
			</table>
		@endif

	</body>
</html>
