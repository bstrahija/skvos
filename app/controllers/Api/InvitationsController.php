<?php namespace App\Controllers\Api;

use Response;
use App\Repositories\InvitationRepository;

class InvitationsController extends BaseController {

	/**
	 * Invitation repository
	 * @var InvitationRepository
	 */
	protected $invitations;

	/**
	 * Init dependencies
	 * @param InvitationRepository $invitations
	 */
	public function __construct(InvitationRepository $invitations)
	{
		$this->invitations = $invitations;
	}

	/**
	 * Single invitation
	 * @param  int $id
	 * @return Response
	 */
	public function show($id)
	{
		$invite = $this->invitations->find($id);

		return $invite;
	}

	/**
	 * Confirm invitation
	 * @param  int $id
	 * @return Response
	 */
	public function confirm($id)
	{
		if ($this->invitations->confirm($id))
		{
			return Response::json(array('success' => true));
		}

		return Response::json(array('error' => true), 500);
	}

}
