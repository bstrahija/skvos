<?php namespace App\Controllers;

use View;

class AppController extends \Controller {

	public function index()
	{
		return View::make('app');
	}

}
