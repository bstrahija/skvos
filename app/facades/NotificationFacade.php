<?php namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class NotificationFacade extends Facade {

	protected static function getFacadeAccessor()
	{
		return 'skvosh.notification';
	}

}
