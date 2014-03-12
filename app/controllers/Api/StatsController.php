<?php namespace App\Controllers\Api;

use Events, App\Models\Stat, Input, Stats, Response;

class StatsController extends BaseController {

	/**
	 * Return data for chart
	 * @return Response
	 */
	public function userChart($userId)
	{
		$data  = array('labels' => [], 'datasets' => [array(), array()]);
		$limit = (int) Input::get('limit', 20);
		$matchStats = Stat::where('user_id', $userId)->where('type', 'player_event_match_efficiency')->orderBy('event_id')->take($limit)->get();
		$setStats   = Stat::where('user_id', $userId)->where('type', 'player_event_set_efficiency')->orderBy('event_id')->take($limit)->get();

		foreach ($matchStats as $key => $stat)
		{
			$data['labels'][$key]              = '.';
			$data['datasets'][0]['data'][$key] = $stat->value;
			$data['datasets'][1]['data'][$key] = $setStats[$key]->value;
		}

		// Colors

		$data['datasets'][0]['fillColor']        = "rgba(220,220,220,0.5)";
		$data['datasets'][0]['strokeColor']      = "rgba(220,220,220,1)";
		$data['datasets'][0]['pointColor']       = "rgba(220,220,220,1)";
		$data['datasets'][0]['pointStrokeColor'] = "#fff";
		$data['datasets'][1]['fillColor']        = "rgba(151,187,205,0.1)";
		$data['datasets'][1]['strokeColor']      = "rgba(151,187,205,0.4)";
		$data['datasets'][1]['pointColor']       = "rgba(151,187,205,0.4)";
		$data['datasets'][1]['pointStrokeColor'] = "#ddd";


		return $data;
	}

}
