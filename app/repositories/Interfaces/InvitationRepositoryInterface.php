<?php namespace App\Repositories\Interfaces;

interface InvitationRepositoryInterface {

	public function all($options = null);
	public function find($id, $options = null);

}
