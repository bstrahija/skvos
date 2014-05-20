<?php namespace App\Models;

class Event extends \Eloquent {

	protected $dates = ['comments_sent_at'];

	/**
	 * Guard fields from mass assignment
	 * @var array
	 */
	protected $guarded = array('id', 'author_id');

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
	 * Most valuable player of event
	 * @return mixed
	 */
	public function mvp()
	{
		return $this->belongsTo('App\Models\User');
	}

	/**
	 * Related comments
	 * @return mixed
	 */
	public function comments()
	{
		return $this->hasMany('App\Models\Comment')->orderBy('created_at', 'desc');
	}

}

