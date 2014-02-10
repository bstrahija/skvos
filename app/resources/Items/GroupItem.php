<?php namespace App\Resources\Items;

class GroupItem extends \Creolab\Resources\Item {

	/**
	 * Transform attributes
	 * @var array
	 */
	protected $transform = array(
		'owner'   => 'App\Resources\Items\UserItem',
		'members' => 'App\Resources\Collections\UserCollection',
	);

}
