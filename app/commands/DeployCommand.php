<?php namespace App\Commands;

use App, SSH;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class DeployCommand extends Command {

	/**
	 * The console command name.
	 * @var string
	 */
	protected $name = 'deploy';

	/**
	 * The console command description.
	 * @var string
	 */
	protected $description = 'Deploy the app.';

	/**
	 * Execute the console command.
	 * @return void
	 */
	public function fire()
	{
		// The target
		$target = $this->input->getArgument('target', 'development');

		// Target directory
		if ($target == 'production') $dir = '/var/www/skvosh.in';
		else                         $dir = '/var/www/dev.skvosh.in';

		$this->info("Deploying to $target...");
		$this->line("Target directory: [$dir] ...");

		SSH::into('ocean')->run(array(
			"cd $dir",
			"php artisan env",
			'php artisan down',
			'git fetch --all',
			'git reset --hard origin/develop',
			'chown -R www-data *',
			'chmod -R 0755 *',
			'chmod -R 0777 app/storage',
			'chmod -R 0777 public/storage',
			'composer install --no-scripts',
			'php artisan migrate',
			'php artisan up',
		));



		$this->info("Done.");
	}

	/**
	 * Get the console command options.
	 * @return array
	 */
	protected function getOptions()
	{
		return array();
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('target', InputArgument::OPTIONAL, 'The name of the environment target to publish to.'),
		);
	}

}
