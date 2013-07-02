<?php namespace App\Controllers;

use Redirect, Request, View;

class DashboardController extends BaseController {

	public function getIndex()
	{
		return View::make('dashboard.index');
	}

}
