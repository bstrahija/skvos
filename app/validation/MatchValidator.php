<?php namespace App\Validation;

class MatchValidator extends Validator {

	public static $rules = array(
		'event_id'      => 'required',
		'player1_id'    => 'required',
		'player2_id'    => 'required',
		'player1_score' => 'required',
		'player2_score' => 'required',
	);

}
