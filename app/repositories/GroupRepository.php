<?php namespace App\Repositories;

use DB, Hash;
use App\Models\Group;
use App\Resources\Collections\GroupCollection;
use App\Resources\Items\GroupItem;
use App\Repositories\Interfaces\GroupRepositoryInterface;
use App\Validation\GroupValidator;
use App\Validation\GroupUpdateValidator;

class GroupRepository extends BaseRepository implements GroupRepositoryInterface {

	/**
	 * Class for collections
	 * @var string
	 */
	protected $collectionClass = 'App\Resources\Collections\GroupCollection';

	/**
	 * Class for single user
	 * @var string
	 */
	protected $itemClass = 'App\Resources\Items\GroupItem';

	/**
	 * Return all users
	 * @return UserCollection
	 */
	public function all($options = null)
	{
		$users = Group::with(['owner', 'members'])->get();

		return new GroupCollection($users->toArray());
	}

	/**
	 * Return single group
	 * @return groupItem
	 */
	public function find($id, $options = null)
	{
		$group = Group::find($id);

		if ($group) return new groupItem($group->toArray());
	}

	/**
	 * Return single group by nickname
	 * @return groupItem
	 */
	public function findByNickname($nickname, $options = null)
	{
		$group = group::where(DB::raw("LOWER(nickname)"), DB::raw("LOWER('$nickname')"))->first();

		if ($group) return new groupItem($group->toArray());
	}

	/**
	 * Create new group
	 * @param  arra $data
	 * @return groupItem
	 */
	public function create($data)
	{

	}

	/**
	 * Update existing group
	 * @param  int   $id
	 * @param  array $data
	 * @return groupItem
	 */
	public function update($id, $data)
	{
		// Get group and set validation
		$group       = group::find($id);
		$validation = new groupUpdateValidator($data, ['email' => 'unique:groups,email,'.$group->id]);

		if ($validation->passes())
		{
			$group->email      = array_get($data, 'email');
			$group->first_name = array_get($data, 'first_name');
			$group->last_name  = array_get($data, 'last_name');

			// Update password only if passed
			if ($password = array_get($data, 'password'))
			{
				$group->password = Hash::make($password);
			}

			// Also update photo only if any uploaded
			try {
				if ($photo = array_get($data, 'photo'))
				{
					$target = public_path('storage/avatars');
					$ext    = $photo->getClientOriginalExtension();
					$name   = 'avatar_' . $group->id . '.' . $ext;

					if (in_array($ext, ['gif', 'jpg', 'jpeg', 'png']))
					{
						$photo->move($target, $name);
					}

					// Assign value
					$group->photo = 'storage/avatars/'.$name;
				}
			}
			catch(\Exception $e)
			{
				\Log::error($e);
			}

			// Save data
			$group->save();

			return new groupItem($group->toArray());
		}

		$this->errors = $validation->errors();

		return false;
	}

}
