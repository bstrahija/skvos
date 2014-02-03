<?php

/* ! Auth routes */
Route::get('login',  ['as' => 'login',         'uses' => 'App\Controllers\AuthController@login']);
Route::post('login', ['as' => 'login.attempt', 'uses' => 'App\Controllers\AuthController@attempt']);
Route::get('logout', ['as' => 'logout',        'uses' => 'App\Controllers\AuthController@logout']);

/* ! Main routes */
Route::group(array('before' => 'auth'), function()
{
	// Custom
	Route::get('/',                         ['as' => 'home',                     'uses' => 'App\Controllers\DashboardController@index']);
	Route::get('profil',                    ['as' => 'profile',                  'uses' => 'App\Controllers\UsersController@profile']);
	Route::get('stats',                     ['as' => 'stats',                    'uses' => 'App\Controllers\StatsController@index']);
	Route::get('stats/my',                  ['as' => 'stats.my',                 'uses' => 'App\Controllers\StatsController@my']);
	Route::get('stats/players',             ['as' => 'stats.players',            'uses' => 'App\Controllers\StatsController@players']);
	Route::get('events/mvps',               ['as' => 'events.mvps',              'uses' => 'App\Controllers\EventsController@mvps']);
	Route::get('events/{id}/matches',       ['as' => 'events.matches',           'uses' => 'App\Controllers\EventsController@matches']);
	Route::get('invitations/{event}/send',  ['as' => 'invitations.send.preview', 'uses' => 'App\Controllers\InvitationsController@presend']);
	Route::post('invitations/{event}/send', ['as' => 'invitations.send',         'uses' => 'App\Controllers\InvitationsController@send']);

	// Resources
	Route::resource('events',      'App\Controllers\EventsController');
	Route::resource('matches',     'App\Controllers\MatchesController');
	Route::resource('invitations', 'App\Controllers\InvitationsController');
	Route::resource('users',       'App\Controllers\UsersController');

	/* ! API routes */
	Route::group(array('prefix' => 'api'), function()
	{
		// API home
		Route::get('/', ['as' => 'api', function() { return array('Skvosh.in API v1.0.0'); }]);

		// Events
		Route::get('events/upcoming',     ['as' => 'events.upcoming', 'uses' => 'App\Controllers\Api\EventsController@upcoming']);
		Route::get('events/past',         ['as' => 'events.past',     'uses' => 'App\Controllers\Api\EventsController@past']);
		Route::get('events/next',         ['as' => 'events.next',     'uses' => 'App\Controllers\Api\EventsController@next']);
		Route::get('events/home',         ['as' => 'events.home',     'uses' => 'App\Controllers\Api\EventsController@home']);
		Route::get('events/{id}/matches', ['as' => 'events.matches', 'uses' => 'App\Controllers\Api\EventsController@matches']);
		Route::resource('events',         'App\Controllers\Api\EventsController');

		// Matches
		Route::resource('matches',     'App\Controllers\Api\MatchesController');

		// Invitations
		Route::post('invitations/confirm/{id}', 'App\Controllers\Api\InvitationsController@confirm');
		Route::resource('invitations',          'App\Controllers\Api\InvitationsController');

		// Users
		Route::resource('users',       'App\Controllers\Api\UsersController');
	});
});

// ! Public routes
Route::get('showcase/{nickname}',          ['as' => 'showcase',                 'uses' => 'App\Controllers\DashboardController@showcase']);
Route::get('event-stats/{hash}',           ['as' => 'events.public.stats',      'uses' => 'App\Controllers\EventsController@publicStats']);
Route::get('event-stats/{hash}',           ['as' => 'events.public.stats',      'uses' => 'App\Controllers\EventsController@publicStats']);
Route::get('users/{nickname}/stats',       ['as' => 'users.public.stats',       'uses' => 'App\Controllers\UsersController@publicStats']);
Route::get('users/{nickname}/event-stats', ['as' => 'users.public.event_stats', 'uses' => 'App\Controllers\UsersController@publicEventStats']);
Route::get('invitations/confirm/{hash}',   ['as' => 'invitations.confirm',      'uses' => 'App\Controllers\InvitationsController@preconfirm']);
Route::post('invitations/confirm/{hash}',  ['as' => 'invitations.confirm.post', 'uses' => 'App\Controllers\InvitationsController@confirm']);




// ! Custom 404 view
App::missing(function($exception)
{
	return Response::view('errors.404', array(), 404);
});
