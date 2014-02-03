<?php namespace App\Resources\Collections;

use Illuminate\Support\Collection;

class BaseCollection extends Collection {

	/**
	 * Single item class
	 * @var string
	 */
	protected $item = '\App\Resources\Items\BaseItem';

	/**
	 * Init collection with items
	 * @param Array $items
	 */
	public function __construct(Array $items)
	{
		foreach ($items as $key => $item)
		{
			$this->put($key, new $this->item($item));
		}
	}

	/**
	 * Return collection as array
	 * @return array
	 */
	public function toArray()
	{
		$response = array();

		foreach ($this->items as $key => $item)
		{
			$response[] = $item->toArray();
		}

		return $response;
	}

	/**
	 * Return JSON for collection
	 * @return string
	 */
	public function toJson($options = 0)
	{
		return @json_encode($this->toArray(), $options);
	}

	/**
	 * JSON for string
	 * @return string
	 */
	public function __toString()
	{
		return $this->toJson();
	}

}
