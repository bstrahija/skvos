<?php namespace App\Controllers;

use Auth, Input, Redirect, View;

class AuthController extends BaseController {

	/**
	 * Display login form
	 * @return View
	 */
	public function login()
	{
		return View::make('auth.login');
	}

	/**
	 * Attempt to login a user
	 * @return Redirect
	 */
	public function attempt()
	{
		if (Auth::attempt(Input::only('email', 'password'), true))
		{
			return Redirect::route('home');
		}

		return Redirect::route('login')->withInput()->withErrors(array('login' => trans('messages.Wrong email or password')));
	}

	/**
	 * Logout a user
	 * @return Redirect
	 */
	public function logout()
	{
		Auth::logout();

		return Redirect::to('login');
	}

}
