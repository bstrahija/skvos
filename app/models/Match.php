<?php namespace App\Models;

class Match extends \Eloquent {

	/**
	 * Related event
	 * @return mixed
	 */
	public function event()
	{
		return $this->belongsTo('App\Models\Event');
	}

	/**
	 * Player 1 relation
	 * @return mixed
	 */
	public function player1()
	{
		return $this->belongsTo('App\Models\User', 'player1_id');
	}

	/**
	 * Player 2 relations
	 * @return mixed
	 */
	public function player2()
	{
		return $this->belongsTo('App\Models\User', 'player2_id');
	}

	/**
	 * Winner relations
	 * @return mixed
	 */
	public function winner()
	{
		return $this->belongsTo('App\Models\User', 'winner_id');
	}

}

