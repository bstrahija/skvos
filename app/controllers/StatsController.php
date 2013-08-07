<?php namespace App\Controllers;

use View;

class StatsController extends BaseController {

	public function getIndex()
	{
		$data = array(
			'matches_won' => 0,
			'matches_lost' => 0,
			'sets_won' => 0,
			'sets_lost' => 0,
		);

		return View::make('stats.index', $data);
	}

}
