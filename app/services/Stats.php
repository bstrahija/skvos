<?php namespace App\Services;

use DB;
use App\Models\Match;
use App\Models\Event;
use App\Models\Invitation;
use App\Models\User;
use App\Repositories\EventRepository;
use App\Repositories\MatchRepository;
use App\Repositories\UserRepository;
use App\Resources\Items\StatsItem;
use App\Resources\Items\UserItem;
use Illuminate\Support\Collection;

class Stats {

	/**
	 * Match repository
	 * @var MatchRepository
	 */
	protected $matches;

	/**
	 * Event repository
	 * @var EventRepository
	 */
	protected $events;

	/**
	 * User repository
	 * @var UserRepository
	 */
	protected $users;

	/**
	 * Init dependencies
	 * @param MatchRepository $matches
	 * @param EventRepository $events
	 * @param UserRepository  $users
	 */
	public function __construct(MatchRepository $matches, EventRepository $events, UserRepository $users)
	{
		$this->matches = $matches;
		$this->events  = $events;
		$this->users   = $users;
	}

	/**
	 * Get some stats for specific user
	 * @param  int $userId
	 * @return Collection
	 */
	public function forUser($userId, $eventId = null)
	{
		// Direct stats
		if ($eventId)
		{
			$stats = array(
				'mvp_count'        => DB::table('events')->where('id', $eventId)->where('mvp_id', $userId)->count(),
				'matches_played'   => DB::table('matches')->where('event_id', $eventId)->where(function($q) use ($userId) {
				                      	$q->where('player1_id', $userId)->orWhere('player2_id', $userId);
				                      })->count(),
				'matches_won'      => DB::table('matches')->where('event_id', $eventId)->where('winner_id', $userId)->count(),
				'sets_played'      => (int) DB::table('matches')->select(DB::raw('(SUM(player1_score) + SUM(player2_score)) AS set_count'))->where('event_id', $eventId)->where(function($q) use ($userId) {
				                      	$q->where('player1_id', $userId)->orWhere('player2_id', $userId);
				                      })->first()->set_count,
				'sets_won'         => (int) DB::table('matches')->select(DB::raw('SUM(player1_score) AS set_count'))->where('event_id', $eventId)->where('player1_id', $userId)->first()->set_count +
				                      (int) DB::table('matches')->select(DB::raw('SUM(player2_score) AS set_count'))->where('event_id', $eventId)->where('player2_id', $userId)->first()->set_count,
			);
		}
		else
		{
			$stats = array(
				'mvp_count'        => DB::table('events')->where('mvp_id', $userId)->count(),
				'matches_played'   => DB::table('matches')->where('player1_id', $userId)->orWhere('player2_id', $userId)->count(),
				'matches_won'      => DB::table('matches')->where('winner_id', $userId)->count(),
				'sets_played'      => (int) DB::table('matches')->select(DB::raw('(SUM(player1_score) + SUM(player2_score)) AS set_count'))->where('player1_id', $userId)->orWhere('player2_id', $userId)->first()->set_count,
				'sets_won'         => (int) DB::table('matches')->select(DB::raw('SUM(player1_score) AS set_count'))->where('player1_id', $userId)->first()->set_count +
				                      (int) DB::table('matches')->select(DB::raw('SUM(player2_score) AS set_count'))->where('player2_id', $userId)->first()->set_count,
			);
		}


		// Calculated stats
		$stats = array_merge($stats, array(
			'matches_lost'     => $stats['matches_played'] - $stats['matches_won'],
			'match_efficiency' => $stats['matches_played'] ? round(( $stats['matches_won'] /  $stats['matches_played']) * 100, 2) : 0,
			'sets_lost'        => $stats['sets_played'] -  $stats['sets_won'],
			'set_efficiency'   => $stats['sets_played'] ? round(( $stats['sets_won'] /  $stats['sets_played']) * 100, 2) : 0,
		));

		return new StatsItem($stats);
	}

