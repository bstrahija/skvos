@foreach ($event->comments as $comment)
	<li>
		<em>
			@if ($comment->author->photo)
				<div class="photo" style="background-image: url({{ Image::thumb('/' . $comment->author->photo, 50) }});"></div>
			@else
				<div class="photo" style="background-image: url({{ Image::thumb('/storage/avatars/avatar_dummy.png', 50) }});"></div>
			@endif

			<b>{{ $comment->author->nickname }}</b>:
		</em>

		<span>{{ $comment->text }}</span>
	</li>
@endforeach
