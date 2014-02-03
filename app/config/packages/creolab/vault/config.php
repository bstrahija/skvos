<?php

return array(

	'alias' => 'Vault',

	'roles' => array(

		'player'     => array('level' => 1,   'name'  => 'Player'),
		'admin'      => array('level' => 100, 'name'  => 'Administrator'),
		'superadmin' => array('level' => 999, 'name'  => 'Super Admin'),

	),

	'views' => array(

		'forbidden' => 'krustr::errors.forbidden',

	),

);
