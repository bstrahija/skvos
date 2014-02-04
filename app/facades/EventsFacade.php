<?php namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class EventsFacade extends Facade {

	protected static function getFacadeAccessor()
	{
		return 'skvosh.event_repository';
	}

}
