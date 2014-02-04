<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SkvoshServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application events.
	 * @return void
	 */
	public function boot()
	{
		// Register IoC bindings
		$this->app->bind('skvosh.stats',  'App\Services\Stats');
		$this->app->bind('skvosh.mailer', 'App\Services\Mailer');

		// Also for repositories
		$this->app->bind('skvosh.event_repository',      'App\Repositories\EventRepository');
		$this->app->bind('skvosh.group_repository',      'App\Repositories\GroupRepository');
		$this->app->bind('skvosh.invitation_repository', 'App\Repositories\InvitationRepository');
		$this->app->bind('skvosh.match_repository',      'App\Repositories\MatchRepository');
		$this->app->bind('skvosh.user_repository',       'App\Repositories\UserRepository');
	}

	/**
	 * Register the service provider.
	 * @return void
	 */
	public function register()
	{
	}

}
