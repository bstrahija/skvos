<?php namespace App\Controllers\Api;

use App\Repositories\UsersRepository;

class UsersController extends BaseController {

	/**
	 * Users repository
	 * @var UsersRepository
	 */
	protected $users;

	/**
	 * Init rependencies
	 * @param UsersRepository $users
	 */
	public function __construct(UsersRepository $users)
	{
		$this->users = $users;
	}

	/**
	 * Show all users
	 * @return Response
	 */
	public function index()
	{
		return $this->users->all();
	}

	/**
	 * Display single user
	 * @param  int $id
	 * @return Response
	 */
	public function show($id)
	{
		return $this->users->find($id);
	}

	/**
	 * Store new user
	 * @return Response
	 */
	public function store()
	{

	}

	/**
	 * Update existing user
	 * @param  int $id
	 * @return Response
	 */
	public function update($id)
	{

	}

	/**
	 * Delete an user
	 * @param  int $id
	 * @return Response
	 */
	public function destroy($id)
	{

	}

}
