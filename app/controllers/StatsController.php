<?php namespace App\Controllers;

use Auth, DB, Events, Input, Redirect, Stats, Users, View;
use App\Models\Stat;

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

	/**
	 * Generate stats and populate stats tables
	 * @return Response
	 */
	public function generate()
	{
		$events = Events::all(['limit' => 9999]);


		// Remove old stats
		DB::table('stats')->where('type', 'player_event_match_efficiency')->delete();
		DB::table('stats')->where('type', 'player_event_set_efficiency')->delete();

		// Generate new ones
		foreach ($events as $event)
		{
			if ($event->attendees->count() > 1)
			{
				foreach ($event->attendees as $user)
				{
					$playerStats = Stats::extendedForUser($user->id, $event->id);

					if ($playerStats->matches_played)
					{
						$stat = Stat::create([
							'user_id'  => $user->id,
							'event_id' => $event->id,
							'type'     => 'player_event_match_efficiency',
							'value'    => $playerStats->match_efficiency,
						]);
						$stat = Stat::create([
							'user_id'  => $user->id,
							'event_id' => $event->id,
							'type'     => 'player_event_set_efficiency',
							'value'    => $playerStats->set_efficiency,
						]);
					}
				}
			}
		}

		return View::make('stats.chart');
	}

}
