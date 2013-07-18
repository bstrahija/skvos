<?php namespace App\Models;

use Auth;
use Eloquent;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	public static $rules = array(
		'email'      => 'required|email',
		'first_name' => 'required',
		'last_name'  => 'required',
		'role'       => 'required',
		'password'   => 'required|min:6',
	);

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	public function invitations()
	{
		return $this->belongsTo('App\Models\User');
	}

	public function invitation()
	{
		return $this->belongsTo('App\Models\User');
	}

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

	/**
	 * Check if user is an admin
	 * @param  int     $userId
	 * @return boolean
	 */
	public static function isAdmin($userId = null)
	{
		// Get user object
		if ($userId) $user = self::find($userId);
		else         $user = Auth::user();

		// Not check the role
		if ($user and ($user->role == 'admin' or $user->role == 'superadmin')) return true;

		return false;
	}

	/**
	 * Check if user is an admin
	 * @param  int     $userId
	 * @return boolean
	 */
	public static function isSuperadmin($userId = null)
	{
		// Get user object
		if ($userId) $user = self::find($userId);
		else         $user = Auth::user();

		// Not check the role
		if ($user and ($user->role == 'superadmin')) return true;

		return false;
	}

	/**
	 * Full name accessor
	 * @return string
	 */
	public function getFullNameAttribute()
	{
		return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
	}

	/**
	 * Get if user confirmed invitation to event
	 * @return mixed
	 */
	public function getConfirmedAttribute()
	{
		if (isset($this->pivot->confirmed) and $this->pivot->confirmed) return $this->pivot->confirmed;

		return false;
	}

	/**
	 * Get if user confirmed invitation to event
	 * @return mixed
	 */
	public function getCancelledAttribute()
	{
		if (isset($this->pivot->cancelled) and $this->pivot->cancelled) return $this->pivot->cancelled;

		return false;
	}

	/**
	 * Get the invitation was sent to the user
	 * @return mixed
	 */
	public function getSentAttribute()
	{
		if (isset($this->pivot->sent) and $this->pivot->sent) return $this->pivot->sent;

		return false;
	}

	/**
	 * Check is user owns event
	 * @param  int    $eventId
	 * @return boolean
	 */
	public static function ownsEvent($eventId)
	{
		$event = Event::find($eventId);

		if ($event)
		{
			if ($event->author->id == Auth::user()->id) return true;
		}

		return true;
	}

}
