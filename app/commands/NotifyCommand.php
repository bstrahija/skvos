<?php namespace App\Commands;

use App, SSH;
use Events, Mailer;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class NotifyCommand extends Command {

	/**
	 * The console command name.
	 * @var string
	 */
	protected $name = 'skvosh:notify';

	/**
	 * The console command description.
	 * @var string
	 */
	protected $description = 'Send various notifications.';

	/**
	 * Execute the console command.
	 * @return void
	 */
	public function fire()
	{
		$this->info("Comment notifications.");
		$events = Events::upcoming();

		foreach ($events as $event)
		{
			Mailer::sendEventCommentNotifications($event->id);
			// $this->info("Sending for [" . $event->id . "] " . $event->title);
		}

		//echo '<pre>'; print_r($events->toArray()); echo '</pre>';

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
		return array();
	}

}
