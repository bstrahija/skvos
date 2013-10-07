<?php namespace App\Controllers;

use Input, View;
use App\Services\Stats;
use App\Models\User;

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

	/**
	 * Stats between players
	 * @return View
	 */
	public function getPlayers()
	{
		$users         = User::all();
		$player_select = $users->lists('first_name', 'id');
		array_unshift($player_select, '-');
		$player_stats  = $this->stats->playerStats(Input::only('player1', 'player2', 'player3', 'player4'));

		return View::make('stats.players', compact('users', 'player_select', 'player_stats'));
	}

}
