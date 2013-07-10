<?php namespace App\Models;

use Carbon\Carbon, Eloquent;

class Event extends Eloquent {

	protected $table = 'events';

	/**
	 * Related users attending the event
	 * @return mixed
	 */
	public function attendees()
	{
		return $this->belongsToMany('App\Models\User', 'invitations')->where('confirmed', 1);
	}

	/**
	 * Related users invited to the event
	 * @return mixed
	 */
	public function invitees()
	{
		return $this->belongsToMany('App\Models\User', 'invitations');
	}

	/**
	 * Related matches
	 * @return mixed
	 */
	public function matches()
	{
		return $this->hasMany('App\Models\Match');
	}

	/**
	 * Only upcoming events
	 * @param  object $query
	 * @return object
	 */
	public function scopeUpcoming($query)
	{
		return $query->where('date', '>=', Carbon::today()->format('Y-m-d'));
	}

	/**
	 * Only past events
	 * @param  object $query
	 * @return object
	 */
	public function scopePast($query)
	{
		return $query->where('date', '<', Carbon::today()->format('Y-m-d'));
	}

}
