<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// ! Auth routes
Route::get('login',  array('as' => 'login',      'uses' => 'App\Controllers\AuthController@getLogin'));
Route::post('login', array('as' => 'login.post', 'uses' => 'App\Controllers\AuthController@postLogin'));
Route::get('logout', array('as' => 'logout',     'uses' => 'App\Controllers\AuthController@getLogout'));

// ! App routes
Route::group(array('before' => 'auth'), function()
{
	Route::get('/',                  array('as' => 'dashboard', 'uses' => 'App\Controllers\DashboardController@getIndex'));

	// ! --> Resources
	Route::resource('media',         'App\Controllers\MediaController');
	Route::resource('events',        'App\Controllers\EventsController');
	Route::resource('matches',       'App\Controllers\MatchesController');
	Route::resource('users',         'App\Controllers\UsersController');

	// ! --> Stats
	Route::get('stats',         array('as' => 'stats',         'uses' => 'App\Controllers\StatsController@getIndex'));
	Route::any('stats/players', array('as' => 'stats.players', 'uses' => 'App\Controllers\StatsController@getPlayers'));

	// ! --> Settings
	Route::get('settings', array('as' => 'settings',  'uses' => 'App\Controllers\SettingsController@getIndex', 'before' => 'admin'));
});

// Outside of the main group because of confirmations
Route::controller('invitations', 'App\Controllers\InvitationsController');

// Event confirmations (via hash)
Route::get('invitations/confirm/{hash}', array('as' => 'invitations.confirm', 'uses' => 'App\Controllers\InvitationsController@getConfirm'));

// ! Custom 404 view
App::missing(function($exception)
{
	return Response::view('404', array(), 404);
});
