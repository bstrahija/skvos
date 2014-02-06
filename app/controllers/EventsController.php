<?php namespace App\Controllers;

use App, Auth, Events, Input, Matches, Redirect, Stats, Vault, Users, View;

class EventsController extends BaseController {

	/**
	 * Init
	 */
	public function __construct()
	{
		$this->beforeFilter('admin', ['only' => ['create', 'update', 'store', 'edit', 'mvps', 'destroy']]);
	}

	/**
	 * Show all events
	 * @return Response
	 */
	public function index()
	{
		// Get data
		$event    = Events::next();
		$upcoming = Events::upcoming(['skip_id' => $event->id]);
		$past     = Events::past();

		return View::make('events.index', compact('event', 'upcoming', 'past'));
	}

	/**
	 * Calculate MVP players
	 * @return Response
	 */
	public function mvps()
	{
		$events = Events::all(['limit' => 999]);

		foreach ($events as $event)
		{
			Events::update($event->id, ['mvp_id' => null]);
			Events::mvp($event->id);
		}

		return $events;
	}

	/**
	 * Create hashes for all events if missing
	 * @return Response
	 */
	public function hashes()
	{
		$events = Events::all(['limit' => 999]);

		foreach ($events as $event)
		{
			if ( ! $event->hash) Events::update($event->id, ['hash' => \Str::random(16)]);
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
		$event        = Events::find($id);
		$mvp          = Events::mvp($id);
		$players      = $event->attendees;
		$invitees     = $event->invitees;
		$matches      = Matches::forEvent($event->id);
		$leaderboard  = Stats::eventLeaderboard($event->id);
		$event_type   = Events::eventType($players->count());
		$next_players = Matches::nextMatchPlayers($event->id);

		return View::make('events.show', compact('event', 'mvp', 'players', 'invitees', 'matches', 'leaderboard', 'event_type', 'next_players'));
	}

	/**
	 * Show public results for an event
	 * @param  string $hash
	 * @return View
	 */
	public function results($hash)
	{
		$event = Events::findByHash($hash);

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
		$event       = Events::find($id);
		$matches     = Matches::forEvent($event->id);
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
		$players = Users::all();

		return View::make('events.create')->withPlayers($players);
	}

	/**
	 * Store a new event
	 * @return Redirect
	 */
	public function store()
	{
		if ($event = Events::create(Input::all()))
		{
			return Redirect::route('events.index')->withAlertSuccess('Spremljeno.');
		}

		return Redirect::back()->withErrors(Events::errors())->withInput();
	}

	/**
	 * Display form to edit an event
	 * @param  int $id
	 * @return View
	 */
	public function edit($id)
	{
		$event      = Events::find($id);
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
		if ($event = Events::update($id, Input::all()))
		{
			return Redirect::route('events.edit', $id)->withAlertSuccess('Spremljeno.');
		}

		return Redirect::back()->withErrors(Events::errors());
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
