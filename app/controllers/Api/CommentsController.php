<?php namespace App\Controllers\Api;

use Comments, Input, Response, Stats;

class CommentsController extends BaseController {

	public function index()
	{
		return Comments::all();
	}

	public function store()
	{
		if ($comment = Comments::create(Input::all()))
		{
			return Response::json($comment->toArray());
		}

		return Response::json(array('error' => true), 500);
	}

}
