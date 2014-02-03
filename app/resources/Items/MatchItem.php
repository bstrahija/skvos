<?php namespace App\Resources\Items;

use App\Resources\Collections\MatchCollection;
use App\Resources\Collections\UserCollection;

class MatchItem extends BaseItem {

	/**
	 * Init new item
	 * @param array $data
	 */
	public function __construct($data = array())
	{
		// Some extra params
		if (isset($data['player1']))   $data['player1']   = new UserItem($data['player1']);
		if (isset($data['player2']))   $data['player2']   = new UserItem($data['player2']);
		if (isset($data['winner']))    $data['winner']    = new UserItem($data['winner']);
		if (isset($data['event']))     $data['event']     = new EventItem($data['event']);

		// Add to data
		$this->data = $data;
	}

	/**
	 * Return array of item
	 * @return array
	 */
	public function toArray()
	{
		$response = $this->data;

		// Convert more data
		if (isset($response['player1'])) $response['player1'] = $response['player1']->toArray();
		if (isset($response['player2'])) $response['player2'] = $response['player2']->toArray();
		if (isset($response['winner']))  $response['winner']  = $response['winner']->toArray();
		if (isset($response['event']))   $response['event']   = $response['event']->toArray();

		return $response;
	}

}
