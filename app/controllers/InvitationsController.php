<?php namespace App\Controllers;

use App\Models\Event, App\Models\Invitation;
use Config, Input, Mail, Notification, Redirect, View, URL;

class InvitationsController extends BaseController {

	/**
	 * Restrict access to some methods
	 */
	public function __construct()
	{
		// Protect some methods
		$this->beforeFilter('auth', array('except' => array('getConfirm', 'putConfirm', 'deleteConfirm')));
	}

	/**
	 * Display presend overview
	 * @param  int $eventId
	 * @return View
	 */
	public function getSend($eventId)
	{
		$event       = Event::find($eventId);
		$invitations = Invitation::notSent()->where('event_id', $event->id)->get();

		return View::make('invitations.send', array(
			'event'       => $event,
			'invitations' => $invitations,
			'all'         => false,
		));
	}

	/**
	 * Display presend overview
	 * @param  int $eventId
	 * @return View
	 */
	public function getResend($eventId)
	{
		$event       = Event::find($eventId);
		$invitations = Invitation::where('event_id', $event->id)->get();

		return View::make('invitations.send', array(
			'event'       => $event,
			'invitations' => $invitations,
			'all'         => true,
		));
	}

	/**
	 * Send out invitations for event
	 * @return Redirect
	 */
	public function postSend()
	{
		$whitelist = Config::get('mail.whitelist');
		$eventId   = Input::get('event_id');
		$event     = Event::find($eventId);
		$sent_to   = array();

		foreach ($event->invitees as $invitee)
		{
			$invitation = Invitation::where('user_id', $invitee->id)->where('event_id', $event->id)->first();

			if (Input::get('all') == 1 or ! $invitation->sent)
			{
				$data = array(
					'confirmation_link' => URL::route('invitations.confirm', $invitation->hash),
					'title'             => $event->title,
				);

				if ( ! $whitelist or in_array($invitee->email, $whitelist))
				{
					Mail::send('emails.events.invitation', $data, function($m) use ($invitee, $event) {
						$m->to($invitee->email);
						$m->subject('Pozivnica za: ' . $event->title);
					});
					$sent_to[] = $invitee->email;
				}

				$invitation->sent = 1;
				$invitation->save();
			}
		}

		if ( ! empty($sent_to)) Notification::success('Pozivnice su poslane na ['.implode(', ', $sent_to).'].');
		else                    Notification::warning('Nijedna pozivnica nije poslana.');

		return Redirect::to('invitations/send/'.$event->id);
	}

	/**
	 * Display invitation confirm screen
	 * @param  string $hash
	 * @return View
	 */
	public function getConfirm($hash)
	{
		$invitation = Invitation::where('hash', $hash)->first();

		return View::make('invitations.confirm', array(
			'hash'       => $hash,
			'invitation' => $invitation,
		));
	}

	/**
	 * Confirm invitation
	 * @param  string $hash
	 * @return Redirect
	 */
	public function putConfirm()
	{
		$hash       = Input::get('hash');
		$invitation = Invitation::where('hash', $hash)->first();
		$invitation->confirmed = 1;
		$invitation->cancelled = 0;
		$invitation->save();

		Notification::success('Uspješno si potvrdio svoj dolazak.');

		return Redirect::action('App\Controllers\InvitationsController@getConfirm', $hash);
	}

	/**
	 * Cancel the invitation
	 * @param  string $hash
	 * @return Redirect
	 */
	public function deleteConfirm()
	{
		$hash       = Input::get('hash');
		$invitation = Invitation::where('hash', $hash)->first();
		$invitation->confirmed = 0;
		$invitation->cancelled = 1;
		$invitation->save();

		Notification::success('Uspješno si otkazao svoj dolazak.');

		return Redirect::action('App\Controllers\InvitationsController@getConfirm', $hash);
	}
}
