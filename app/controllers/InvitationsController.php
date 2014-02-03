<?php namespace App\Controllers;

use App, Auth, Input, Mailer, Redirect, View;
use App\Repositories\EventRepository;
use App\Repositories\InvitationRepository;
use App\Repositories\UserRepository;

class InvitationsController extends BaseController {

	/**
	 * Event repository
	 * @var EventRepository
	 */
	protected $events;

	/**
	 * Invitation repository
	 * @var InvitationRepository
	 */
	protected $invitations;

	/**
	 * User repository
	 * @var UserRepository
	 */
	protected $users;

	/**
	 * Init dependencies
	 * @param EventRepository $events
	 */
	public function __construct(InvitationRepository $invitations, EventRepository $events, UserRepository $users)
	{
		$this->events      = $events;
		$this->invitations = $invitations;
		$this->users       = $users;

		// Filters
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
		$event = $this->events->find($eventId);

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
		$invitation = $this->invitations->findByHash($hash);

		if ($invitation)
		{
			$user = $this->users->find($invitation->user_id);

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
		$invitation = $this->invitations->findByHash($hash);

		if ($invitation)
		{
			if (Input::get('action') == 'cancel')
			{
				$this->invitations->cancel($invitation->id);
				$message = 'Hvala, tvoj dolazak je otkazan.';
			}
			else
			{
				$this->invitations->confirm($invitation->id);
				$message = 'Hvala, tvoj dolazak je potvrđen.';
			}

			return Redirect::back()->withAlertSuccess($message);
		}

		App::abort(404);
	}

}
