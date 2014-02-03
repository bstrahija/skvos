<?php namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class StatsFacade extends Facade {

	protected static function getFacadeAccessor()
	{
		return 'skvosh.stats';
	}

}
