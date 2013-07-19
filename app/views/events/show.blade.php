@extends('_layout.default')

@section('content')

<div class="matches">
	<?php $now = Carbon::now()->format('Y-m-d H:i:s'); ?>

	@include('_partial.notifications')

	@if ($event->from > $now)
		<h3 class="c">Termin još nije održan</h3>
		<br><br><br><br><br><br><br><br><br>

		<hr>

	@else
		@if ($now >= $event->from and $now <= $event->to)

			<h3>Termin je u tijeku</h3>

			@include('events._partial.add_match')

		@endif


		@include('events._partial.overview')

		@include('events._partial.results')

	@endif


	@if (User::isAdmin())
		<h3>Slike</h3>
		<br>

		{{ Form::open(array('route' => 'media.store', 'files' => true)) }}
			{{ Form::hidden('resource', 'events') }}
			{{ Form::hidden('resource_id', $event->id) }}
			{{ Form::hidden('resource_type', 'App\Models\Event') }}
			{{ Form::hidden('redirect', route('events.show', $event->id)) }}

			<input type="file" name="image" accept="image/*" capture="camera">
			<button type="submit" class="button button-action button-rounded">Upload</button>
		{{ Form::close() }}


		@if ( ! $event->media->isEmpty())
			<ul class="thumbnails">
				@foreach ($event->media as $item)
					<li class="span3">
						<a href="{{ Image::resize($item->path, 800, 800) }}" class="thumbnail lightbox">
							<img data-src="holder.js/100x100" src="{{ Image::thumb($item->path, 100) }}" alt="">
						</a>
					</li>
				@endforeach
			</ul>
		@endif

		<hr>
	@endif

</div>

@stop
