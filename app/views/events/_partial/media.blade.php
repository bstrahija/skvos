@if ($now >= $event->from)
	<h3>Slike</h3>

	@if ( ! $event->media->isEmpty())
		<ul class="thumbnails">
			@foreach ($event->media as $item)
				<li class="span3">
					<a href="{{ Image::resize($item->path, 800, 800) }}" class="thumbnail lightbox" rel="gallery1">
						<img data-src="holder.js/100x100" src="{{ Image::thumb($item->path, 100) }}" alt="">
					</a>
				</li>
			@endforeach
		</ul>
	@else
		<p>Nema slika</p>
	@endif

	<hr>

	<h3>Dodaj novu sliku</h3>

	{{ Form::open(array('route' => 'media.store', 'files' => true)) }}
		{{ Form::hidden('resource', 'events') }}
		{{ Form::hidden('resource_id', $event->id) }}
		{{ Form::hidden('resource_type', 'App\Models\Event') }}
		{{ Form::hidden('redirect', route('events.show', $event->id)) }}

		@if (is_mobile())
			<div><input type="file" name="image" accept="image/*" capture="camera"></div>
		@else
			<div class="fileupload fileupload-new" data-provides="fileupload">
				<div class="fileupload-preview thumbnail" style="width: 200px; height: 150px; background: #fff;"></div>
				<div>
					<span class="button button-rounded btn-file">
						<span class="fileupload-new">Select image</span>
						<span class="fileupload-exists">Change</span>
						<input type="file" name="image" accept="image/*" capture="camera">
					</span>
					<a href="#" class="button button-caution button-rounded fileupload-exists" data-dismiss="fileupload">Remove</a>
				</div>
			</div>
		@endif

		<button type="submit" class="button button-action button-rounded">Upload</button>
	{{ Form::close() }}




	<hr>
@endif
