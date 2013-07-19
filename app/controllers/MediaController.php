<?php namespace App\Controllers;

use App\Models\Media, App\Models\Event;
use Auth, DB, Image, Input, Notification, Redirect, Request, Str, Validator, View;

class MediaController extends BaseController {

	public function index()
	{
		echo '<pre>'; print_r(var_dump(Media::all())); echo '</pre>';
	}

	public function store()
	{
		$resource      = Input::get('resource');
		$resource_id   = Input::get('resource_id');
		$resource_path = $resource . '/' . $resource_id;
		$resource_type = Input::get('resource_type');
		$redirect      = Input::get('redirect', route('dashboard'));
		$path          = Image::upload(Input::file('image'), $resource_path, true);

		// Save media
		$media                = new Media;
		$media->author_id     = Auth::user()->id;
		$media->path          = $path;
		$media->mediable_id   = $resource_id;
		$media->mediable_type = $resource_type;
		$media->save();

		Notification::success('Slika je spremljena');

		return Redirect::to($redirect);
	}

}
