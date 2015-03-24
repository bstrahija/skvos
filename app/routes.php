<?php

/* ! Auth routes */
Route::get('login',  ['as' => 'login',         'uses' => 'App\Controllers\AuthController@login']);
Route::post('login', ['as' => 'login.attempt', 'uses' => 'App\Controllers\AuthController@attempt']);
Route::get('logout', ['as' => 'logout',        'uses' => 'App\Controllers\AuthController@logout']);

// ! Public routes
Route::get('showcase/{nickname}',          ['as' => 'showcase',                 'uses' => 'App\Controllers\DashboardController@showcase']);
Route::get('showcase/{nickname}/{event}',  ['as' => 'showcase.event',           'uses' => 'App\Controllers\DashboardController@showcaseEvent']);
Route::get('events/results/{hash}',        ['as' => 'events.public.stats',      'uses' => 'App\Controllers\EventsController@results']);
Route::get('invitations/confirm/{hash}',   ['as' => 'invitations.confirm',      'uses' => 'App\Controllers\InvitationsController@preconfirm']);
Route::post('invitations/confirm/{hash}',  ['as' => 'invitations.confirm.post', 'uses' => 'App\Controllers\InvitationsController@confirm']);

/* ! Main routes */
Route::group(array('before' => 'auth'), function()
{
	// Custom
	Route::get('/',                         ['as' => 'home',                     'uses' => 'App\Controllers\DashboardController@index']);
	Route::get('profil',                    ['as' => 'profile',                  'uses' => 'App\Controllers\UsersController@profile']);
	Route::get('stats',                     ['as' => 'stats',                    'uses' => 'App\Controllers\StatsController@index']);
	Route::get('stats/my',                  ['as' => 'stats.my',                 'uses' => 'App\Controllers\StatsController@my']);
	Route::get('stats/players',             ['as' => 'stats.players',            'uses' => 'App\Controllers\StatsController@players']);
	Route::get('stats/generate',            ['as' => 'stats.generate',           'uses' => 'App\Controllers\StatsController@generate']);
	Route::get('events/mvps',               ['as' => 'events.mvps',              'uses' => 'App\Controllers\EventsController@mvps']);
	Route::get('events/{id}/matches',       ['as' => 'events.matches',           'uses' => 'App\Controllers\EventsController@matches']);
	Route::get('invitations/{event}/send',  ['as' => 'invitations.send.preview', 'uses' => 'App\Controllers\InvitationsController@presend']);
	Route::post('invitations/{event}/send', ['as' => 'invitations.send',         'uses' => 'App\Controllers\InvitationsController@send']);
	Route::get('events/hashes',             ['as' => 'events.hashes',            'uses' => 'App\Controllers\EventsController@hashes']);
	Route::get('comments/items/{event}',    ['as' => 'comments.items',           'uses' => 'App\Controllers\CommentsController@items']);
	Route::get('comments/create/{event}',   ['as' => 'comments.create',          'uses' => 'App\Controllers\CommentsController@create']);

	// Resources
	Route::resource('events',      'App\Controllers\EventsController');
	Route::resource('matches',     'App\Controllers\MatchesController');
	Route::resource('invitations', 'App\Controllers\InvitationsController');
	Route::resource('users',       'App\Controllers\UsersController');
	Route::resource('groups',      'App\Controllers\GroupsController');

	/* ! API routes */
	Route::group(array('prefix' => 'api'), function()
	{
		// API home
		Route::get('/', ['as' => 'api', function() { return array('Skvosh.in API v1.0.0'); }]);

		// Events
		Route::get('events/upcoming',       ['as' => 'events.upcoming', 'uses' => 'App\Controllers\Api\EventsController@upcoming']);
		Route::get('events/past',           ['as' => 'events.past',     'uses' => 'App\Controllers\Api\EventsController@past']);
		Route::get('events/next',           ['as' => 'events.next',     'uses' => 'App\Controllers\Api\EventsController@next']);
		Route::get('events/home',           ['as' => 'events.home',     'uses' => 'App\Controllers\Api\EventsController@home']);
		Route::get('events/{id}/matches',   ['as' => 'events.matches', 'uses' => 'App\Controllers\Api\EventsController@matches']);
		Route::get('stats/user-chart/{id}', ['as' => 'events.matches', 'uses' => 'App\Controllers\Api\StatsController@userChart']);
		Route::resource('events',           'App\Controllers\Api\EventsController');

		// Comments
		Route::resource('comments',    'App\Controllers\Api\CommentsController');

		// Matches
		Route::resource('matches',     'App\Controllers\Api\MatchesController');

		// Invitations
		Route::post('invitations/confirm/{id}', 'App\Controllers\Api\InvitationsController@confirm');
		Route::post('invitations/cancel/{id}',  'App\Controllers\Api\InvitationsController@cancel');
		Route::resource('invitations',          'App\Controllers\Api\InvitationsController');

		// Users
		Route::resource('users',       'App\Controllers\Api\UsersController');
		Route::resource('groups',      'App\Controllers\Api\GroupController');
	});
});



// ! Custom 404 view
App::missing(function($exception)
{
	return Response::view('errors.404', array(), 404);
});
