<?php namespace App\Controllers;

use Auth, Input, Redirect, View;
use App\Repositories\UserRepository;

class UsersController extends BaseController {

	/**
	 * User repository
	 * @var UserRepository
	 */
	protected $users;

	/**
	 * Init dependencies
	 * @param UserRepository $users
	 */
	public function __construct(UserRepository $users)
	{
		$this->users = $users;

		// Filters
		$this->beforeFilter('admin', ['except' => ['profile', 'update']]);
	}

	/**
	 * List all players/users
	 * @return View
	 */
	public function index()
	{
		$users = $this->users->all(Input::all());

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
		if ($user = $this->users->create(Input::all()))
		{
			return Redirect::route('users.edit', $user->id)->withAlertSuccess('Spremljeno.');
		}

		return Redirect::back()->withErrors($this->users->errors())->withInput();
	}

	/**
	 * Show profile
	 * @return View
	 */
	public function profile()
	{
		$user = $this->users->find(Auth::user()->id);

		return View::make('users.profile')->withUser($user);
	}

	/**
	 * Edit user data
	 * @param  int $id
	 * @return View
	 */
	public function edit($id)
	{
		$user = $this->users->find($id);

		return View::make('users.edit')->withUser($user);
	}

	/**
	 * Update a user
	 * @param  int $id
	 * @return Redirect
	 */
	public function update($id)
	{
		if ($this->users->update($id, Input::all()))
		{
			return Redirect::route('profile')->withAlertSuccess('Spremljeno.');
		}

		return Redirect::back()->withErrors($this->users->errors())->withInput();
	}

}
