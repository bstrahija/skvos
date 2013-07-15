<?php namespace App\Models;

use Carbon\Carbon, Eloquent;

class Invitation extends Eloquent {

	protected $table = 'invitations';

	/**
	 * Related event
	 * @return mixed
	 */
	public function event()
	{
		return $this->belongsTo('App\Models\Event');
	}

	/**
	 * Invited user relations
	 * @return mixed
	 */
	public function user()
	{
		return $this->belongsTo('App\Models\User');
	}

	/**
	 * Only sent invitations
	 * @param  Query $query
	 * @return Query
	 */
	public function scopeSent($query)
	{
		return $query->where('sent', 1);
	}

	/**
	 * Only unsent invitations
	 * @param  Query $query
	 * @return Query
	 */
	public function scopeNotSent($query)
	{
		return $query->where('sent', 0);
	}

}
