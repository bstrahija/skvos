<?php namespace App\Models;

class Group extends \Eloquent {

	/**
	 * Guard fields from mass assignment
	 * @var array
	 */
	protected $guarded = array('id');

	/**
	 * Group owner
	 * @return Query
	 */
	public function owner()
	{
		return $this->belongsTo('App\Models\User');
	}

	/**
	 * Members for group
	 * @return Query
	 */
	public function members()
	{
		return $this->belongsToMany('App\Models\User', 'groups_users');
	}

}

