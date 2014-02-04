<?php namespace App\Controllers;

use App, Auth, Input, Groups, Redirect, Users, View;

class GroupsController extends BaseController {

	/**
	 * Overview of all groups
	 * @return View
	 */
	public function index()
	{
		$groups = Groups::all();

		return View::make('groups.index')->withGroups($groups);
	}

}