	/**
	 * Extended stats for a user
	 * @param  int $userId
	 * @return Collection
	 */
	public function extendedForUser($userId, $eventId = null)
	{
		$stats = $this->forUser($userId, $eventId)->toArray();

		// Extended
		$stats['events_attended']   = Invitation::where('user_id', $userId)->join('events', 'events.id', '=', 'invitations.event_id')->where('events.date', '<=', date('Y-m-d'))->where('confirmed', 1)->count();
		$stats['events_invited']    = Invitation::where('user_id', $userId)->join('events', 'events.id', '=', 'invitations.event_id')->where('events.date', '<=', date('Y-m-d'))->count();
		$stats['events_attendance'] = $stats['events_invited'] ? round(($stats['events_attended'] / $stats['events_invited']) * 100) : 0;

		return new StatsItem($stats);
	}

	/**
	 * Calculate the rival for the user
	 * @param  int $param
	 * @return UserItem
	 */
	public function userRival($userId)
	{
		$countAgainst  = array();
		$countAgainst1 = Match::select(DB::raw('player2_id AS opponent_id, COUNT(*) AS match_count'))->where('player1_id', $userId)->groupBy('player2_id')->orderBy('match_count', 'desc')->take(10)->get()->toArray();
		$countAgainst2 = Match::select(DB::raw('player1_id AS opponent_id, COUNT(*) AS match_count'))->where('player2_id', $userId)->groupBy('player1_id')->orderBy('match_count', 'desc')->take(10)->get()->toArray();

		// Merge data
		foreach ($countAgainst1 as $ca)
		{
			$countAgainst[$ca['opponent_id']] = $ca['match_count'];
		}
		foreach ($countAgainst2 as $ca)
		{
			if ( ! isset($countAgainst[$ca['opponent_id']])) $countAgainst[$ca['opponent_id']]  = $ca['match_count'];
			else                                             $countAgainst[$ca['opponent_id']] += $ca['match_count'];
		}

		// Order data
		uasort($countAgainst, function($a, $b)
		{
			return $a > $b ? -1 : 1;
		});

		// The rival
		$rivalId = key($countAgainst);

		if ($rivalId)
		{
			$rival = User::find($rivalId);
			$rival = new UserItem($rival->toArray());

			// Add efficiancy
			$rival->won_against        = $this->wonAgainstCount($userId, $rival->id);
			$rival->played_against     = $this->playedAgainstCount($userId, $rival->id);
			$rival->efficiency_against = $this->efficienyAgainst($userId, $rival->id);

			return $rival;
		}
	}

	/**
	 * Wins against a user
	 * @param  int $userId
	 * @param  int $opponentId
	 * @return int
	 */
	public function wonAgainstCount($userId, $opponentId)
	{
		$won = DB::table('matches')->where(function($q) use ($userId, $opponentId) {
			$q->where('player1_id', $userId)->where('player2_id', $opponentId)->where('winner_id', $userId);
		})->orWhere(function($q) use ($userId, $opponentId) {
			$q->where('player1_id', $opponentId)->where('player2_id', $userId)->where('winner_id', $userId);
		})->count();

		return $won;
	}

	/**
	 * Matches played against a user
	 * @param  int $userId
	 * @param  int $opponentId
	 * @return int
	 */
	public function playedAgainstCount($userId, $opponentId)
	{
		$played = DB::table('matches')->where(function($q) use ($userId, $opponentId) {
			$q->where('player1_id', $userId)->where('player2_id', $opponentId);
		})->orWhere(function($q) use ($userId, $opponentId) {
			$q->where('player1_id', $opponentId)->where('player2_id', $userId);
		})->count();

		return $played;
	}

	/**
	 * Calculate efficiency against another player
	 * @param  int $userId
	 * @param  int $opponentId
	 * @return mixed
	 */
	public function efficienyAgainst($userId, $opponentId)
	{
		$played     = $this->playedAgainstCount($userId, $opponentId);
		$won        = $this->wonAgainstCount($userId, $opponentId);
		$efficiency = round(($won / $played) * 100);

		return $efficiency;
	}

	/**
	 * Data for displaying the event leaderboard
	 * @param  int $eventId
	 * @return mixed
	 */
	public function eventLeaderboard($eventId)
	{
		$board = $this->events->leaderboard($eventId);

		return $board;
	}

