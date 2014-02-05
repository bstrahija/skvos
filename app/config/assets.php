<?php

return array(

	// ! Styles
	'app_css' => array(
		'assets' => array(
			'vendor/foundation/css/normalize.css',
			'vendor/foundation/css/foundation.css',
			'vendor/foundation/icons/foundation-icons.css',
			'vendor/font.awesome/css/font-awesome.min.css',
			'vendor/crajax/crajax.css',
			'css/app.css',
		),
		'name'    => 'app.css',
		'type'    => 'css',
		'combine' => false,
		'filters' => array(),
	),

	// ! Scripts
	'app_js' => array(
		'assets' => array(
			'vendor/jquery.js',
			'vendor/foundation/js/foundation.min.js',
			'vendor/knob.js',
			'vendor/crajax/crajax.js',
			'js/app.js',
			'js/events.js',
			'js/invitations.js',
			'js/matches.js',
			'js/stats.js',
			'js/init.js',
		),
		'name'    => 'app.js',
		'type'    => 'js',
		'combine' => false,
		'filters' => array(),
	),

);
