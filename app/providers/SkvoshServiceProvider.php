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
	}

	/**
	 * Register the service provider.
	 * @return void
	 */
	public function register()
	{
	}

}
