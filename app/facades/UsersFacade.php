<?php namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class UsersFacade extends Facade {

	protected static function getFacadeAccessor()
	{
		return 'skvosh.user_repository';
	}

}
