<?php namespace App\Repositories;

use Carbon;
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

		foreach (array_except($data, ['_token', '_method']) as $key => $val)
		{
			$match->$key = $val;
		}

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

}
