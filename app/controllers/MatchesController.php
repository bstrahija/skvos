<?php namespace App\Controllers;

use App, Input, Redirect, View;
use App\Repositories\MatchRepository;
use App\Repositories\EventRepository;

class MatchesController extends BaseController {

	/**
	 * Match repository
	 * @var MatchRepository
	 */
	protected $matches;

	/**
	 * Event repo
	 * @var EventRepository
	 */
	protected $events;

	/**
	 * Init dependencies
	 * @param MatchRepository $matches
	 * @param EventRepository $events
	 */
	public function __construct(MatchRepository $matches, EventRepository $events)
	{
		$this->matches = $matches;
		$this->events  = $events;
	}

	/**
	 * Edit a match
	 * @param  int $id
	 * @return View
	 */
	public function edit($id)
	{
		$match   = $this->matches->find($id);
		$event   = $this->events->find($match->event_id);
		$players = $event->attendees;

		return View::make('matches.edit', compact('match', 'event', 'players'));
	}

	/**
	 * Update a match
	 * @param  int $id
	 * @return Redirect
	 */
	public function update($id)
	{
		if ($match = $this->matches->update($id, Input::all()))
		{
			return Redirect::route('events.show', $match->event_id)->withAlertSuccess('Spremljeno.');
		}

		return Redirect::back()->withErrors($this->matches->errors());
	}

	/**
	 * Delete a match
	 * @param  int $id
	 * @return Redirect
	 */
	public function destroy($id)
	{
		$match = $this->matches->find($id);
		$this->matches->delete($id);

		return Redirect::route('events.show', $match->event_id)->withAlertSuccess('Obrisano.');
	}

}
