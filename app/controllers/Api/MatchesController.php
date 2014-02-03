<?php namespace App\Controllers\Api;

use Input, Response;
use App\Repositories\MatchRepository;

class MatchesController extends BaseController {

	/**
	 * Match repository
	 * @var MatchRepository
	 */
	protected $matches;

	/**
	 * Init rependencies
	 * @param MatchRepository $matches
	 */
	public function __construct(MatchRepository $matches)
	{
		$this->matches = $matches;
	}

	/**
	 * Show all events
	 * @return Response
	 */
	public function index()
	{
		return $this->matches->all(Input::all());
	}

	/**
	 * Display single event
	 * @param  int $id
	 * @return Response
	 */
	public function show($id)
	{
		return $this->matches->find($id);
	}

	/**
	 * Store new event
	 * @return Response
	 */
	public function store()
	{
		if ($match = $this->matches->create(Input::all()))
		{
			return Response::json($match->toArray());
		}

		return Response::json(array('error' => 'true', 'message' => 'Not created.'), 500);
	}

	/**
	 * Update existing event
	 * @param  int $id
	 * @return Response
	 */
	public function update($id)
	{

	}

	/**
	 * Delete an event
	 * @param  int $id
	 * @return Response
	 */
	public function destroy($id)
	{

	}

}
