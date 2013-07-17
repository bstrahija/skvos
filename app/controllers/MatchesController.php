<?php namespace App\Controllers;

use App\Models\Event, App\Models\Invitation, App\Models\Match, App\Models\User;
use Auth, Input, Notification, Redirect, Request, View;

class MatchesController extends BaseController {

	/**
	 * Restrict access to some methods
	 */
	public function __construct()
	{
		// Protect some methods
		$this->beforeFilter('admin', array('only' => array('create', 'store')));
	}

	/**
	 * Store a new match result
	 * @return Redirect
	 */
	public function store()
	{
		$match = new Match;
		$match->player1_id       = Input::get('player1_id');
		$match->player2_id       = Input::get('player2_id');
		$match->player1_sets_won = Input::get('player1_sets_won');
		$match->player2_sets_won = Input::get('player2_sets_won');
		$match->event_id         = Input::get('event_id');

		// Determine winner
		if ($match->player1_sets_won > $match->player2_sets_won) $match->winner_id = $match->player1_id;
		else                                                     $match->winner_id = $match->player2_id;

		// Save it
		$match->save();

		Notification::success("Meč je uspješno upisan");

		return Redirect::back();
	}

}
