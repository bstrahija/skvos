<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$env     = App::environment();
		$seeders = array(
			'local'      => array('UserSeeder',     'EventSeeder', 'MatchSeeder'),
			'production' => array('UserProdSeeder', 'EventSeeder', 'MatchSeeder')
		);

		foreach ($seeders[$env] as $seeder)
		{
			$this->call($seeder);
		}
	}

}
