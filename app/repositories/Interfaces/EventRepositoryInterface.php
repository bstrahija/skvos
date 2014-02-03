<?php namespace App\Repositories\Interfaces;

interface EventRepositoryInterface {

	public function all($options = null);
	public function upcoming($options = null);
	public function next($options = null);
	public function past($options = null);
	public function find($id, $options = null);

}
