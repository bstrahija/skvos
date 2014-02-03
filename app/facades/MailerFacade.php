<?php namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class MailerFacade extends Facade {

	protected static function getFacadeAccessor()
	{
		return 'skvosh.mailer';
	}

}
