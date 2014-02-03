<?php namespace App\Resources\Items;

use Carbon, Str;

class BaseItem {

	/**
	 * Data for item
	 * @var array
	 */
	protected $data;

	/**
	 * Definitions for transforming data types
	 * @var array
	 */
	protected $transform = array();

	/**
	 * Default definitions for transforming data types
	 * @var array
	 */
	protected $transformDefault = array(
		'created_at' => 'parse_datetime',
		'updated_at' => 'parse_datetime',
		'deleted_at' => 'parse_datetime',
	);

	/**
	 * Init new item
	 * @param array $data
	 */
	public function __construct($data = array())
	{
		$this->data = $this->transformData($data);
	}

	/**
	 * Return property for item
	 * @param  string $key
	 * @return mixed
	 */
	public function __get($key)
	{
		$attrMethod = 'get' . Str::studly($key) . 'Attribute';

		if (method_exists($this, $attrMethod))
		{
			return $this->$attrMethod(array_get($this->data, $key));
		}
		else
		{
			return array_get($this->data, $key);
		}
	}

	/**
	 * Set a property
	 * @param string $key
	 * @param mixed  $val
	 */
	public function __set($key, $val)
	{
		$this->data[$key] = $val;
	}

	/**
	 * Return array representation of item
	 * @return array
	 */
	public function toArray()
	{
		$this->data = $this->transformDataBack($this->data);

		return $this->data;
	}

	/**
	 * Return JSON string of item data
	 * @return string
	 */
	public function toJson($options = 0)
	{
		return @json_encode($this->toArray(), $options);
	}

	/**
	 * Return JSON for string
	 * @return string
	 */
	public function __toString()
	{
		return $this->toJson();
	}

	/**
	 * Transform data types for item
	 * @param  array $data
	 * @param  array $rules
	 * @return array
	 */
	public function transformData($data, $rules = null)
	{
		// The rules
		if ( ! $rules) $rules = $this->transform;

		// Merge the default ones in
		$rules = array_merge($this->transformDefault, $rules);

		foreach ($rules as $key => $rule)
		{
			if (isset($data[$key]))
			{
				if     ($rule == 'parse_datetime')                $data[$key] = Carbon::parse($data[$key]);
				elseif ($rule == 'parse_time')                    $data[$key] = Carbon::parse($data[$key]);
				elseif ($rule == 'parse_date')                    $data[$key] = Carbon::parse($data[$key]);
				elseif (is_string($rule) and class_exists($rule)) $data[$key] = new $rule($data[$key]);
				elseif (is_array($rule))                          $data[$key] = $data[$key];
			}
		}

		return $data;
	}

	/**
	 * Transform back data types to array/string values
	 * @param  array $data
	 * @param  array $rules
	 * @return array
	 */
	public function transformDataBack($data, $rules = null)
	{
		// The rules
		if ( ! $rules) $rules = $this->transform;

		// Merge the default ones in
		$rules = array_merge($this->transformDefault, $rules);

		foreach ($rules as $key => $rule)
		{
			if (isset($data[$key]))
			{
				if     ($rule == 'parse_datetime' and is_a($data[$key], 'Carbon'))  $data[$key] = $data[$key]->format('Y-m-d H:i:s');
				elseif ($rule == 'parse_time' and is_a($data[$key], 'Carbon'))      $data[$key] = $data[$key]->format('H:i:s');
				elseif ($rule == 'parse_date' and is_a($data[$key], 'Carbon'))      $data[$key] = $data[$key]->format('Y-m-d');
				elseif (is_string($rule) and method_exists($data[$key], 'toArray')) $data[$key] = $data[$key]->toArray();
				// elseif (is_array($rule))       $data[$key] = $data[$key];
			}
		}

		return $data;
	}

}
