<?php namespace App\Services;

use DB;

class Stats {

	public function userStats($orderBy = 'id', $dir = 'asc')
	{
		$users = DB::table('users')
		         ->select(
		         	'users.*',
		         	DB::raw('(SELECT COUNT(winner_id) FROM matches WHERE player1_id = users.id OR player2_id = users.id) AS matches_played'),
		         	DB::raw('(SELECT COUNT(winner_id) FROM matches WHERE winner_id = users.id) AS matches_won'),
		         	DB::raw('(
		         		COALESCE((SELECT SUM(player1_sets_won) FROM matches WHERE player1_id = users.id), 0) +
		         		COALESCE((SELECT SUM(player2_sets_won) FROM matches WHERE player2_id = users.id), 0)
		         	) AS sets_won'),
		         	DB::raw('(SELECT (SUM(player1_sets_won) + SUM(player2_sets_won)) FROM matches WHERE player1_id = users.id OR player2_id = users.id) AS sets_played')
		         )
		         ->orderBy($orderBy, $dir)
		         ->get();

		return $users;
	}

	/**
	 * Get user leaderboard ordered by won matches
	 * @return array
	 */
	public function matchesLeaderboard($dir = 'desc')
	{
		return $this->userStats('matches_won', $dir);
	}

	/**
	 * Get user leaderboard ordered by won sets
	 * @return array
	 */
	public function setsLeaderboard($dir = 'desc')
	{
		return $this->userStats('sets_won', $dir);
	}

}
