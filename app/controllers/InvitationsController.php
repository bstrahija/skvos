<?php namespace App\Controllers;

use App, Auth, Events, Input, Invitations, Mailer, Redirect, Users, View;

class InvitationsController extends BaseController {

	/**
	 * Init
	 */
	public function __construct()
	{
		$this->beforeFilter('admin', ['only' => ['presend', 'send']]);
	}

	/**
	 * Update data for an invitation
	 * @param  int $id
	 * @return Redirect
	 */
	public function update($id)
	{

	}

	/**
	 * Show template before sending invites
	 * @param  int $eventId
	 * @return View
	 */
	public function presend($eventId)
	{
		$event = Events::find($eventId);

		return View::make('invitations.presend', compact('event'));
	}

	/**
	 * Send invitations for event
	 * @param  int $eventId
	 * @return Redirect
	 */
	public function send($eventId)
	{
		$sent = Mailer::sendEventInvitations($eventId, Input::get('users'));

		return Redirect::route('events.show', $eventId)->withAlertSuccess('Poslano '.$sent.' pozivnica.');
	}

	/**
	 * Show view for confirming invitation
	 * @param  string $hash
	 * @return View
	 */
	public function preconfirm($hash)
	{
		$invitation = Invitations::findByHash($hash);

		if ($invitation)
		{
			$user = Users::find($invitation->user_id);

			// Login the user
			if ($user and $user->role == 'player')
			{
				Auth::loginUsingId($invitation->user_id);
			}

			return View::make('invitations.preconfirm', compact('invitation'));
		}

		App::abort(404);
	}

	/**
	 * Confirm invitation
	 * @param  string $hash
	 * @return View
	 */
	public function confirm($hash)
	{
		$invitation = Invitations::findByHash($hash);

		if ($invitation)
		{
			if (Input::get('action') == 'cancel')
			{
				Invitations::cancel($invitation->id);
				$message = 'Hvala, tvoj dolazak je otkazan.';
			}
			else
			{
				Invitations::confirm($invitation->id);
				$message = 'Hvala, tvoj dolazak je potvrđen.';
			}

			return Redirect::back()->withAlertSuccess($message);
		}

		App::abort(404);
	}

}
