<?php namespace App\Resources\Items;

use Carbon;
use App\Resources\Items\UserItem;

class CommentItem extends BaseItem {

	/**
	 * Transform attributes
	 * @var array
	 */
	protected $transform = array(
		'author'    => 'App\Resources\Items\UserItem',
	);

}
