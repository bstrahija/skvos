<?php namespace App\Models;

use Eloquent;

class Match extends Eloquent {

	protected $table = 'matches';

	/**
	 * Related events
	 * @return mixed
	 */
	public function event()
	{
		return $this->belongsTo('App\Models\Event');
	}

	public function playerOne()
	{
		return $this->belongsTo('App\Models\User', 'player1_id');
	}

	public function playerTwo()
	{
		return $this->belongsTo('App\Models\User', 'player2_id');
	}

	public function winner()
	{
		return $this->belongsTo('App\Models\User', 'winner_id');
	}

}
