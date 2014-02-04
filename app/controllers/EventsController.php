<?php namespace App\Controllers;

use App, Auth, Input, Redirect, Stats, Vault, View;
use App\Repositories\EventRepository;
use App\Repositories\MatchRepository;
use App\Repositories\UserRepository;

class EventsController extends BaseController {

	/**
	 * Event repository
	 * @var EventRepository
	 */
	protected $events;

	/**
	 * Match repository
	 * @var MatchRepository
	 */
	protected $matches;

	/**
	 * User repository
	 * @var UserRepository
	 */
	protected $users;

	/**
	 * Init rependencies
	 * @param EventRepository $events
	 * @param MatchRepository $matches
	 * @param UserRepository  $users
	 */
	public function __construct(EventRepository $events, MatchRepository $matches, UserRepository $users)
	{
		$this->events  = $events;
		$this->matches = $matches;
		$this->users   = $users;

		// Filters
		$this->beforeFilter('admin', ['only' => ['create', 'update', 'store', 'edit', 'mvps', 'destroy']]);
	}

	/**
	 * Show all events
	 * @return Response
	 */
	public function index()
	{
		// Get data
		$event    = $this->events->next();
		$upcoming = $this->events->upcoming();
		$past     = $this->events->past();

		return View::make('events.index', compact('event', 'upcoming', 'past'));
	}

	/**
	 * Calculate MVP players
	 * @return Response
	 */
	public function mvps()
	{
		$events = $this->events->all();

		foreach ($events as $event)
		{
			$this->events->mvp($event->id);
		}

		return $events;
	}

	/**
	 * Create hashes for all events if missing
	 * @return Response
	 */
	public function hashes()
	{
		$events = $this->events->all(['limit' => 999]);

		foreach ($events as $event)
		{
			if ( ! $event->hash) $this->events->update($event->id, ['hash' => \Str::random(16)]);
		}

		return ['events' => $events->count()];
	}

	/**
	 * Display single event
	 * @param  int $id
	 * @return View
	 */
	public function show($id)
	{
		$event       = $this->events->find($id);
		$mvp         = $this->events->mvp($id);
		$players     = $event->attendees;
		$invitees    = $event->invitees;
		$matches     = $this->matches->forEvent($event->id);
		$leaderboard = Stats::eventLeaderboard($event->id);
		$event_type  = $event->attendees->count() == 2 ? 'double'    : null;
		$event_type  = $event->attendees->count() == 3 ? 'tripple'   : $event_type;
		$event_type  = $event->attendees->count() == 4 ? 'quadruple' : $event_type;

		// Calculate next match
		$next_match_player_1 = $event->attendees->count() ? $event->attendees->first()->id : 1;
		$next_match_player_2 = $event->attendees->count() ? $event->attendees->last()->id  : 2;

		return View::make('events.show', compact(
			'event', 'mvp', 'players', 'invitees', 'matches', 'leaderboard', 'event_type',
			'next_match_player_1', 'next_match_player_2'
		));
	}

	/**
	 * Show public results for an event
	 * @param  string $hash
	 * @return View
	 */
	public function results($hash)
	{
		$event = $this->events->findByHash($hash);

		if ($event) return $this->show($event->id);

		App::abort(404);
	}

	/**
	 * Match results for event
	 * @param  int $id
	 * @return View
	 */
	public function matches($id)
	{
		$event       = $this->events->find($id);
		$matches     = $this->matches->forEvent($event->id);
		$event_type  = $event->attendees->count() == 2 ? 'double'    : null;
		$event_type  = $event->attendees->count() == 3 ? 'tripple'   : $event_type;
		$event_type  = $event->attendees->count() == 4 ? 'quadruple' : $event_type;

		return View::make('events.match_results', compact('event', 'matches', 'event_type'));
	}

	/**
	 * Display form for new event
	 * @return View
	 */
	public function create()
	{
		$players = $this->users->all();

		return View::make('events.create')->withPlayers($players);
	}

	/**
	 * Store a new event
	 * @return Redirect
	 */
	public function store()
	{
		if ($event = $this->events->create(Input::all()))
		{
			return Redirect::route('events.index')->withAlertSuccess('Spremljeno.');
		}

		return Redirect::back()->withErrors($this->events->errors())->withInput();
	}

	/**
	 * Display form to edit an event
	 * @param  int $id
	 * @return View
	 */
	public function edit($id)
	{
		$event      = $this->events->find($id);
		$atendeeIds = (array) $event->attendees->lists('id');

		return View::make('events.edit')->withEvent($event)->withAttendeeIds($atendeeIds);
	}

	/**
	 * Update existing event
	 * @param  int $id
	 * @return Redirect
	 */
	public function update($id)
	{
		if ($event = $this->events->update($id, Input::all()))
		{
			return Redirect::route('events.edit', $id)->withAlertSuccess('Spremljeno.');
		}

		return Redirect::back()->withErrors($this->events->errors());
	}

	/**
	 * Delete existing event
	 * @param  int $id
	 * @return Redirect
	 */
	public function destroy($id)
	{

	}

}
