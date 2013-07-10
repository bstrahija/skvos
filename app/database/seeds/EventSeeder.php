<?php

use App\Models\Event, Carbon\Carbon;

class EventSeeder extends Seeder {

	public function run()
	{
		DB::table('events')->delete();

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
	}

}
