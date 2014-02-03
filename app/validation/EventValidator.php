<?php namespace App\Validation;

class EventValidator extends Validator {

	public static $rules = array(
		'title'   => 'required',
		'date'    => 'required',
		'from'    => 'required',
		'to'      => 'required',
		'players' => 'required',
	);

}
