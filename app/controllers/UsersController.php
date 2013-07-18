<?php namespace App\Controllers;

use App\Models\User;
use Auth, Hash, Input, Notification, Redirect, Request, Str, Validator, View;

class UsersController extends BaseController {

	public function index()
	{
		return View::make('users.index', array('users' => User::orderBy('first_name')->get()));
	}

	public function create()
	{
		return View::make('users.create');
	}

	public function store()
	{
		// Create validator
		$validator = Validator::make(Input::all(), User::$rules);

		// Failed validation
		if ($validator->fails()) return Redirect::back()->withErrors($validator)->withInput();

		// Save it
		$user = new User;
		$user->email      = Input::get('email');
		$user->first_name = Input::get('first_name');
		$user->last_name  = Input::get('last_name');
		$user->role       = Input::get('role', 'player');
		$user->password   = Hash::make(Input::get('password'));
		$user->save();

		Notification::success('Korisnik je spremljen.');
		return Redirect::route('users.edit', $user->id);
	}

	public function edit($id)
	{
		return View::make('users.edit', array('user' => User::find($id)));
	}

	public function update($id)
	{
		// Addapt rules
		User::$rules['password'] = 'min:5';

		// Create validator
		$validator = Validator::make(Input::all(), User::$rules);

		// Failed validation
		if ($validator->fails()) return Redirect::back()->withErrors($validator)->withInput();

		// Save it
		$user = User::find($id);
		$user->email      = Input::get('email');
		$user->first_name = Input::get('first_name');
		$user->last_name  = Input::get('last_name');
		$user->role       = Input::get('role');

		// Change password
		if ($password = Input::get('password')) $user->password = Hash::make($password);

		// And save it
		$user->save();

		Notification::success('Korisnik je spremljen.');
		return Redirect::route('users.edit', $id);
	}

	public function delete($id)
	{

	}

}
