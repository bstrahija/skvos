<?php namespace App\Controllers;

use App\Models\Event, App\Models\Invitation, App\Models\Match, App\Models\User;
use Input, Notification, Redirect, Request, View;

class EventsController extends BaseController {

	public function __construct()
	{
		// Protect some methods
		$this->beforeFilter('admin', array('only' => array('create', 'store', 'edit', 'update')));
	}

	/**
	 * List of all events
	 * @return View
	 */
	public function index()
	{
		echo "Index";
		die();
	}

	/**
	 * Create new event
	 * @return View
	 */
	public function create()
	{
		return View::make('events.create', array(
			'users' => User::orderBy('first_name')->get(),
		));
	}

	/**
	 * Store new event
	 * @return Redirect
	 */
	public function store()
	{
		// First save the event
		$event = new Event;
		$event->title = Input::get('title');
		$event->date  = Input::get('date');
		$event->from  = Input::get('date') . ' ' . Input::get('from');
		$event->to    = Input::get('date') . ' ' . Input::get('to');
		$event->save();

		// Then create invitations
		foreach (Input::get('players') as $player)
		{
			$invitation = new Invitation;
			$invitation->user_id  = (int) $player;
			$invitation->event_id = (int) $event->id;
			$invitation->save();
		}

		Notification::success('Termin je spremljen.');

		return Redirect::route('dashboard');
	}

	/**
	 * Edit an event
	 * @param  int $id
	 * @return View
	 */
	public function edit($id)
	{
		// Get event data with some preloaded relations
		$event = Event::find($id);

		return View::make('events.edit', array(
			'event'    => $event,
			'users'    => User::orderBy('first_name')->get(),
			'invitees' => $event->invitees,
		));
	}

	/**
	 * Update existing event
	 * @param  int $id
	 * @return Redirect
	 */
	public function update($id)
	{
		$event = Event::find($id);
		$event->title = Input::get('title');
		$event->date  = Input::get('date');
		$event->from  = Input::get('date') . ' ' . Input::get('from');
		$event->to    = Input::get('date') . ' ' . Input::get('to');
		$event->save();

		// Now the players
		$players = Input::get('players');

		// Remove some
		foreach ($event->invitees as $invitee)
		{
			// Detach
			if ( ! in_array($invitee->id, $players)) $event->invitees()->detach($invitee->id);
		}

		// Add some
		foreach ($players as $player)
		{
			if ( ! $event->isUserInvited($player))
			{
				$invitation = new Invitation;
				$invitation->user_id  = (int) $player;
				$invitation->event_id = (int) $event->id;
				$invitation->save();
			}
		}

		// Attendance
		foreach (Input::get('attendance') as $userId => $attendance) {
			$invitation = Invitation::where('event_id', $id)->where('user_id', $userId)->first();

			if ($invitation) {
				$invitation->confirmed = ($attendance == 'confirmed') ? 1 : 0;
				$invitation->cancelled = ($attendance == 'cancelled') ? 1 : 0;
				$invitation->save();
			}
		}

		Notification::success('Termin je spremljen.');

		return Redirect::route('events.edit', $id);
	}

}
