<?php namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class GroupsFacade extends Facade {

	protected static function getFacadeAccessor()
	{
		return 'skvosh.group_repository';
	}

}
