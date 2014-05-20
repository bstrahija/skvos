<?php namespace App\Controllers;

use Comments, Events, Input, Mailer, Notification, Response, Stats, View;

class CommentsController extends BaseController {

	public function items($eventId)
	{
		$event = Events::find($eventId);

		return View::make('events.comment_items')->withEvent($event);
	}

	public function create($eventId)
	{
		return Mailer::sendEventCommentNotifications($eventId);
	}

}
