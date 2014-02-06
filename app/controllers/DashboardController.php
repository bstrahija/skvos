<?php namespace App\Controllers;

use App, Auth, Events, Invitations, Stats, Users, View;

class DashboardController extends BaseController {

	/**
	 * Display the user dashboard
	 * @return View
	 */
	public function index()
	{
		// Get next event that I'm invited to
		$user  = Users::find(Auth::user()->id);
		$event = Events::nextForUser($user->id);
		$last  = Events::lastForUser($user->id);
		$stats = Stats::extendedForUser($user->id);
		$rival = Stats::userRival($user->id);

		// Also get invitation for event
		if ($event) $invitation = Invitations::forEventAndUser($event->id, Auth::user()->id);
		else        $invitation = null;

		return View::make('dashboard.index', compact('event', 'stats', 'rival', 'invitation', 'last', 'user'));
	}

	/**
	 * User showcase
	 * @param  int $id
	 * @return View
	 */
	public function showcase($nickname)
	{
		// Get the user stats
		$user  = Users::findByNickname($nickname);

		if ($user)
		{
			$stats = Stats::extendedForUser($user->id);
			$rival = Stats::userRival($user->id);

			return View::make('dashboard.showcase')->withStats($stats)->withUser($user)->withRival($rival);
		}

		App::abort(404);
	}

}
