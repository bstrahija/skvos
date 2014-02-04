<?php namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class MatchesFacade extends Facade {

	protected static function getFacadeAccessor()
	{
		return 'skvosh.match_repository';
	}

}
