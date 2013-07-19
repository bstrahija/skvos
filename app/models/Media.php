<?php namespace App\Models;

use Eloquent;

class Media extends Eloquent {

	public $table = 'media';

	/**
	 * Polymorphic relation
	 * @return mixed
	 */
	public function mediable()
	{
		return $this->morphTo();
	}

}
