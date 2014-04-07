<?php namespace App\Repositories;

use Auth, Carbon, Stats, Str;
use App\Models\Event;
use App\Models\Invitation;
use App\Models\Match;
use App\Models\User;
use App\Resources\Collections\BaseCollection;
use App\Resources\Collections\EventCollection;
use App\Resources\Collections\MatchCollection;
use App\Resources\Items\EventItem;
use App\Resources\Items\UserItem;
use App\Repositories\Interfaces\EventRepositoryInterface;
use Illuminate\Support\Collection;
use App\Validation\EventValidator;

class EventRepository extends BaseRepository implements EventRepositoryInterface {

	/**
	 * Class for collections
	 * @var string
	 */
	protected $collectionClass = 'App\Resources\Collections\EventCollection';

	/**
	 * Class for single item
	 * @var string
	 */
	protected $itemClass = 'App\Resources\Items\EventItem';

	/**
	 * Get all events
	 * @return EventCollection
	 */
	public function all($options = null)
	{
		// Start query
		$this->query = Event::with(['author', 'invitees', 'attendees', 'mvp'])->orderBy('date', 'desc');

		// Result
		return $this->collection($options);
	}

	/**
	 * Get upcoming events
	 * @param  array $options
	 * @return EventCollection
	 */
	public function upcoming($options = null)
	{
		$this->query = Event::with(['author', 'invitees', 'attendees', 'mvp'])
		                    ->where('from', '>=', Carbon::now()->format('Y-m-d H:i:s'))
		                    ->orderBy('from', 'asc');

		// Skip the next event
		if ($skip = array_get($options, 'skip_id'))
		{
			$this->query->where('id', '<>', $skip);
		}

		// Result
		return $this->collection($options);
	}

	/**
	 * Get next event on schedule
	 * @param  array $options
	 * @return EventItem
	 */
	public function next($options = null)
	{
		$this->query = Event::with(['author', 'invitees', 'attendees', 'mvp', 'comments.author'])
		                    ->where('date', '>=', Carbon::now()->format('Y-m-d'))
		                    ->orderBy('from', 'asc');

		// Result
		return $this->item($options);
	}

	/**
	 * Get next event on schedule
	 * @param  array $options
	 * @return EventItem
	 */
	public function nextForUser($userId, $options = null)
	{
		$this->query = Event::with(['author', 'invitees', 'attendees', 'mvp', 'comments'])
		                    ->where('date', '>=', Carbon::now()->format('Y-m-d'))
		                    ->whereHas('invitees', function($q) use ($userId) {
		                    	$q->where('user_id', $userId);
		                    })
		                    ->orderBy('from', 'asc');

		// Result
		return $this->item($options);
	}

	/**
	 * Get last event on schedule
	 * @param  array $options
	 * @return EventItem
	 */
	public function lastForUser($userId, $options = null)
	{
		$this->query = Event::with(['author', 'invitees', 'attendees', 'mvp', 'comments.author'])
		                    ->where('date', '<', Carbon::now()->format('Y-m-d'))
		                    ->whereHas('invitees', function($q) use ($userId) {
		                    	$q->where('user_id', $userId);
		                    })
		                    ->orderBy('date', 'desc');

		// Result
		$event = $this->item($options);
		$mvp   = $this->mvp($event->id);

		return $event;
	}

	/**
	 * Get past events
	 * @param  array $options
	 * @return EventCollection
	 */
	public function past($options = null)
	{
		$this->query = Event::with(['author', 'invitees', 'attendees', 'mvp'])
		                    ->where('date', '<', Carbon::now()->format('Y-m-d'))
		                    ->orderBy('from', 'desc');

		// Result
		return $this->collection($options);
	}

	/**
	 * Get organized events for home
	 * @param  array $options
	 * @return Collection
	 */
	public function home($options)
	{
		$next = $this->next($options);

		$response = new Collection(array(
			'next'     => $next ? $next->toArray() : null,
			'upcoming' => $this->upcoming($options),
			'past'     => $this->past($options),
		));

		return $response;
	}

	/**
	 * Find single event
	 * @param  int   $id
	 * @param  array $options
	 * @return EventItem
	 */
	public function find($id, $options = null)
	{
		$this->query = Event::with(['author', 'invitees', 'attendees', 'mvp', 'comments.author'])
		                    ->where('id', $id);

		// Result
		return $this->item($options);
	}

	/**
	 * Find single event by hash
	 * @param  string $hash
	 * @param  array  $options
	 * @return EventItem
	 */
	public function findByHash($hash, $options = null)
	{
		$this->query = Event::with(['author', 'invitees', 'attendees', 'mvp', 'comments.author'])
		                    ->where('hash', $hash);

		// Result
		return $this->item($options);
	}

	/**
	 * Return related matches
	 * @param  int $eventId
	 * @return MacthCollection
	 */
	public function matches($eventId, $options = null)
	{
		$matches = Match::with(['event', 'player1', 'player2', 'winner'])->where('event_id', $eventId)->get();
		$matches = new MatchCollection($matches->toArray());

		return $matches;
	}

