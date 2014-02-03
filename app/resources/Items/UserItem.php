<?php namespace App\Resources\Items;

class UserItem extends BaseItem {

	/**
	 * Transform attributes
	 * @var array
	 */
	protected $transform = array(
		'photo' => 'image_manager',
	);

	/**
	 * Init new item
	 * @param array $data
	 */
	public function __construct($data = array())
	{
		parent::__construct($data);

		// And pivot data for invitation
		if (isset($this->data['pivot']) and isset($this->data['pivot']['confirmed']))
		{
			foreach ($this->data['pivot'] as $key => $pivot)
			{
				$this->data['invitation_'.$key] = $pivot;
			}
			unset($this->data['pivot']);
		}
	}

	/**
	 * Get user full name
	 * @return string
	 */
	public function getFullNameAttribute()
	{
		return $this->data['first_name'].' '.$this->data['last_name'];
	}

}
