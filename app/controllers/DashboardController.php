<?php namespace App\Controllers;

use Auth, View;
use App\Repositories\EventRepository;
use App\Repositories\InvitationRepository;
use App\Services\Stats;

class DashboardController extends BaseController {

	/**
	 * Events repository
	 * @var EventRepository
	 */
	protected $events;

	/**
	 * Stats service
	 * @var Stats
	 */
	protected $stats;

	/**
	 * Init rependencies
	 * @param EventRepository      $events
	 * @param InvitationRepository $invitations
	 * @param Stats                $stats
	 */
	public function __construct(EventRepository $events, InvitationRepository $invitations, Stats $stats)
	{
		$this->events      = $events;
		$this->invitations = $invitations;
		$this->stats       = $stats;
	}

	/**
	 * Display the user dashboard
	 * @return View
	 */
	public function index()
	{
		// Get next event that I'm invited to
		$event = $this->events->nextForUser(Auth::user()->id);
		$last  = $this->events->lastForUser(Auth::user()->id);
		$stats = $this->stats->forUser(Auth::user()->id);

		// Also get invitation for event
		if ($event) $invitation = $this->invitations->forEventAndUser($event->id, Auth::user()->id);
		else        $invitation = null;

		return View::make('dashboard.index')->withEvent($event)->withStats($stats)->withInvitation($invitation)->withLast($last);
	}

}
