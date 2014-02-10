<?php namespace App\Resources\Items;

use Carbon;
use App\Resources\Collections\CommentCollection;
use App\Resources\Collections\EventCollection;
use App\Resources\Collections\UserCollection;

class EventItem extends \Creolab\Resources\Item {

	/**
	 * Transform attributes
	 * @var array
	 */
	protected $transform = array(
		'date'      => 'date',
		'from'      => 'datetime',
		'to'        => 'datetime',
		'author'    => 'App\Resources\Items\UserItem',
		'invitees'  => 'App\Resources\Collections\UserCollection',
		'attendees' => 'App\Resources\Collections\UserCollection',
		'comments'  => 'App\Resources\Collections\CommentCollection',
		'mvp'       => 'App\Resources\Items\UserItem',
	);

	/**
	 * The period nicely formated
	 * @return bool
	 */
	public function getPeriodAttribute()
	{
		return date('d.m. @ H:i', strtotime($this->data['from'])) . ' - ' . date('H:i', strtotime($this->data['to']));
	}

	/**
	 * Check if a new match can be entered
	 * @return bool
	 */
	public function getCanEnterMatchAttribute()
	{
		$now  = Carbon::now();
		$from = Carbon::parse($this->data['from']);
		$to   = Carbon::parse($this->data['to']);

		if ($now > $from->subMinutes(30) and $now->format('Y-m-d') == $to->format('Y-m-d'))
		{
			return true;
		}
	}

	/**
	 * Check if we should start showing resuts
	 * @return bool
	 */
	public function getShowResultsAttribute()
	{
		$now  = Carbon::now();
		$from = $this->data['from'];

		if ($now > $from->subMinutes(30))
		{
			return true;
		}
	}

	/**
	 * Check if the event is over
	 * @return bool
	 */
	public function getIsOverAttribute()
	{
		$now  = Carbon::now();
		$to   = Carbon::parse($this->data['to']);

		if ($now > $to) return true;
	}

}
