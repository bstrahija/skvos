<?php namespace App\Repositories\Interfaces;

interface UserRepositoryInterface {

	public function all($options = null);
	public function find($id, $options = null);
	public function create($data);
	public function update($id, $data);

}