	/**
	 * Return stats between players
	 * @param  array  $playerIds
	 * @return array
	 */
	public function playerStats($playerIds = array(), $eventId = null, $board = true)
	{
		$stats = new Collection;
		$plain = new Collection;

		if ($playerIds)
		{
			foreach ($playerIds as $playerId)
			{
				if ($playerId)
				{
					$allPlayerStats = new Collection;

					foreach ($playerIds as $opponentId)
					{
						if ($opponentId and $playerId != $opponentId)
						{
							$playerStats = DB::table('users')
							         ->select(
							         	'users.*',
							         	DB::raw('(SELECT COUNT(winner_id) FROM matches WHERE '.($eventId ? "event_id = $eventId AND (" : null).' (player1_id = users.id AND player2_id = '.$opponentId.') OR (player2_id = users.id AND player1_id = '.$opponentId.'))'.($eventId ? ')' : null).' AS matches_played'),
							         	DB::raw('(SELECT COUNT(winner_id) FROM matches WHERE '.($eventId ? "event_id = $eventId AND (" : null).' winner_id = users.id AND (player1_id = '.$opponentId.' OR player2_id = '.$opponentId.'))'.($eventId ? ')' : null).' AS matches_won'),
							         	DB::raw('(
							         		COALESCE((SELECT SUM(player1_score) FROM matches WHERE '.($eventId ? "event_id = $eventId AND " : null).' (player1_id = users.id AND player2_id = '.$opponentId.')), 0) +
							         		COALESCE((SELECT SUM(player2_score) FROM matches WHERE '.($eventId ? "event_id = $eventId AND " : null).' (player2_id = users.id AND player1_id = '.$opponentId.')), 0)
							         	) AS sets_won'),
							         	DB::raw('(SELECT (SUM(player1_score) + SUM(player2_score)) FROM matches WHERE '.($eventId ? "event_id = $eventId AND (" : null).' (player1_id = users.id AND player2_id = '.$opponentId.') OR (player2_id = users.id AND player1_id = '.$opponentId.'))'.($eventId ? ')' : null).' AS sets_played')
							         )
							         ->where('users.id', (int) $playerId)
							         ->first();
							$playerStats->match_efficiency = $playerStats->matches_played ? round(($playerStats->matches_won / $playerStats->matches_played) * 100, 2) : 0;
							$playerStats->set_efficiency   = $playerStats->sets_played ? round(($playerStats->sets_won / $playerStats->sets_played) * 100, 2) : 0;
							$playerStats                   = new UserItem((array) $playerStats);

							// Add to collections
							$allPlayerStats[] = array('stats' => $playerStats, 'opponent' => $this->users->find($opponentId));
							$plain[] = $playerStats;
						}
					}

					$stats[] = $allPlayerStats;
				}
			}

			// Sort plain board
			$plain->sort(function($a, $b) {
				if ($a->match_efficiency == $b->match_efficiency) return 0;

				return ($a->match_efficiency < $b->match_efficiency) ? 1 : -1;
			});

			if ($board) return $stats;
			else        return $plain;
		}
	}

	/**
	 * Stats per user
	 * @param  string $orderBy
	 * @param  string $dir
	 * @return array
	 */
	public function userStats($orderBy = 'id', $dir = 'asc')
	{
		$users = DB::table('users')
		         ->select(
		         	'users.*',
		         	DB::raw('(SELECT COUNT(winner_id) FROM matches WHERE player1_id = users.id OR player2_id = users.id) AS matches_played'),
		         	DB::raw('(SELECT COUNT(winner_id) FROM matches WHERE winner_id = users.id) AS matches_won'),
		         	DB::raw('(
		         		COALESCE((SELECT SUM(player1_score) FROM matches WHERE player1_id = users.id), 0) +
		         		COALESCE((SELECT SUM(player2_score) FROM matches WHERE player2_id = users.id), 0)
		         	) AS sets_won'),
		         	DB::raw('(SELECT (SUM(player1_score) + SUM(player2_score)) FROM matches WHERE player1_id = users.id OR player2_id = users.id) AS sets_played')
		         )
		         ->orderBy($orderBy, $dir)
		         ->get();

		// Get efficieny
		foreach ($users as &$user)
		{
			$user->match_efficiency = $user->matches_played ? round(($user->matches_won / $user->matches_played) * 100, 2) : 0;
			$user->set_efficiency   = $user->sets_played    ? round(($user->sets_won    / $user->sets_played)    * 100, 2) : 0;
		}

		return new Collection((array) $users);
	}

	/**
	 * Get user leaderboard ordered by won matches
	 * @return array
	 */
	public function matchesLeaderboard($dir = 'desc')
	{
		return $this->userStats('matches_won', $dir);
	}


}
