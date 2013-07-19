<?php namespace App\Controllers;

use App\Models\User;
use Auth, Input, Redirect, Request, View;

class AuthController extends BaseController {

	/**
	 * Display login screen
	 * @return View
	 */
	public function getLogin()
	{
		return View::make('auth.login');
	}

	/**
	 * Attempt to login with credentials
	 * @return Redirect
	 */
	public function postLogin()
	{
		$credentials = array(
			'email'    => Input::get('email'),
			'password' => Input::get('password')
		);

		if (Auth::attempt($credentials, true))
		{
			return Redirect::route('dashboard');
		}

		return Redirect::route('login')->withErrors(array('login' => 'Wrong username or password!'));
	}

	/**
	 * Terminate user session
	 * @return Redirect
	 */
	public function getLogout()
	{
		Auth::logout();

		return Redirect::to('login');
	}

}
