<?php namespace App\Repositories\Interfaces;

interface CommentRepositoryInterface {

	public function all($options = null);
	public function find($id, $options = null);
	public function create($data);

}
