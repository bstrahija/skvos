<?php namespace App\Models;

use Carbon\Carbon, Eloquent;

class Invitation extends Eloquent {

	protected $table = 'invitations';

	/**
	 * Related users attending the event
	 * @return mixed
	 */
	public function attendees()
	{
		return $this->belongsTo('App\Models\User')->where('confirmed', 1);
	}

	/**
	 * Related users invited to the event
	 * @return mixed
	 */
	public function invitees()
	{
		return $this->belongsTo('App\Models\User');
	}

}
