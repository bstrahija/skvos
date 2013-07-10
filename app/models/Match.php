<?php namespace App\Models;

use Eloquent;

class Match extends Eloquent {

	protected $table = 'matches';

	public function event()
	{
		return $this->belongsTo('App\Models\Event');
	}

}
