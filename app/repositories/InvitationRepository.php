<?php namespace App\Repositories;

use Event, Mailer;
use App\Models\Invitation;
use App\Resources\Collections\InvitationCollection;
use App\Resources\Items\InvitationItem;
use App\Repositories\Interfaces\InvitationRepositoryInterface;

class InvitationRepository extends BaseRepository implements InvitationRepositoryInterface {

	/**
	 * Class for collections
	 * @var string
	 */
	protected $collectionClass = 'App\Resources\Collections\InvitationCollection';

	/**
	 * Class for single invitation
	 * @var string
	 */
	protected $itemClass = 'App\Resources\Items\InvitationItem';

	/**
	 * Return all invitations
	 * @return InvitationCollection
	 */
	public function all($options = null)
	{
		$invitations = Invitation::with(['event', 'user'])->get();

		return new InvitationCollection($invitations->toArray());
	}

	/**
	 * Return single invitation
	 * @return InvitationItem
	 */
	public function find($id, $options = null)
	{
		$invitation = Invitation::with(['event', 'user'])->where('id', $id)->first();

		if ($invitation) return new InvitationItem($invitation->toArray());
	}

	/**
	 * Return single invitation by hash
	 * @return InvitationItem
	 */
	public function findByHash($hash, $options = null)
	{
		$invitation = Invitation::with(['event', 'user'])->where('hash', $hash)->first();

		if ($invitation) return new InvitationItem($invitation->toArray());
	}

	/**
	 * Update invitation
	 * @param  int $id
	 * @param  array $data
	 * @return InvitationItem
	 */
	public function update($id, $data)
	{
		$invitation = Invitation::find($id);

		if ($invitation)
		{
			foreach ($data as $key => $val)
			{
				$invitation->$key = $val;
			}

			$invitation->save();

			return new InvitationItem($invitation->toArray());
		}
	}

	/**
	 * Confirm invitation
	 * @param  in $id
	 * @return bool
	 */
	public function confirm($id)
	{
		$invitation = Invitation::with(['event', 'user'])->where('id', $id)->first();

		if ($invitation)
		{
			$invitation->confirmed = 1;
			$invitation->cancelled = 0;
			$invitation->save();
			Event::fire('invitation.confirmed', $invitation);
			Mailer::sendConfirmation($invitation->id);

			return true;
		}

		return false;
	}

	/**
	 * Cancel invitation
	 * @param  in $id
	 * @return bool
	 */
	public function cancel($id)
	{
		$invitation = Invitation::with(['event', 'user'])->where('id', $id)->first();

		if ($invitation)
		{
			$invitation->confirmed = 0;
			$invitation->cancelled = 1;
			$invitation->save();
			Event::fire('invitation.cancelled', $invitation);
			Mailer::sendCancelation($invitation->id);

			return true;
		}

		return false;
	}

	/**
	 * Get event invitations
	 * @param  int $eventId
	 * @param  array $userIds
	 * @return InvitationCollection
	 */
	public function forEvent($eventId, $userIds = null)
	{
		if ($userIds) $invitations = Invitation::with(['event', 'user'])->where('event_id', $eventId)->whereIn('user_id', $userIds)->get();
		else          $invitations = Invitation::with(['event', 'user'])->where('event_id', $eventId)->where('sent', 0)->get();

		return new InvitationCollection($invitations->toArray());
	}

	/**
	 * Get invitation for user and event
	 * @param  int $eventId
	 * @param  int $userId
	 * @return InvitationItem
	 */
	public function forEventAndUser($eventId, $userId)
	{
		$invitation = Invitation::with(['event', 'user'])->where('event_id', $eventId)->where('user_id', $userId)->first();

		if ($invitation) return new InvitationItem($invitation->toArray());
	}

}
