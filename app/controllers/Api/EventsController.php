<?php namespace App\Controllers\Api;

use Input, Response;
use App\Repositories\EventRepository;

class EventsController extends BaseController {

	/**
	 * Event repository
	 * @var EventRepository
	 */
	protected $events;

	/**
	 * Init rependencies
	 * @param EventRepository $events
	 */
	public function __construct(EventRepository $events)
	{
		$this->events = $events;
	}

	/**
	 * Show all events
	 * @return Response
	 */
	public function index()
	{
		return Response::json($this->events->all(Input::all()));
	}

	/**
	 * Return some combined events
	 * @return Response
	 */
	public function home()
	{
		$response = $this->events->home(Input::all());

		return Response::json($response);
	}

	/**
	 * Get single next event
	 * @return Response
	 */
	public function next()
	{
		return Response::json($this->events->next());
	}

	/**
	 * Get all upcoming events
	 * @return Response
	 */
	public function upcoming()
	{
		return Response::json($this->events->upcoming(['limit' => 5]));
	}

	/**
	 * Get all past events
	 * @return Response
	 */
	public function past()
	{
		return Response::json($this->events->past(['limit' => 5]));
	}

	/**
	 * Display single event
	 * @param  int $id
	 * @return Response
	 */
	public function show($id)
	{
		return Response::json($this->events->find($id)->toArray());
	}

	/**
	 * Get all matches for this event
	 * @param  int $eventId
	 * @return Response
	 */
	public function matches($eventId)
	{
		return Response::json($this->events->matches($eventId)->toArray());
	}

	/**
	 * Store new event
	 * @return Response
	 */
	public function store()
	{

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
