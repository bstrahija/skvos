<?php namespace App\Controllers;

use View;
use App\Services\Stats;

class StatsController extends BaseController {

	/**
	 * Stats service
	 * @var Stats
	 */
	protected $stats;

	/**
	 * Init
	 * @param Stats $stats
	 */
	public function __construct(Stats $stats)
	{
		$this->stats = $stats;
	}

	/**
	 * Stats overview
	 * @return View
	 */
	public function getIndex()
	{
		$leaderboard = $this->stats->matchesLeaderboard();

		return View::make('stats.index', array('leaderboard' => $leaderboard));
	}

}
