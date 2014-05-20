<?php namespace App\Services;

use Config;
use xmpphp\XMPP;
use JAXL;

class Notification {

	protected $connection;

	public function __construct()
	{
		$this->connection = new XMPP(
			Config::get('gtalk.url'),
			Config::get('gtalk.port'),
			Config::get('gtalk.username'),
			Config::get('gtalk.password'),
			'home', 'gmail.com', true, 4
		);
	}

	public function gtalkComment($email, $comment)
	{
		$this->send('bstrahija@gmail.com', 'This is a test message!');
		die();
	}

	public function send($email, $message)
	{
		echo '<pre>'; print_r(var_dump($this->connection)); echo '</pre>';
		// die();



		try
		{
			$this->connection->useEncryption(true);
			$this->connection->connect();
			$this->connection->processUntil('session_start', 10);
			$this->connection->presence();
			$this->connection->message($email, $message);
			$this->connection->disconnect();
		}

		catch (\Exception $e)
		{
			echo '<pre>'; print_r(var_dump($e->getMessage())); echo '</pre>';
			die();
		}
	}

}
