<?php

use App\Models\User;

class UserSeeder extends Seeder {

	public function run()
	{
		DB::table('users')->delete();

		// ! Users
		User::create(array(
			'email'       => 'bstrahija@gmail.com',
			'password'    => Hash::make("cuje0byb"),
			'first_name'  => 'Boris',
			'last_name'   => 'Strahija',
			'role'        => 'admin',
		));
		User::create(array(
			'email'       => 'fffilo666@gmail.com',
			'password'    => Hash::make("ma5te0fi"),
			'first_name'  => 'Franjo',
			'last_name'   => 'Filo',
		));
		User::create(array(
			'email'       => 'srle@srle.net',
			'password'    => Hash::make("hq5teg4a"),
			'first_name'  => 'Srđan',
			'last_name'   => 'Srđenović',
		));
		User::create(array(
			'email'       => 'ivan.kanoti@gmail.com',
			'password'    => Hash::make("l05t30g2"),
			'first_name'  => 'Ivan',
			'last_name'   => 'Kanoti',
		));
		User::create(array(
			'email'       => 'info@zoranjambor.com',
			'password'    => Hash::make("g09to1g5"),
			'first_name'  => 'Zoran',
			'last_name'   => 'Jambor',
		));
	}

}
