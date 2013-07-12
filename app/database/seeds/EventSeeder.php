<?php

use App\Models\Event, App\Models\Invitation, Carbon\Carbon;

class EventSeeder extends Seeder {

	public function run()
	{
		$tz = 'Europe/Zagreb';
		DB::table('events')->delete();
		DB::table('invitations')->delete();

		// ! Future
		$event = Event::create(array(
			'title' => 'Beer/squash: ' . Carbon::now()->addWeeks(1)->format('d.m.Y.'),
			'date'  => Carbon::now()->addWeeks(1),
			'from'  => Carbon::today()->addWeeks(1)->addHours('18'),
			'to'    => Carbon::today()->addWeeks(1)->addHours('20')->addMinutes(30),
		));
		Invitation::create(array('user_id' => 1, 'event_id' => $event->id, 'confirmed' => 0));
		Invitation::create(array('user_id' => 2, 'event_id' => $event->id, 'confirmed' => 0));
		Invitation::create(array('user_id' => 3, 'event_id' => $event->id, 'confirmed' => 0));
		Invitation::create(array('user_id' => 4, 'event_id' => $event->id, 'confirmed' => 0));

		$event = Event::create(array(
			'title' => 'Beer/squash: ' . Carbon::now()->addWeeks(2)->format('d.m.Y.'),
			'date'  => Carbon::now()->addWeeks(2),
			'from'  => Carbon::today()->addWeeks(2)->addHours('18'),
			'to'    => Carbon::today()->addWeeks(2)->addHours('20')->addMinutes(30),
		));
		Invitation::create(array('user_id' => 1, 'event_id' => $event->id, 'confirmed' => 0));
		Invitation::create(array('user_id' => 2, 'event_id' => $event->id, 'confirmed' => 0));
		Invitation::create(array('user_id' => 3, 'event_id' => $event->id, 'confirmed' => 0));
		Invitation::create(array('user_id' => 4, 'event_id' => $event->id, 'confirmed' => 0));

		// ! Today
		$event = Event::create(array(
			'title' => 'Beer/squash: ' . Carbon::now()->format('d.m.Y.'),
			'date'  => Carbon::now(),
			'from'  => Carbon::today()->addHours('18'),
			'to'    => Carbon::today()->addHours('20')->addMinutes(30),
		));
		Invitation::create(array('user_id' => 1, 'event_id' => $event->id, 'confirmed' => 1));
		Invitation::create(array('user_id' => 2, 'event_id' => $event->id, 'confirmed' => 1));
		Invitation::create(array('user_id' => 3, 'event_id' => $event->id, 'confirmed' => 0));
		Invitation::create(array('user_id' => 4, 'event_id' => $event->id, 'confirmed' => 0));

		// ! Some old ones
		$event = Event::create(array(
			'title' => 'Beer/squash: ' . Carbon::now()->subWeeks(1)->format('d.m.Y.'),
			'date'  => Carbon::now()->subWeeks(1),
			'from'  => Carbon::today()->subWeeks(1)->addHours('18'),
			'to'    => Carbon::today()->subWeeks(1)->addHours('20')->addMinutes(30),
		));
		Invitation::create(array('user_id' => 1, 'event_id' => $event->id, 'confirmed' => 1));
		Invitation::create(array('user_id' => 2, 'event_id' => $event->id, 'confirmed' => 1));
		Invitation::create(array('user_id' => 3, 'event_id' => $event->id, 'confirmed' => 1));

		$event = Event::create(array(
			'title' => 'Beer/squash: ' . Carbon::now()->subWeeks(2)->format('d.m.Y.'),
			'date'  => Carbon::now()->subWeeks(2),
			'from'  => Carbon::today()->subWeeks(2)->addHours('18'),
			'to'    => Carbon::today()->subWeeks(2)->addHours('20')->addMinutes(30),
		));
		Invitation::create(array('user_id' => 1, 'event_id' => $event->id, 'confirmed' => 1));
		Invitation::create(array('user_id' => 2, 'event_id' => $event->id, 'confirmed' => 1));
		Invitation::create(array('user_id' => 3, 'event_id' => $event->id, 'confirmed' => 0));
		Invitation::create(array('user_id' => 4, 'event_id' => $event->id, 'confirmed' => 1));

		$event = Event::create(array(
			'title' => 'Beer/squash: ' . Carbon::now()->subWeeks(3)->format('d.m.Y.'),
			'date'  => Carbon::now()->subWeeks(3),
			'from'  => Carbon::today()->subWeeks(3)->addHours('18'),
			'to'    => Carbon::today()->subWeeks(3)->addHours('20')->addMinutes(30),
		));
		Invitation::create(array('user_id' => 1, 'event_id' => $event->id, 'confirmed' => 1));
		Invitation::create(array('user_id' => 2, 'event_id' => $event->id, 'confirmed' => 1));
		Invitation::create(array('user_id' => 3, 'event_id' => $event->id, 'confirmed' => 1));
		Invitation::create(array('user_id' => 4, 'event_id' => $event->id, 'confirmed' => 1));

		// ! Real events
		$event = Event::create(array(
			'title' => 'Beer/squash: 11.7.2013.',
			'date'  => Carbon::createFromDate(2013, 7, 11),
			'from'  => Carbon::create(2013, 7, 11, 18, 0),
			'to'    => Carbon::create(2013, 7, 11, 20, 0),
		));
		Invitation::create(array('user_id' => 1, 'event_id' => $event->id, 'confirmed' => 1));
		Invitation::create(array('user_id' => 2, 'event_id' => $event->id, 'confirmed' => 1));
		Invitation::create(array('user_id' => 5, 'event_id' => $event->id, 'confirmed' => 1));

		// ! Connect users to events
		// Invitation::create(array('user_id' => 1, 'event_id' => 1, 'confirmed' => 1));
		// Invitation::create(array('user_id' => 2, 'event_id' => 1, 'confirmed' => 1));
		// Invitation::create(array('user_id' => 3, 'event_id' => 1, 'confirmed' => 0));
		// Invitation::create(array('user_id' => 4, 'event_id' => 1, 'confirmed' => 0));
		// Invitation::create(array('user_id' => 5, 'event_id' => 1, 'confirmed' => 0));
		// Invitation::create(array('user_id' => 1, 'event_id' => 2, 'confirmed' => 1));
		// Invitation::create(array('user_id' => 2, 'event_id' => 2, 'confirmed' => 0));
		// Invitation::create(array('user_id' => 3, 'event_id' => 2, 'confirmed' => 1));
		// Invitation::create(array('user_id' => 1, 'event_id' => 3, 'confirmed' => 1));
		// Invitation::create(array('user_id' => 2, 'event_id' => 3, 'confirmed' => 1));
		// Invitation::create(array('user_id' => 3, 'event_id' => 3, 'confirmed' => 1));
		// Invitation::create(array('user_id' => 4, 'event_id' => 3, 'confirmed' => 1));
		// Invitation::create(array('user_id' => 5, 'event_id' => 3, 'confirmed' => 0));
	}

}
