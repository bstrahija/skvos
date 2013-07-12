<?php

use App\Models\Match, Carbon\Carbon;

class MatchSeeder extends Seeder {

	public function run()
	{
		DB::table('matches')->delete();

		// ! Today
		Match::create(array('event_id' => 2, 'player1_id' => 1, 'player2_id' => 5, 'player1_sets_won' => 2, 'player1_sets_won' => 0, 'winner_id' => 1));


	}

}
