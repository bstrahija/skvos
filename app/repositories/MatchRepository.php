<?php namespace App\Repositories;

use Carbon, Events;
use App\Models\Match;
use App\Resources\Collections\EventCollection;
use App\Resources\Items\EventItem;
use App\Repositories\Interfaces\MatchRepositoryInterface;
use App\Validation\MatchValidator;

class MatchRepository extends BaseRepository implements MatchRepositoryInterface {

	/**
	 * Class for collections
	 * @var string
	 */
	protected $collectionClass = 'App\Resources\Collections\MatchCollection';

	/**
	 * Class for single item
	 * @var string
	 */
	protected $itemClass = 'App\Resources\Items\MatchItem';

	/**
	 * Get all matches
	 * @return EventCollection
	 */
	public function all($options = null)
	{
		// Start query
		$this->query = Match::with(['player1', 'player2', 'winner'])->orderBy('created_at', 'desc');

		// Result
		return $this->collection($options);
	}

	/**
	 * Find single event
	 * @param  int   $id
	 * @param  array $options
	 * @return EventItem
	 */
	public function find($id, $options = null)
	{
		$this->query = Match::with(['player1', 'player2', 'winner'])
		                    ->where('id', $id);

		// Result
		return $this->item($options);
	}

	/**
	 * Get matches for event
	 * @param  int   $eventId
	 * @param  array $options
	 * @return MatchCollection
	 */
	public function forEvent($eventId, $options = null)
	{
		$this->query = Match::with(['player1', 'player2', 'winner'])->where('event_id', $eventId)->orderBy('created_at');

		// Result
		return $this->collection($options);
	}

	/**
	 * Create new match
	 * @param  array $data
	 * @return EventItem
	 */
	public function create($data)
	{
		// Validation setup
		$validation = new MatchValidator($data);

		if ($validation->passes())
		{
			$match                = new Match;
			$match->event_id      = (int) array_get($data, 'event_id');
			$match->player1_id    = (int) array_get($data, 'player1_id');
			$match->player2_id    = (int) array_get($data, 'player2_id');
			$match->player1_score = (int) array_get($data, 'player1_score');
			$match->player2_score = (int) array_get($data, 'player2_score');

			// Winner
			if     ($match->player1_score > $match->player2_score) $match->winner_id = $match->player1_id;
			elseif ($match->player2_score > $match->player1_score) $match->winner_id = $match->player2_id;

			// Save it
			$match->save();

			// Get match with all the relations
			$match = $this->find($match->id);

			return $match;
		}

		$this->errors = $validation->errors();

		return false;
	}

	/**
	 * Update existing match
	 * @param  int $id
	 * @param  array $data
	 * @return MatchItem
	 */
	public function update($id, $data)
	{
		$match = Match::find($id);

		// All the keys
		foreach (array_except($data, ['_token', '_method']) as $key => $val)
		{
			$match->$key = $val;
		}

		// Winner
		if     ($match->player1_score > $match->player2_score) $match->winner_id = $match->player1_id;
		elseif ($match->player2_score > $match->player1_score) $match->winner_id = $match->player2_id;

		$match->save();

		return $this->find($id);
	}

	/**
	 * Delete match
	 * @param  int $id
	 * @return bool
	 */
	public function delete($id)
	{
		$match = Match::find($id);

		return $match->delete($id);
	}

	/**
	 * Get players for next match
	 * @param  int $eventId
	 * @return array
	 */
	public function nextMatchPlayers($eventId)
	{
		// Get event and players
		$event      = Events::find($eventId);
		$players    = $event->attendees;
		$event_type = Events::eventType($players->count());
		$matches    = $this->forEvent($event->id);

		// Calculate next match (by default first and last player)
		$player1 = $players->count() ? $players->first()->id : 1;
		$player2 = $players->count() ? $players->last()->id  : 2;

		// For quadrupple match
		if ($players->count() >= 4 and $event_type == 'quadruple')
		{
			if ($matches->count() % 4 == 1)
			{
				$allIds     = $players->lists('id');
				$prevMatch  = $matches->last();
				$shouldPlay = array_values(array_diff($allIds, array($prevMatch->player1_id, $prevMatch->player2_id)));
				$player1    = isset($shouldPlay[0]) ? $shouldPlay[0] : $allIds[0];
				$player2    = isset($shouldPlay[1]) ? $shouldPlay[1] : $allIds[1];
			}
			elseif ($matches->count() % 4 == 2)
			{
				$prevMatch1 = $matches[$matches->count() - 2];
				$prevMatch2 = $matches[$matches->count() - 1];
				$player1    = ($prevMatch1->winner_id == $prevMatch1->player1_id) ? $prevMatch1->player2_id : $prevMatch1->player1_id;
				$player2    = ($prevMatch2->winner_id == $prevMatch2->player1_id) ? $prevMatch2->player2_id : $prevMatch2->player1_id;
			}
			elseif ($matches->count() % 4 == 3)
			{
				$prevMatch1 = $matches[$matches->count() - 3];
				$prevMatch2 = $matches[$matches->count() - 2];
				$player1    = $prevMatch1->winner_id;
				$player2    = $prevMatch2->winner_id;
			}
			elseif ($matches->count() and $matches->count() % 4 == 0)
			{
				$allIds      = $players->lists('id');
				$prevMatch   = $matches[$matches->count() - 1];
				$prevMatches = array($matches[$matches->count() - 2], $matches[$matches->count() - 3], $matches[$matches->count() - 4]);
				$player1     = $prevMatch->winner_id;
				$maybe         = array_values(array_diff($allIds, array($prevMatch->player1_id, $prevMatch->player2_id)));

				foreach ($prevMatches as $prevMatch)
				{
					if     ($prevMatch->player1_id == $player1) { $key = array_search($prevMatch->player1_id, $maybe); unset($maybe[$key]); }
					elseif ($prevMatch->player2_id == $player1) { $key = array_search($prevMatch->player2_id, $maybe); unset($maybe[$key]); }
				}
				$maybe = array_values($maybe);
				$player2 = isset($maybe[0]) ? $maybe[0] : 1;
			}
		}

		// For tripple match
		elseif ($players->count() >= 3 and $event_type == 'tripple')
		{
			$allIds = $players->lists('id');

			if ($matches->count() == 1)
			{
				$prevMatch  = $matches->last();
				$loserId    = ($prevMatch->winner_id == $prevMatch->player1_id) ? $prevMatch->player2_id : $prevMatch->player1_id;
				$shouldPlay = array_values(array_diff($allIds, array($prevMatch->winner_id, $loserId)));
				$player1    = isset($shouldPlay[0]) ? $shouldPlay[0] : $allIds[1];
				$player2    = $prevMatch->winner_id;
			}
			elseif ($matches->count() >= 2)
			{
				$prevMatch1 = $matches[$matches->count() - 1];
				$prevMatch2 = $matches[$matches->count() - 2];

				foreach ($allIds as $notPlaying)
				{
					if (($notPlaying == $prevMatch1->player1_id or $notPlaying == $prevMatch1->player2_id) and ($notPlaying == $prevMatch2->player1_id or $notPlaying == $prevMatch2->player2_id)) break;
				}

				$shouldPlay = array_values(array_diff($allIds, array($notPlaying)));
				$player1    = isset($shouldPlay[0]) ? $shouldPlay[0] : $allIds[0];
				$player2    = isset($shouldPlay[1]) ? $shouldPlay[1] : $allIds[1];
			}
		}

		return array(
			$player1,
			$player2,
		);
	}

}
