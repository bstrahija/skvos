<?php namespace App\Controllers;

use App\Models\User;
use Auth, Input, Redirect, Request, View;

class AuthController extends BaseController {

	public function getLogin()
	{
		return View::make('auth.login');
	}

	public function postLogin()
	{
		$credentials = array(
			'email'    => Input::get('email'),
			'password' => Input::get('password')
		);

		if (Auth::attempt($credentials))
		{
			return Redirect::route('dashboard');
		}

		return Redirect::route('login')->withErrors(array('login' => 'Wrong username or password!'));
	}

	public function getLogout()
	{
		Auth::logout();

		return Redirect::to('login');
	}

}
