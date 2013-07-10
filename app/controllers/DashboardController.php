<?php namespace App\Controllers;

use App\Models\Event, App\Models\Match, Redirect, Request, View;

class DashboardController extends BaseController {

	public function getIndex()
	{
		// Get all upcoming events and last 5 past events
		$upcomingEvents = Event::upcoming()->get();
		$pastEvents     = Event::past()->take(5)->get();

		return View::make('dashboard.index', array(
			'events' => $upcomingEvents,
			'past'   => $pastEvents,
		));
	}

}
