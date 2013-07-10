<?php

use App\Models\Event, App\Models\Invitation, Carbon\Carbon;

class EventSeeder extends Seeder {

	public function run()
	{
		DB::table('events')->delete();
		DB::table('invitations')->delete();

		// ! Today
		Event::create(array(
			'title' => 'Beer/squash: ' . Carbon::now()->format('d.m.Y.'),
			'date'  => Carbon::now(),
			'from'  => Carbon::today()->addHours('18'),
			'to'    => Carbon::today()->addHours('20')->addMinutes(30),
		));

		// ! Some old ones
		Event::create(array(
			'title' => 'Beer/squash: ' . Carbon::now()->subWeeks(1)->format('d.m.Y.'),
			'date'  => Carbon::now()->subWeeks(1),
			'from'  => Carbon::today()->subWeeks(1)->addHours('18'),
			'to'    => Carbon::today()->subWeeks(1)->addHours('20')->addMinutes(30),
		));
		Event::create(array(
			'title' => 'Beer/squash: ' . Carbon::now()->subWeeks(2)->format('d.m.Y.'),
			'date'  => Carbon::now()->subWeeks(2),
			'from'  => Carbon::today()->subWeeks(2)->addHours('18'),
			'to'    => Carbon::today()->subWeeks(2)->addHours('20')->addMinutes(30),
		));

		// ! Connect users to events
		Invitation::create(array('user_id' => 1, 'event_id' => 1, 'confirmed' => 1));
		Invitation::create(array('user_id' => 2, 'event_id' => 1, 'confirmed' => 1));
		Invitation::create(array('user_id' => 3, 'event_id' => 1, 'confirmed' => 0));
		Invitation::create(array('user_id' => 4, 'event_id' => 1, 'confirmed' => 0));
		Invitation::create(array('user_id' => 5, 'event_id' => 1, 'confirmed' => 0));
		Invitation::create(array('user_id' => 1, 'event_id' => 2, 'confirmed' => 1));
		Invitation::create(array('user_id' => 2, 'event_id' => 2, 'confirmed' => 0));
		Invitation::create(array('user_id' => 3, 'event_id' => 2, 'confirmed' => 1));
		Invitation::create(array('user_id' => 1, 'event_id' => 3, 'confirmed' => 1));
		Invitation::create(array('user_id' => 2, 'event_id' => 3, 'confirmed' => 1));
		Invitation::create(array('user_id' => 3, 'event_id' => 3, 'confirmed' => 1));
		Invitation::create(array('user_id' => 4, 'event_id' => 3, 'confirmed' => 1));
		Invitation::create(array('user_id' => 5, 'event_id' => 3, 'confirmed' => 0));
	}

}
