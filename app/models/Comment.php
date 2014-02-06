<?php namespace App\Models;

class Comment extends \Eloquent {

	/**
	 * Guard fields from mass assignment
	 * @var array
	 */
	protected $guarded = array('id');

	/**
	 * Comment author
	 * @return Query
	 */
	public function author()
	{
		return $this->belongsTo('App\Models\User', 'author_id');
	}

}

