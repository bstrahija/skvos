<?php namespace App\Services;

use Carbon, Config, Log, Mail, URL;
use App\Models\Comment;
use App\Models\Event;
use App\Repositories\EventRepository;
use App\Repositories\InvitationRepository;

class Mailer {

	/**
	 * Invitation repo
	 * @var InvitationRepository
	 */
	protected $invitations;

	/**
	 * Event repository
	 * @var EventRepository
	 */
	protected $events;

	/**
	 * Init dependencies
	 * @param InvitationRepository $invitations
	 * @param EventRepository      $events
	 */
	public function __construct(InvitationRepository $invitations, EventRepository $events)
	{
		$this->invitations = $invitations;
		$this->events      = $events;
	}

	/**
	 * Send invitations for event
	 * @param  int   $eventId
	 * @param  array $userIds
	 * @return int
	 */
	public function sendEventInvitations($eventId, $userIds = null)
	{
		$sent = 0;

		// Get users
		if ( ! $userIds) $invitations = $this->invitations->forEvent($eventId);
		else             $invitations = $this->invitations->forEvent($eventId, $userIds);

		if ($invitations->count())
		{
			foreach ($invitations as $invitation)
			{
				$result = $this->sendInvitation($invitation->id);
				$sent  += $result;
			}
		}

		return $sent;
	}

	/**
	 * Send a single invitation
	 * @param  int $id
	 * @return int
	 */
	public function sendInvitation($id)
	{
		// Invitation data
		$invitation = $this->invitations->find($id);
		$event      = $invitation->event;
		$invitee    = $invitation->user;

		// Email data
		$data = array(
			'confirmation_link' => URL::route('invitations.confirm', $invitation->hash),
			'title'             => $event->title,
			'when'              => $event->date->format('d.m.Y.'),
			'from'              => $event->from->format('H:i'),
			'to'                => $event->to->format('H:i'),
			'day'               => $event->date->formatLocalized('%A'),
		);

		if ($this->allowed($invitee->email))
		{
			$sent = Mail::send('emails.invitations.invitation', $data, function($m) use ($invitee, $event) {
				$m->to($invitee->email);
				$m->subject('Pozivnica za: ' . $event->title);
			});

			if ($sent)
			{
				$this->invitations->update($invitation->id, ['sent' => 1]);
			}

			return $sent;
		}
	}

	/**
	 * Sent notification when user confirms invite
	 * @param  int $id
	 * @return int
	 */
	public function sendConfirmation($id)
	{
		// Invitation data
		$invitation = $this->invitations->find($id);
		$event      = $this->events->find($invitation->event_id);

		// Email data
		$data = array(
			'title' => $event->title,
			'user'  => $invitation->user,
		);

		// Filter emails
		$emails = $this->getAllowed($event->invitees->lists('email'));

		// Send emails
		$sent = Mail::send('emails.invitations.confirm', $data, function($m) use ($invitation, $event, $emails) {
			$m->to(Config::get('mail.from.address'));
			$m->bcc($emails);
			$m->subject('Yeah, ' . $invitation->user->full_name . '" dolazi na termin: "' . $event->title . '"');
		});

		return $sent;
	}

	/**
	 * Sent notification when user cancels invite
	 * @param  int $id
	 * @return int
	 */
	public function sendCancelation($id)
	{
		// Invitation data
		$invitation = $this->invitations->find($id);
		$event      = $this->events->find($invitation->event_id);

		// Email data
		$data = array(
			'title' => $event->title,
			'user'  => $invitation->user,
		);

		// Filter emails
		$emails = $this->getAllowed($event->invitees->lists('email'));

		// Send emails
		$sent = Mail::send('emails.invitations.cancel', $data, function($m) use ($invitation, $event, $emails) {
			$m->to(Config::get('mail.from.address'));
			$m->bcc($emails);
			$m->subject('Oh no, ' . $invitation->user->full_name . '" ne dolazi na termin: "' . $event->title . '"');
		});

		return $sent;
	}

	/**
	 * Send notifications for new comments
	 *
	 * @param  integer $event
	 * @return void
	 */
	public function sendEventCommentNotifications($id)
	{
		$event         = Event::find($id);
		$now           = Carbon::now();
		$sent          = $event->comments_sent_at ?: Carbon::create(1200, 1, 1);
		$lastComment   = Comment::orderBy('created_at', 'desc')->where('event_id', $event->id)->first();
		$minutesPassed = $sent->diffInMinutes($now);
		$targetDelay   = (int) Config::get('mail.comment_notification_delay');

		if ($lastComment and $minutesPassed >= $targetDelay and $sent < $lastComment->created_at)
		{
			$oldComments = Comment::where('created_at', '<=', $sent)->orderBy('created_at', 'asc')->where('event_id', $event->id)->take(10)->get();
			$newComments = Comment::where('created_at', '>',  $sent)->orderBy('created_at', 'asc')->where('event_id', $event->id)->get();

			// Prepare data
			$data = [
				'event' => $event,
				'old_comments' => $oldComments,
				'new_comments' => $newComments,
			];

			// Find attendees and filter 'em
			$emails = $this->getAllowed($event->invitees->lists('email'));

			// Send emails
			$sent = Mail::send('emails.comments.summary', $data, function($m) use ($event, $emails) {
				$m->to(Config::get('mail.from.address'));
				$m->bcc($emails);
				$m->subject('Novi komentari za termin :"' . $event->title . '" [#'.$event->id.']');
			});

			if ($sent)
			{
				Log::debug("[MAILER] Sent ".$sent." comment notifications for event [".$event->id."] to " . @json_encode($emails));
				$event->comments_sent_at = Carbon::now();
				$event->save();
			}
		}
		else
		{
			// Log::debug("[MAILER] No comment notifications sent for event [".$event->id."].");
		}
	}

	/**
	 * Check if allowed to send to this email
	 * @param  string $email
	 * @return bool
	 */
	public function allowed($email)
	{
		if (Config::get('mail.pretend')) return true;

		$whitelist = (array) Config::get('mail.whitelist');
		$blacklist = (array) Config::get('mail.blacklist');

		// Skip
		if ( ! $whitelist and ! $blacklist) return true;

		if (in_array($email, $whitelist) and ! in_array($email, $blacklist))
		{
			return true;
		}

		return false;
	}

	/**
	 * Check if allowed to send to this email, and return the email
	 * @param  array $emails
	 * @return array
	 */
	public function getAllowed($emails)
	{
		if (Config::get('mail.pretend')) return $emails;

		$whitelist = (array) Config::get('mail.whitelist');
		$blacklist = (array) Config::get('mail.blacklist');

		// Skip
		if ( ! $whitelist and ! $blacklist) return $emails;

		// Filter
		$emails = array_diff($emails, $blacklist);
		$emails = array_intersect($emails, $whitelist);

		return $emails;
	}

}
