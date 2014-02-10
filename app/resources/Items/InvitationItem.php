<?php namespace App\Resources\Items;

use App\Resources\Items\EventItem;
use App\Resources\Items\UserItem;

class InvitationItem extends \Creolab\Resources\Item {

	/**
	 * Init new item
	 * @param array $data
	 */
	public function __construct($data = array())
	{
		// Also create some custom collections or items
		if (isset($data['event'])) $data['event'] = new EventItem($data['event']);
		if (isset($data['user']))  $data['user']  = new UserItem($data['user']);

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
		if (isset($response['event'])) $response['event'] = $response['event']->toArray();
		if (isset($response['user']))  $response['user']  = $response['user']->toArray();

		return $response;
	}

}
