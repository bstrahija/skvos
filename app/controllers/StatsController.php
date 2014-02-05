<?php namespace App\Controllers;

use Auth, Input, Redirect, Stats, Users, View;

class StatsController extends BaseController {

	/**
	 * Show stats
	 * @return View
	 */
	public function index()
	{
		$leaderboard = Stats::matchesLeaderboard();

		// Sort it
		$leaderboard->sort(function($a, $b) {
			if ($a->match_efficiency == $b->match_efficiency) return 0;

			return ($a->match_efficiency < $b->match_efficiency) ? 1 : -1;
		});

		return View::make('stats.index', compact('leaderboard'));
	}

	/**
	 * Show my stats
	 * @return View
	 */
	public function my()
	{
		$stats = Stats::extendedForUser(Auth::user()->id);
		$rival = Stats::userRival(Auth::user()->id);

		return View::make('stats.my')->withStats($stats)->withRival($rival);
	}

	/**
	 * Stats between players
	 * @return View
	 */
	public function players()
	{
		$players       = Users::all();
		$player_stats  = Stats::playerStats(Input::get('players'));

		return View::make('stats.players', compact('players', 'player_stats'));
	}

}
