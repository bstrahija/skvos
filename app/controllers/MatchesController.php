<?php namespace App\Controllers;

use App, Events, Input, Matches, Redirect, View;

class MatchesController extends BaseController {

	/**
	 * Edit a match
	 * @param  int $id
	 * @return View
	 */
	public function edit($id)
	{
		$match   = Matches::find($id);
		$event   = Events::find($match->event_id);
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
		if ($match = Matches::update($id, Input::all()))
		{
			Events::update($match->event_id, ['mvp_id' => null]);
			Events::mvp($match->event_id);

			return Redirect::route('events.show', $match->event_id)->withAlertSuccess('Spremljeno.');
		}

		return Redirect::back()->withErrors(Matches::errors());
	}

	/**
	 * Delete a match
	 * @param  int $id
	 * @return Redirect
	 */
	public function destroy($id)
	{
		$match = Matches::find($id);
		Matches::delete($id);

		return Redirect::route('events.show', $match->event_id)->withAlertSuccess('Obrisano.');
	}

}
