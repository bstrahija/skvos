<?php namespace App\Validation;

class UserUpdateValidator extends Validator {

	public static $rules = array(
		'email'      => 'required|email|unique:users',
		'first_name' => 'required',
		'last_name'  => 'required',
		'password'   => 'confirmed|min:6',
	);

	public static $messages = array(
		'email.unique' => 'Email adresa je zauzeta.',
	);

}
