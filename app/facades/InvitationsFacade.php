<?php namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class InvitationsFacade extends Facade {

	protected static function getFacadeAccessor()
	{
		return 'skvosh.invitation_repository';
	}

}