	/**
	 * Most valuable player of event
	 * @param  int $eventId
	 * @return UserItem
	 */
	public function mvp($eventId, $options = null)
	{
		// Get event with all relations
		$mvp   = null;
		$event = $this->find($eventId);

		// If we already have an MVP, don't calculate everything again
		if ($event and $event->attendees->count())
		{
			if (Carbon::now() < Carbon::parse($event->to) or ! $event->mvp)
			{
				$attendees = $this->leaderboard($event->id);

				// MVP object
				$mvp = $attendees->first();

				// Store the MVP ID and return object
				if ($mvp->points and $attendees->count() > 1) $this->update($eventId, array('mvp_id' => $mvp->id));
				else                                          $mvp = null;

				if ($mvp) $mvp = $mvp->toArray();
			}
			else
			{
				$mvp = $event->mvp->toArray();
			}
		}

		if ($mvp) return new UserItem($mvp);
	}

	/**
	 * Get event attendees and their stats
	 * @param  in $eventId
	 * @return mixed
	 */
	public function leaderboard($eventId)
	{
		$event   = $this->find($eventId);
		$matches = $this->matches($eventId);

		if ($event->attendees->count())
		{
			// Make MVP calculations
			foreach ($event->attendees as &$attendee)
			{
				$attendee->points  = 0;
				$attendee->stats   = Stats::extendedForUser($attendee->id, $event->id);
				$attendee->points  = $attendee->stats->matches_won * 2;
				$attendee->points += $attendee->stats->sets_won * 0.25;
				$attendee->points -= $attendee->stats->sets_lost * 0.1;

				// Alternate calculation
				// $attendee->points = round(($attendee->stats->match_efficiency + $attendee->stats->set_efficiency) / 20, 2);
			}

			// Sort calculations
			$event->attendees->sort(function($a, $b) {
				if ($a->points == $b->points) return 0;

				return ($a->points < $b->points) ? 1 : -1;
			});
			$topPoints = $event->attendees->first()->points;

			// Check if some player have the same points
			$samePoints = array();
			foreach ($event->attendees as $key => $attendee)
			{
				if ($attendee->points == $topPoints) $same[] = $attendee->id;
			}

			// Get stats between players
			if (count($same) > 1)
			{
				$playerStats = Stats::playerStats($same, $eventId, false);

				foreach ($event->attendees as &$attendee)
				{
					if ($attendee->id == $playerStats->first()->id) $attendee->points += 1;
				}

				// Sort calculations
				$event->attendees->sort(function($a, $b) {
					if ($a->points == $b->points) return 0;

					return ($a->points < $b->points) ? 1 : -1;
				});
			}
		}

		return $event->attendees;
	}

	/**
	 * Create new event
	 * @param  array $data
	 * @return EventItem
	 */
	public function create($data)
	{
		// Validation setup
		$validation = new EventValidator($data);

		if ($validation->passes())
		{
			$event            = new Event;
			$event->author_id = Auth::user()->id;
			$event->title     = array_get($data, 'title');
			$event->hash      = Str::random(16);
			$event->date      = array_get($data, 'date');
			$event->from      = array_get($data, 'date') . ' ' . array_get($data, 'from');
			$event->to        = array_get($data, 'date') . ' ' . array_get($data, 'to');
			$event->save();

			// Then create invitations
			foreach (array_get($data, 'players') as $player)
			{
				$invitation = new Invitation;
				$invitation->user_id  = (int) $player;
				$invitation->event_id = (int) $event->id;
				$invitation->hash     = Str::random(42);
				$invitation->save();
			}

			// Get event with all the relations
			$event = $this->find($event->id);

			return $event;
		}

		$this->errors = $validation->errors();

		return false;
	}

	/**
	 * Update an event
	 * @param  int   $eventId
	 * @param  array $data
	 * @return EventItem
	 */
	public function update($eventId, $data)
	{
		$event = Event::find($eventId);

		foreach (array_except($data, ['_token', '_method']) as $key => $val)
		{
			if     ($key == 'date')    $event->$key = Carbon::parse($val)->format('Y-m-d');
			elseif ($key == 'from')    $event->$key = Carbon::parse(array_get($data, 'date') . ' ' . $val)->format('Y-m-d H:i:s');
			elseif ($key == 'to')      $event->$key = Carbon::parse(array_get($data, 'date') . ' ' . $val)->format('Y-m-d H:i:s');
			elseif ($key == 'players') $this->updateInvitations($eventId, $val);
			else                       $event->$key = $val;
		}

		$event->save();

		return $this->find($eventId);
	}

	/**
	 * Update event attendance
	 * @param  int $eventId
	 * @param  array $players
	 * @return void
	 */
	public function updateInvitations($eventId, $players)
	{
		$invitations = Invitation::where('event_id', $eventId)->get();

		if ($invitations->count())
		{
			foreach ($invitations as $invitation)
			{
				if (in_array($invitation->user_id, $players)) { $invitation->confirmed = 1; $invitation->cancelled = 0; }
				elseif ($invitation->confirmed == 1)          { $invitation->confirmed = 0; $invitation->cancelled = 1; }

				$invitation->save();
			}
		}
	}

	/**
	 * Event type by number of players
	 * @param  integer $playerCount
	 * @return string
	 */
	public function eventType($playerCount = 2)
	{
		$event_type  = $playerCount == 2 ? 'double'    : 'unknown';
		$event_type  = $playerCount == 3 ? 'tripple'   : $event_type;
		$event_type  = $playerCount == 4 ? 'quadruple' : $event_type;

		return $event_type;
	}

}
