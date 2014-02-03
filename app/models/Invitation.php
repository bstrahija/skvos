<?php namespace App\Models;

class Invitation extends \Eloquent {

	/**
	 * Guard fields from mass assignment
	 * @var array
	 */
	protected $guarded = array('id');

	/**
	 * Invited user
	 * @return mixed
	 */
	public function user()
	{
		return $this->belongsTo('App\Models\User');
	}

	/**
	 * Related event
	 * @return mixed
	 */
	public function event()
	{
		return $this->belongsTo('App\Models\Event');
	}

}

