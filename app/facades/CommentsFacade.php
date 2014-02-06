<?php namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class CommentsFacade extends Facade {

	protected static function getFacadeAccessor()
	{
		return 'skvosh.comment_repository';
	}

}
