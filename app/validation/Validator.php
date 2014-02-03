<?php namespace App\Validation;

use Validator as V;

abstract class Validator {

	/**
	 * Input data
	 * @var array
	 */
	protected $input = array();

	/**
	 * Validation rules
	 * @var array
	 */
	protected static $rules = array();

	/**
	 * Custom error messages
	 * @var array
	 */
	protected static $messages = array();

	/**
	 * COntainer for all errors
	 * @var mixed
	 */
	public $errors;

	/**
	 * Init new validator with optional data
	 * @param array $input
	 */
	public function __construct($input = null, $rules = null, $messages = null)
	{
		if ($input)    $this->input = $input;
		if ($rules)    static::$rules = array_merge(static::$rules, $rules);
		if ($messages) static::$messages = array_merge(static::$messages, $messages);
	}

	/**
	 * Run validation
	 * @param  array $input
	 * @return bool
	 */
	public function passes($input = null)
	{
		// Assign input data
		if ($input) $this->input = $input;

		// Create validator
		$validation = V::make($this->input, static::$rules, static::$messages);

		// Run validation
		if ($validation->fails())
		{
			$this->errors = $validation->messages();

			return false;
		}

		return true;
	}

	/**
	 * Check if validation fails
	 * @param  array $input
	 * @return bool
	 */
	public function fails($input)
	{
		if ( ! $this->passes($input)) return true;

		return false;
	}

	/**
	 * Get validation errrors
	 * @return MessageBag
	 */
	public function errors()
	{
		return $this->errors;
	}

}
