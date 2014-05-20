<?php namespace App\Services;

use Carbon, Config, View;
use App\Models\Comment;

class Notification {

	protected $connection;

	public function __construct()
	{

	}

	public function send($email, $view, $data = [])
	{

	}

	public function sendEventComment($event)
	{
		$now         = Carbon::now();
		$sent        = $event->comments_sent_at;
		$lastComment = Comment::orderBy('created_at', 'desc')->where('event_id', $event->id)->first();

		if ($lastComment and $sent < $lastComment->created_at)
		{
			$oldComments = Comment::where('created_at', '<=', $sent)->orderBy('created_at', 'desc')->where('event_id', $event->id)->take(10)->get();
			$newComments = Comment::where('created_at', '>',  $sent)->orderBy('created_at', 'desc')->where('event_id', $event->id)->get();

			// Prepare data
			$data = [
				'event' => $event,
				'old_comments' => $oldComments,
				'new_comments' => $newComments,
			];

			// Find attendees
			$emails = $event->attendees->lists('email');

			return $this->send($emails, 'emails.comments.summary', $data);
		}
	}

}
