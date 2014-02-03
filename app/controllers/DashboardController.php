<?php namespace App\Controllers;

use Auth, Stats, View;
use App\Repositories\EventRepository;
use App\Repositories\InvitationRepository;
use App\Repositories\UserRepository;

class DashboardController extends BaseController {

	/**
	 * Events repository
	 * @var EventRepository
	 */
	protected $events;

	/**
	 * Invitation repository
	 * @var InvitationRepository
	 */
	protected $invitations;

	/**
	 * User repository
	 * @var UserRepository
	 */
	protected $users;

	/**
	 * Init rependencies
	 * @param EventRepository      $events
	 * @param InvitationRepository $invitations
	 * @param UserRepository       $users
	 */
	public function __construct(EventRepository $events, InvitationRepository $invitations, UserRepository $users)
	{
		$this->events      = $events;
		$this->invitations = $invitations;
		$this->users       = $users;
	}

	/**
	 * Display the user dashboard
	 * @return View
	 */
	public function index()
	{
		// Get next event that I'm invited to
		$user  = $this->users->find(Auth::user()->id);
		$event = $this->events->nextForUser($user->id);
		$last  = $this->events->lastForUser($user->id);
		$stats = Stats::forUser($user->id);

		// Also get invitation for event
		if ($event) $invitation = $this->invitations->forEventAndUser($event->id, Auth::user()->id);
		else        $invitation = null;

		return View::make('dashboard.index')->withEvent($event)->withStats($stats)->withInvitation($invitation)->withLast($last)->withUser($user);
	}

	/**
	 * User showcase
	 * @param  int $id
	 * @return View
	 */
	public function showcase($id)
	{
		// Get the user stats
		$stats = Stats::forUser($id);
		$user  = $this->users->find($id);

		return View::make('dashboard.showcase')->withStats($stats)->withUser($user);
	}

}
