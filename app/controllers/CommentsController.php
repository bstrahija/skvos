<?php namespace App\Controllers;

use Comments, Events, Input, Notification, Response, Stats, View;

class CommentsController extends BaseController {

	public function items($eventId)
	{
		$event = Events::find($eventId);

		return View::make('events.comment_items')->withEvent($event);
	}

	public function create($eventId)
	{
		$event = Events::find($eventId);

		Notification::gtalkComment('Neki komentar', $eventId);

		echo '<pre>'; print_r(var_dump($event)); echo '</pre>';
	}

}
