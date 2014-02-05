<?php namespace App\Controllers;

use Auth, Input, Redirect, Users, View;

class UsersController extends BaseController {

	/**
	 * Init
	 */
	public function __construct()
	{
		$this->beforeFilter('admin', ['except' => ['profile', 'update']]);
	}

	/**
	 * List all players/users
	 * @return View
	 */
	public function index()
	{
		$users = Users::all(Input::all());

		return View::make('users.index')->withUsers($users);
	}

	/**
	 * Form for creating a new user
	 * @return View
	 */
	public function create()
	{
		return View::make('users.create');
	}

	/**
	 * Store a new user
	 * @return Redirect
	 */
	public function store()
	{
		if ($user = Users::create(Input::all()))
		{
			return Redirect::route('users.edit', $user->id)->withAlertSuccess('Spremljeno.');
		}

		return Redirect::back()->withErrors(Users::errors())->withInput();
	}

	/**
	 * Show profile
	 * @return View
	 */
	public function profile()
	{
		$user = Users::find(Auth::user()->id);

		return View::make('users.profile')->withUser($user);
	}

	/**
	 * Edit user data
	 * @param  int $id
	 * @return View
	 */
	public function edit($id)
	{
		$user = Users::find($id);

		return View::make('users.edit')->withUser($user);
	}

	/**
	 * Update a user
	 * @param  int $id
	 * @return Redirect
	 */
	public function update($id)
	{
		if (Users::update($id, Input::all()))
		{
			return Redirect::route('profile')->withAlertSuccess('Spremljeno.');
		}

		return Redirect::back()->withErrors(Users::errors())->withInput();
	}

}
