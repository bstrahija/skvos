<?php

use App\Models\Match, Carbon\Carbon;

class MatchSeeder extends Seeder {

	public function run()
	{
		$eventId = 7;
		DB::table('matches')->delete();

		// ! Today
		Match::create(array('event_id' => $eventId, 'player1_id' => 1, 'player2_id' => 5, 'player1_sets_won' => 2, 'player2_sets_won' => 0, 'winner_id' => 1));
		Match::create(array('event_id' => $eventId, 'player1_id' => 1, 'player2_id' => 2, 'player1_sets_won' => 2, 'player2_sets_won' => 1, 'winner_id' => 1));
		Match::create(array('event_id' => $eventId, 'player1_id' => 2, 'player2_id' => 5, 'player1_sets_won' => 2, 'player2_sets_won' => 1, 'winner_id' => 2));

		Match::create(array('event_id' => $eventId, 'player1_id' => 1, 'player2_id' => 5, 'player1_sets_won' => 2, 'player2_sets_won' => 0, 'winner_id' => 1));
		Match::create(array('event_id' => $eventId, 'player1_id' => 1, 'player2_id' => 2, 'player1_sets_won' => 2, 'player2_sets_won' => 0, 'winner_id' => 1));
		Match::create(array('event_id' => $eventId, 'player1_id' => 2, 'player2_id' => 5, 'player1_sets_won' => 2, 'player2_sets_won' => 0, 'winner_id' => 2));

		Match::create(array('event_id' => $eventId, 'player1_id' => 1, 'player2_id' => 5, 'player1_sets_won' => 2, 'player2_sets_won' => 1, 'winner_id' => 1));
		Match::create(array('event_id' => $eventId, 'player1_id' => 1, 'player2_id' => 2, 'player1_sets_won' => 2, 'player2_sets_won' => 0, 'winner_id' => 1));
		Match::create(array('event_id' => $eventId, 'player1_id' => 2, 'player2_id' => 5, 'player1_sets_won' => 2, 'player2_sets_won' => 0, 'winner_id' => 2));

		Match::create(array('event_id' => $eventId, 'player1_id' => 1, 'player2_id' => 5, 'player1_sets_won' => 2, 'player2_sets_won' => 1, 'winner_id' => 1));
		Match::create(array('event_id' => $eventId, 'player1_id' => 1, 'player2_id' => 2, 'player1_sets_won' => 2, 'player2_sets_won' => 0, 'winner_id' => 1));
		Match::create(array('event_id' => $eventId, 'player1_id' => 2, 'player2_id' => 5, 'player1_sets_won' => 2, 'player2_sets_won' => 0, 'winner_id' => 2));


	}

}
