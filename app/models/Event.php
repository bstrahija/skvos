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
		return $this->belongsToMany('App\Models\User', 'invitations')->where('confirmed', 1)->orderBy('first_name');
	}

	/**
	 * Related users invited to the event
	 * @return mixed
	 */
	public function invitees()
	{
		return $this->belongsToMany('App\Models\User', 'invitations')->orderBy('first_name')->withPivot('confirmed', 'cancelled');
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
	public function scopeNext($query)
	{
		return $query->where('date', '>=', Carbon::today()->format('Y-m-d'))->orderBy('date', 'desc')->take(1);
	}

	/**
	 * Only upcoming events
	 * @param  object $query
	 * @return object
	 */
	public function scopeUpcoming($query)
	{
		return $query->where('date', '>=', Carbon::today()->format('Y-m-d'))->orderBy('date', 'desc');
	}

	/**
	 * Only past events
	 * @param  object $query
	 * @return object
	 */
	public function scopePast($query)
	{
		return $query->where('date', '<', Carbon::today()->format('Y-m-d'))->orderBy('date', 'desc');
	}

	/**
	 * Return a period
	 * @return string
	 */
	public function getPeriodAttribute()
	{
		return date('d.m. @ H:i', strtotime($this->attributes['from'])) . ' - ' . date('H:i', strtotime($this->attributes['to']));
	}

	/**
	 * Check if user is invited to event
	 * @param  int     $userId
	 * @return boolean
	 */
	public function isUserInvited($userId)
	{
		if ($this->invitees)
		{
			foreach ($this->invitees as $invitee)
			{
				if ($userId == $invitee->id) return true;
			}
		}

		return false;
	}

	/**
	 * Check if user has confirmed attendace
	 * @param  int     $userId
	 * @return boolean
	 */
	public function isUserConfirmed($userId)
	{
		if ($this->invitees)
		{
			foreach ($this->invitees as $invitee)
			{
				if ($userId == $invitee->id and $invitee->confirmed == 1) return true;
			}
		}

		return false;
	}

	/**
	 * Check if user is invited to event
	 * @param  int     $userId
	 * @return boolean
	 */
	public function isUserCancelled($userId)
	{
		if ($this->invitees)
		{
			foreach ($this->invitees as $invitee)
			{
				if ($userId == $invitee->id and $invitee->cancelled == 1) return true;
			}
		}

		return false;
	}

}
