<?php namespace App\Repositories;

use DB, Hash;
use App\Models\User;
use App\Resources\Collections\UserCollection;
use App\Resources\Items\UserItem;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Validation\UserValidator;
use App\Validation\UserUpdateValidator;

class UserRepository extends BaseRepository implements UserRepositoryInterface {

	/**
	 * Class for collections
	 * @var string
	 */
	protected $collectionClass = 'App\Resources\Collections\UserCollection';

	/**
	 * Class for single user
	 * @var string
	 */
	protected $itemClass = 'App\Resources\Items\UserItem';

	/**
	 * Return all users
	 * @return UserCollection
	 */
	public function all($options = null)
	{
		$users = User::all();

		return new UserCollection($users->toArray());
	}

	/**
	 * Return single user
	 * @return UserItem
	 */
	public function find($id, $options = null)
	{
		$user = User::find($id);

		if ($user) return new UserItem($user->toArray());
	}

	/**
	 * Return single user by nickname
	 * @return UserItem
	 */
	public function findByNickname($nickname, $options = null)
	{
		$user = User::where(DB::raw("LOWER(nickname)"), DB::raw("LOWER('$nickname')"))->first();

		if ($user) return new UserItem($user->toArray());
	}

	/**
	 * Create new user
	 * @param  arra $data
	 * @return UserItem
	 */
	public function create($data)
	{

	}

	/**
	 * Update existing user
	 * @param  int   $id
	 * @param  array $data
	 * @return UserItem
	 */
	public function update($id, $data)
	{
		// Get user and set validation
		$user       = User::find($id);
		$validation = new UserUpdateValidator($data, ['email' => 'unique:users,email,'.$user->id]);

		if ($validation->passes())
		{
			$user->email      = array_get($data, 'email');
			$user->first_name = strip_tags(array_get($data, 'first_name'));
			$user->last_name  = strip_tags(array_get($data, 'last_name'));

			// Update password only if passed
			if ($password = array_get($data, 'password'))
			{
				$user->password = Hash::make($password);
			}

			// Also update photo only if any uploaded
			try {
				if ($photo = array_get($data, 'photo'))
				{
					$target = public_path('storage/avatars');
					$ext    = $photo->getClientOriginalExtension();
					$name   = 'avatar_' . $user->id . '.' . $ext;

					if (in_array($ext, ['gif', 'jpg', 'jpeg', 'png']))
					{
						$photo->move($target, $name);
					}

					// Assign value
					$user->photo = 'storage/avatars/'.$name;
				}
			}
			catch(\Exception $e)
			{
				\Log::error($e);
			}

			// Save data
			$user->save();

			return new UserItem($user->toArray());
		}

		$this->errors = $validation->errors();

		return false;
	}

}
