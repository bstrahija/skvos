<?php namespace App\Models;

use Auth, Carbon\Carbon, Eloquent;

class Event extends Eloquent {

	protected $table = 'events';

	/**
	 * User that created the event
	 * @return mixed
	 */
	public function author()
	{
		return $this->belongsTo('App\Models\User');
	}

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
		return $this->belongsToMany('App\Models\User', 'invitations')->orderBy('first_name')->withPivot('confirmed', 'cancelled', 'sent');
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
		return $query->where('date', '>=', Carbon::now()->format('Y-m-d'))->orderBy('date', 'asc')->withAccess()->take(1);
	}

	/**
	 * Only upcoming events
	 * @param  object $query
	 * @return object
	 */
	public function scopeUpcoming($query)
	{
		return $query->where('date', '>=', Carbon::now()->format('Y-m-d'))->orderBy('date', 'asc')->withAccess();
	}

	/**
	 * Only past events
	 * @param  object $query
	 * @return object
	 */
	public function scopePast($query)
	{
		return $query->where('date', '<', Carbon::now()->format('Y-m-d'))->orderBy('date', 'desc')->withAccess();
	}

	/**
	 * Only the events the user was invited to
	 * @return object
	 */
	public function scopeWithAccess($query)
	{
		if (User::isAdmin()) return $query;

		return $query->select('events.*')->leftJoin('invitations as inv', 'inv.event_id', '=', 'events.id')->where('inv.user_id', Auth::user()->id);
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

	/**
	 * Number of sets the user has won on this event
	 * @param  int  $userId
	 * @return int
	 */
	public function userWonSets($userId)
	{
		$won = 0;

		foreach ($this->matches as $match)
		{
			if ($match->player1_id == $userId) $won += (int) $match->player1_sets_won;
			if ($match->player2_id == $userId) $won += (int) $match->player2_sets_won;
		}

		return (int) $won;
	}

	/**
	 * Number of matches the user has won on this event
	 * @param  int  $userId
	 * @return int
	 */
	public function userWonMatches($userId)
	{
		$won = 0;

		foreach ($this->matches as $match)
		{
			if ($match->winner_id == $userId) $won++;
		}

		return (int) $won;
	}

}
